<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;
use App\Modules\Tasks\Models\Task;
use App\Modules\Identity\Models\User;
use App\Modules\Admin\Models\SystemSetting;
use App\Modules\Workflow\Models\TaskActivityLog;
use App\Modules\Notifications\Notifications\DailyDelayedTasksNotification;
use App\Modules\Notifications\Notifications\DailyExecutionSummaryNotification;
use App\Modules\Notifications\Notifications\TaskDeadlineAlertNotification;
use App\Modules\Notifications\Notifications\TaskDeadlineDashboardNotification;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('tasks:send-delayed-alerts', function () {
    $delayedTasks = Task::query()
        ->with(['assignees', 'creator'])
        ->whereNotNull('due_date')
        ->whereDate('due_date', '<', now()->toDateString())
        ->where('status', '!=', 'done')
        ->get();

    $tasksByUser = collect();

    foreach ($delayedTasks as $task) {
        // Notify all assignees (the people the task is given to)
        foreach ($task->assignees as $assignee) {
            $existing = $tasksByUser->get($assignee->id, [
                'user' => $assignee,
                'tasks' => collect(),
            ]);

            $existing['tasks']->push($task);
            $tasksByUser->put($assignee->id, $existing);
        }

        // Notify the task creator (the one who gave/assigned the task)
        $creator = $task->creator;
        if ($creator instanceof User && !$tasksByUser->has($creator->id)) {
            $tasksByUser->put($creator->id, [
                'user' => $creator,
                'tasks' => collect([$task]),
            ]);
        } elseif ($creator instanceof User && $tasksByUser->has($creator->id)) {
            $existing = $tasksByUser->get($creator->id);
            if (!$existing['tasks']->contains('id', $task->id)) {
                $existing['tasks']->push($task);
                $tasksByUser->put($creator->id, $existing);
            }
        }
    }

    foreach ($tasksByUser as $payload) {
        if (isset($payload['user'], $payload['tasks'])) {
            $payload['user']->notify(new DailyDelayedTasksNotification($payload['tasks']));
        }
    }

    $this->info('Delayed task daily alerts sent to '.$tasksByUser->count().' user(s).');
})->purpose('Send daily delayed task email alerts to task assignees and task creators.');

Artisan::command('tasks:send-daily-execution-summary', function () {
    $now = now();
    $deadlineWindowEnd = $now->copy()->addDay();

    $baseQuery = Task::query()
        ->with(['assignees'])
        ->whereNotNull('due_date')
        ->where('status', '!=', 'done');

    $delayedTasks = (clone $baseQuery)
        ->whereDate('due_date', '<=', $now->toDateString())
        ->orderBy('due_date')
        ->get();

    $upcomingTasks = (clone $baseQuery)
        ->whereBetween('due_date', [$now->toDateString(), $deadlineWindowEnd->toDateString()])
        ->orderBy('due_date')
        ->get();

    $todayDeadlines = (clone $baseQuery)
        ->whereDate('due_date', $now->toDateString())
        ->orderBy('due_date')
        ->get();

    $delayedByTeam = $delayedTasks
        ->groupBy(fn (Task $task) => $task->team_in_charge ?: 'Unassigned Team')
        ->sortKeys();

    $ongoingCount = Task::query()->where('status', 'in_progress')->count();
    $activeCount = Task::query()->where('status', '!=', 'done')->count();

    $roleRecipients = User::query()
        ->whereIn('role', ['admin', 'manager'])
        ->whereNotNull('email')
        ->get();

    $settingRecipientsRaw = (string) SystemSetting::valueOf('daily_report_recipients', '');
    $settingEmails = collect(explode(',', $settingRecipientsRaw))
        ->map(fn (string $email) => trim($email))
        ->filter(fn (string $email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
        ->unique()
        ->values();

    $fallbackEmail = (string) env('DAILY_REPORT_EMAIL', '');

    if ($settingEmails->isEmpty() && $roleRecipients->isEmpty() && $fallbackEmail === '') {
        $this->warn('No admin/manager recipients found and DAILY_REPORT_EMAIL is not set.');
        return;
    }

    $reportDate = $now->format('F d, Y');
    $dashboardUrl = route('dashboard');

    foreach ($roleRecipients as $recipient) {
        $recipient->notify(
            (new DailyExecutionSummaryNotification(
                $delayedByTeam,
                $todayDeadlines,
                $ongoingCount,
                $activeCount,
                $dashboardUrl,
                $reportDate
            ))->setUpcomingWithin24Hours($upcomingTasks)
        );
    }

    foreach ($settingEmails as $email) {
        $settingSummary = (new DailyExecutionSummaryNotification(
            $delayedByTeam,
            $todayDeadlines,
            $ongoingCount,
            $activeCount,
            $dashboardUrl,
            $reportDate
        ))->setUpcomingWithin24Hours($upcomingTasks);

        $settingSummary->mailOnly = true;

        Notification::route('mail', $email)
            ->notify($settingSummary);
    }

    if ($fallbackEmail !== '') {
        $fallbackSummary = (new DailyExecutionSummaryNotification(
            $delayedByTeam,
            $todayDeadlines,
            $ongoingCount,
            $activeCount,
            $dashboardUrl,
            $reportDate
        ))->setUpcomingWithin24Hours($upcomingTasks);

        $fallbackSummary->mailOnly = true;

        Notification::route('mail', $fallbackEmail)
            ->notify($fallbackSummary);
    }

    $reportTasks = $delayedTasks
        ->merge($upcomingTasks)
        ->unique('id')
        ->values();

    $actorId = $roleRecipients->first()->id ?? User::query()->value('id');

    if (is_null($actorId)) {
        $this->warn('Daily summary sent, but no user available to record activity logs.');
        $this->info('Daily execution summary recipients: role users='.$roleRecipients->count().', configured emails='.$settingEmails->count().($fallbackEmail !== '' ? ' + fallback email' : '').'.');
        return;
    }

    foreach ($reportTasks as $task) {
        TaskActivityLog::create([
            'task_id' => $task->id,
            'actor_id' => $actorId,
            'action_type' => 'daily_execution_summary_sent',
            'old_value' => null,
            'new_value' => 'Summary emailed',
            'metadata' => [
                'report_date' => $reportDate,
                'recipient_count' => $roleRecipients->count() + $settingEmails->count() + ($fallbackEmail !== '' ? 1 : 0),
                'is_delayed' => $task->due_date ? $task->due_date->lte($now) : false,
            ],
        ]);
    }

    $this->info('Daily execution summary sent to role users='.$roleRecipients->count().', configured emails='.$settingEmails->count().($fallbackEmail !== '' ? ' + fallback email.' : '.'));
})->purpose('Send daily execution summary email to configured recipients, admin/manager users, and optional fallback email.');

Artisan::command('tasks:send-deadline-alerts', function () {
    $today = now()->startOfDay();
    $actorId = User::query()->whereIn('role', ['admin', 'manager'])->value('id') ?? User::query()->value('id');
    $personalAlertEmail = trim((string) SystemSetting::valueOf('personal_alert_email', (string) env('PERSONAL_ALERT_EMAIL', (string) env('DAILY_REPORT_EMAIL', ''))));
    $personalAlertEmail = filter_var($personalAlertEmail, FILTER_VALIDATE_EMAIL) ? $personalAlertEmail : '';
    $deadlineAlertBcc = trim((string) SystemSetting::valueOf('deadline_alert_bcc', (string) env('DEADLINE_ALERT_BCC', '')));
    $deadlineAlertBcc = filter_var($deadlineAlertBcc, FILTER_VALIDATE_EMAIL) ? $deadlineAlertBcc : '';
    $managerCcEmails = User::query()
        ->whereIn('role', ['manager', 'project_manager', 'pm', 'admin'])
        ->whereNotNull('email')
        ->pluck('email')
        ->map(fn ($email) => trim((string) $email))
        ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
        ->unique()
        ->values()
        ->all();

    $managerCcLower = collect($managerCcEmails)
        ->map(fn ($email) => strtolower(trim((string) $email)))
        ->all();

    $deadlineBccEmails = collect($deadlineAlertBcc !== '' ? [$deadlineAlertBcc] : [])
        ->merge(
            User::query()
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->map(fn ($email) => trim((string) $email))
                ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
                ->reject(fn ($email) => in_array(strtolower($email), $managerCcLower, true))
                ->reject(fn ($email) => $personalAlertEmail !== '' && strtolower($email) === strtolower($personalAlertEmail))
                ->take(3)
        )
        ->map(fn ($email) => trim((string) $email))
        ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
        ->reject(fn ($email) => in_array(strtolower($email), $managerCcLower, true))
        ->reject(fn ($email) => $personalAlertEmail !== '' && strtolower($email) === strtolower($personalAlertEmail))
        ->unique()
        ->values()
        ->all();

    $dashboardNotificationUsers = User::query()
        ->whereNotNull('email')
        ->get()
        ->filter(function (User $user) use ($managerCcEmails, $personalAlertEmail) {
            $email = strtolower(trim((string) $user->email));

            if ($email === '') {
                return false;
            }

            if ($personalAlertEmail !== '' && $email === strtolower($personalAlertEmail)) {
                return true;
            }

            return in_array($email, collect($managerCcEmails)->map(fn ($ccEmail) => strtolower($ccEmail))->all(), true);
        })
        ->keyBy('id');

    $tasks = Task::query()
        ->with(['assignees', 'creator'])
        ->whereNotNull('due_date')
        ->where('status', '!=', 'done')
        ->get();

    $sentCount = 0;

    foreach ($tasks as $task) {
        if (!$task instanceof Task) {
            continue;
        }

        $dueDate = $task->due_date?->copy()?->startOfDay();

        if (is_null($dueDate)) {
            continue;
        }

        $daysLeft = (int) $today->diffInDays($dueDate, false);
        $level = match (true) {
            strtolower((string) $task->priority) === 'urgent' && $daysLeft >= 0 && $daysLeft <= 1 => 'urgent',
            $daysLeft === 7 => 'warning',
            $daysLeft === 3 => 'critical',
            $daysLeft === 0 => 'reminder',
            default => null,
        };

        if (is_null($level)) {
            continue;
        }

        $taskRecipientCount = 0;
        $assigneeRecipientCount = 0;
        $notifiedEmails = [];
        $personalAlertSent = false;
        $creatorAlertSent = false;

        // Notify all assignees (the people the task is given to)
        foreach ($task->assignees as $assignee) {
            try {
                $assignee->notify(new TaskDeadlineAlertNotification($task, $level, $daysLeft, $managerCcEmails, $deadlineBccEmails));
                $sentCount++;
                $taskRecipientCount++;
                $assigneeRecipientCount++;
            } catch (\Throwable $e) {
                Log::error('Deadline alert failed for assignee: ' . $e->getMessage());
            }

            $assigneeEmail = strtolower(trim((string) ($assignee->email ?? '')));
            if ($assigneeEmail !== '') {
                $notifiedEmails[] = $assigneeEmail;
            }
        }

        // Notify the task creator (the one who gave/assigned the task)
        $creator = $task->creator;
        if ($creator instanceof User) {
            $creatorEmail = strtolower(trim((string) ($creator->email ?? '')));
            if ($creatorEmail !== '' && !in_array($creatorEmail, $notifiedEmails, true)) {
                try {
                    $creator->notify(new TaskDeadlineAlertNotification($task, $level, $daysLeft, $managerCcEmails, $deadlineBccEmails));
                    $sentCount++;
                    $taskRecipientCount++;
                    $creatorAlertSent = true;
                } catch (\Throwable $e) {
                    Log::error('Deadline alert failed for creator: ' . $e->getMessage());
                }
                $notifiedEmails[] = $creatorEmail;
            }
        }

        if ($personalAlertEmail !== '' && !in_array(strtolower($personalAlertEmail), $notifiedEmails, true)) {
            try {
                Notification::route('mail', $personalAlertEmail)
                    ->notify(new TaskDeadlineAlertNotification($task, $level, $daysLeft, $managerCcEmails, $deadlineBccEmails));
                $sentCount++;
                $taskRecipientCount++;
                $personalAlertSent = true;
            } catch (\Throwable $e) {
                Log::error('Deadline alert failed for personal email: ' . $e->getMessage());
            }
        }

        $dashboardNotifiedCount = 0;
        foreach ($dashboardNotificationUsers as $dashboardUser) {
            $dashboardEmail = strtolower(trim((string) $dashboardUser->email));

            if ($dashboardEmail === '' || in_array($dashboardEmail, $notifiedEmails, true)) {
                continue;
            }

            $dashboardUser->notify(new TaskDeadlineDashboardNotification($task, $level, $daysLeft));
            $dashboardNotifiedCount++;
        }

        if (!is_null($actorId) && $taskRecipientCount > 0) {
            TaskActivityLog::create([
                'task_id' => $task->id,
                'actor_id' => $actorId,
                'action_type' => 'deadline_alert_sent',
                'old_value' => null,
                'new_value' => strtoupper($level).' alert emailed',
                'metadata' => [
                    'level' => $level,
                    'days_left' => $daysLeft,
                    'due_date' => $dueDate->toDateString(),
                    'recipient_count' => $taskRecipientCount,
                    'assignee_recipient_count' => $assigneeRecipientCount,
                    'creator_alert_sent' => $creatorAlertSent,
                    'creator_email' => $creatorAlertSent ? ($creator->email ?? null) : null,
                    'personal_alert_sent' => $personalAlertSent,
                    'personal_alert_email' => $personalAlertSent ? $personalAlertEmail : null,
                    'dashboard_notified_count' => $dashboardNotifiedCount,
                    'bcc_email' => $deadlineAlertBcc !== '' ? $deadlineAlertBcc : null,
                    'alert_date' => $today->toDateString(),
                ],
            ]);
        }
    }

    $this->info('Task deadline alerts sent: '.$sentCount);
})->purpose('Send task deadline alerts (urgent within 24h for urgent priority, 7-day warning, 3-day critical, due-today reminder) to assignees and task creators.');

Artisan::command('tasks:send-overdue-reminders', function () {
    $today = now()->startOfDay();
    $actorId = User::query()->whereIn('role', ['admin', 'manager'])->value('id') ?? User::query()->value('id');
    $personalAlertEmail = trim((string) SystemSetting::valueOf('personal_alert_email', (string) env('PERSONAL_ALERT_EMAIL', (string) env('DAILY_REPORT_EMAIL', ''))));
    $personalAlertEmail = filter_var($personalAlertEmail, FILTER_VALIDATE_EMAIL) ? $personalAlertEmail : '';
    $deadlineAlertBcc = trim((string) SystemSetting::valueOf('deadline_alert_bcc', (string) env('DEADLINE_ALERT_BCC', '')));
    $deadlineAlertBcc = filter_var($deadlineAlertBcc, FILTER_VALIDATE_EMAIL) ? $deadlineAlertBcc : '';
    $managerCcEmails = User::query()
        ->whereIn('role', ['manager', 'project_manager', 'pm', 'admin'])
        ->whereNotNull('email')
        ->pluck('email')
        ->map(fn ($email) => trim((string) $email))
        ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
        ->unique()
        ->values()
        ->all();

    $managerCcLower = collect($managerCcEmails)
        ->map(fn ($email) => strtolower(trim((string) $email)))
        ->all();

    $deadlineBccEmails = collect($deadlineAlertBcc !== '' ? [$deadlineAlertBcc] : [])
        ->merge(
            User::query()
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->map(fn ($email) => trim((string) $email))
                ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
                ->reject(fn ($email) => in_array(strtolower($email), $managerCcLower, true))
                ->reject(fn ($email) => $personalAlertEmail !== '' && strtolower($email) === strtolower($personalAlertEmail))
                ->take(3)
        )
        ->map(fn ($email) => trim((string) $email))
        ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
        ->reject(fn ($email) => in_array(strtolower($email), $managerCcLower, true))
        ->reject(fn ($email) => $personalAlertEmail !== '' && strtolower($email) === strtolower($personalAlertEmail))
        ->unique()
        ->values()
        ->all();

    $tasks = Task::query()
        ->with(['assignees', 'creator'])
        ->whereNotNull('due_date')
        ->where('status', '!=', 'done')
        ->get();

    $sentCount = 0;

    foreach ($tasks as $task) {
        if (!$task instanceof Task) {
            continue;
        }

        $dueDate = $task->due_date?->copy()?->startOfDay();

        if (is_null($dueDate)) {
            continue;
        }

        $daysLeft = $today->diffInDays($dueDate, false);

        if ($daysLeft >= 0) {
            continue;
        }

        $level = 'overdue';
        $taskRecipientCount = 0;
        $assigneeRecipientCount = 0;
        $notifiedEmails = [];
        $personalAlertSent = false;
        $creatorAlertSent = false;

        // Notify all assignees (the people the task is given to)
        foreach ($task->assignees as $assignee) {
            try {
                $assignee->notify(new TaskDeadlineAlertNotification($task, $level, $daysLeft, $managerCcEmails, $deadlineBccEmails));
                $sentCount++;
                $taskRecipientCount++;
                $assigneeRecipientCount++;
            } catch (\Throwable $e) {
                Log::error('Overdue alert failed for assignee: ' . $e->getMessage());
            }

            $assigneeEmail = strtolower(trim((string) ($assignee->email ?? '')));
            if ($assigneeEmail !== '') {
                $notifiedEmails[] = $assigneeEmail;
            }
        }

        // Notify the task creator (the one who gave/assigned the task)
        $creator = $task->creator;
        if ($creator instanceof User) {
            $creatorEmail = strtolower(trim((string) ($creator->email ?? '')));
            if ($creatorEmail !== '' && !in_array($creatorEmail, $notifiedEmails, true)) {
                try {
                    $creator->notify(new TaskDeadlineAlertNotification($task, $level, $daysLeft, $managerCcEmails, $deadlineBccEmails));
                    $sentCount++;
                    $taskRecipientCount++;
                    $creatorAlertSent = true;
                } catch (\Throwable $e) {
                    Log::error('Overdue alert failed for creator: ' . $e->getMessage());
                }
                $notifiedEmails[] = $creatorEmail;
            }
        }

        if ($personalAlertEmail !== '' && !in_array(strtolower($personalAlertEmail), $notifiedEmails, true)) {
            try {
                Notification::route('mail', $personalAlertEmail)
                    ->notify(new TaskDeadlineAlertNotification($task, $level, $daysLeft, $managerCcEmails, $deadlineBccEmails));
                $sentCount++;
                $taskRecipientCount++;
                $personalAlertSent = true;
            } catch (\Throwable $e) {
                Log::error('Overdue alert failed for personal email: ' . $e->getMessage());
            }
        }

        if (!is_null($actorId) && $taskRecipientCount > 0) {
            TaskActivityLog::create([
                'task_id' => $task->id,
                'actor_id' => $actorId,
                'action_type' => 'overdue_reminder_sent',
                'old_value' => null,
                'new_value' => 'OVERDUE reminder emailed',
                'metadata' => [
                    'level' => $level,
                    'days_left' => $daysLeft,
                    'due_date' => $dueDate->toDateString(),
                    'recipient_count' => $taskRecipientCount,
                    'assignee_recipient_count' => $assigneeRecipientCount,
                    'creator_alert_sent' => $creatorAlertSent,
                    'creator_email' => $creatorAlertSent ? ($creator->email ?? null) : null,
                    'personal_alert_sent' => $personalAlertSent,
                    'personal_alert_email' => $personalAlertSent ? $personalAlertEmail : null,
                    'bcc_email' => $deadlineAlertBcc !== '' ? $deadlineAlertBcc : null,
                    'alert_date' => $today->toDateString(),
                ],
            ]);
        }
    }

    SystemSetting::setValue('overdue_reminder_last_run_at', now()->toDateTimeString());
    SystemSetting::setValue('overdue_reminder_last_sent_count', (string) $sentCount);

    $this->info('Overdue task reminders sent: '.$sentCount);
})->purpose('Send automatic email reminders for overdue tasks to assignees and task creators.');

Schedule::command('automation:run-daily')->dailyAt('08:00');
Schedule::command('tasks:send-delayed-alerts')->dailyAt('08:00');
Schedule::command('tasks:send-daily-execution-summary')->dailyAt('08:00');
Schedule::command('tasks:send-deadline-alerts')->dailyAt('08:00');
Schedule::command('tasks:send-overdue-reminders')->dailyAt('08:15');
