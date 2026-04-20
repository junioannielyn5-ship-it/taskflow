<?php
use App\Modules\Projects\Http\Controllers\ProjectController;
use App\Modules\Reporting\Http\Controllers\ReportController;
use App\Modules\Admin\Http\Controllers\AdminController;
use App\Modules\Admin\Http\Controllers\ManagerController;
use App\Modules\Admin\Http\Controllers\EmployeeController;
use App\Modules\Admin\Http\Controllers\ExecutiveController;
use App\Modules\Admin\Http\Controllers\ProjectManagerController;
use App\Modules\Admin\Http\Controllers\LeadController;
use App\Modules\Admin\Http\Controllers\AdminConfigurationController;
use App\Modules\Admin\Http\Controllers\ChatbotKnowledgeController;
use App\Http\Controllers\RoleLoginController;
use App\Modules\Attachments\Http\Controllers\AttachmentController;
use App\Modules\Tasks\Http\Controllers\TaskTimeLogController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Modules\Identity\Models\User;
use App\Modules\Tasks\Models\Task;
use App\Modules\Admin\Models\SystemSetting;
use App\Modules\Admin\Models\ChatbotKnowledge;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('tasks.kanban');
    }

    return redirect('/login');
})->name('home');

Route::get('/login-preview', function (Request $request) {
    return Inertia::render('auth/login', [
        'canResetPassword' => Features::enabled(Features::resetPasswords()),
        'canRegister' => Features::enabled(Features::registration()),
        'status' => $request->session()->get('status'),
    ]);
})->name('login.preview');

Route::get('/logout', function (Request $request) {
    if (Auth::check()) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return redirect('/login');
})->name('logout.get');

Route::middleware('guest')->group(function () {
    Route::get('/login/roles', [RoleLoginController::class, 'launcher'])->name('role.login.launcher');
    Route::get('/login/{role}', [RoleLoginController::class, 'show'])->name('role.login.show');
    Route::post('/login/{role}', [RoleLoginController::class, 'login'])->name('role.login.attempt');
});


use App\Modules\Reporting\Http\Controllers\DashboardController;
use App\Modules\Notifications\Http\Controllers\NotificationController;

use App\Modules\Tasks\Http\Controllers\TaskController;
use App\Modules\Tasks\Http\Controllers\TaskActivityController;
use App\Modules\Tasks\Http\Controllers\TaskCalendarController;
use App\Modules\Tasks\Http\Controllers\TaskChecklistController;
use App\Modules\Workflow\Http\Controllers\MeetingController;
use App\Modules\Workflow\Http\Controllers\HolidayController;

Route::middleware(['auth', 'verified'])->group(function () {
    $isDeliverableEmail = static function (mixed $email): bool {
        $normalized = strtolower(trim((string) $email));

        if ($normalized === '' || ! filter_var($normalized, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $domain = (string) str($normalized)->after('@');
        $blockedDomains = ['example.com', 'example.org', 'example.net', 'local', 'localhost'];

        if (in_array($domain, $blockedDomains, true)) {
            return false;
        }

        return ! str_ends_with($domain, '.local') && ! str_ends_with($domain, '.test');
    };

    Route::get('/gmail', fn () => redirect()->route('email.shortcut'))->name('gmail.shortcut');
    Route::get('/emailmanager', fn () => redirect()->route('email.shortcut'))->name('email.manager.shortcut');
    Route::get('/email-manager', fn () => redirect()->route('email.shortcut'))->name('email.manager.shortcut.hyphen');
    Route::get('/emailadmin', fn () => redirect()->route('email.shortcut'))->name('email.admin.shortcut');
    Route::get('/email-admin', fn () => redirect()->route('email.shortcut'))->name('email.admin.shortcut.hyphen');
    Route::get('/emailmember', fn () => redirect()->route('email.shortcut'))->name('email.member.shortcut');
    Route::get('/email-member', fn () => redirect()->route('email.shortcut'))->name('email.member.shortcut.hyphen');
    Route::get('/emailmailto:{address}', fn () => redirect()->route('email.shortcut'))
        ->where('address', '.*')
        ->name('email.mailto.shortcut');
    Route::get('/email{role}@{domain}', fn () => redirect()->route('email.shortcut'))
        ->where('role', 'manager|admin|system|projectmanager|project-manager|executive|lead|member')
        ->where('domain', '.*')
        ->name('email.role-address.shortcut');

    Route::get('/email-box', fn () => redirect()->route('email.shortcut'))->name('email.shortcut.box');
    Route::get('/emailbox', fn () => redirect()->route('email.shortcut'))->name('email.shortcut.box.compact');
    Route::get('/{legacyEmailAlias}', fn () => redirect()->route('email.shortcut'))
            ->where('legacyEmailAlias', '(?:\s+)?(?:dev(?:\s|-|_)+)?(?:e?mail|mail|gmail)(?:(?:\s|-|_)*(?:box|manager|admin|system|project(?:\s|-|_)?manager|executive|lead|member))')
        ->name('email.shortcut.legacy');

    Route::get('/email', function (Request $request) use ($isDeliverableEmail) {
        if (app()->environment('local')) {
            $recipient = (string) ($request->query('to') ?: $request->user()?->email);

            if ($recipient !== '' && $request->boolean('send_test')) {
                return redirect()->route('dev.test-email', ['to' => $recipient]);
            }
        }

        $today = now()->startOfDay();
        $tasks = Task::query()
            ->with(['project:id,name', 'assignees:id,name'])
            ->whereNotNull('due_date')
            ->where('status', '!=', 'done')
            ->get();

        $levels = [
            'warning' => collect(),
            'critical' => collect(),
            'reminder' => collect(),
            'overdue' => collect(),
        ];

        foreach ($tasks as $task) {
            $dueDate = $task->due_date?->copy()?->startOfDay();

            if (is_null($dueDate)) {
                continue;
            }

            $daysLeft = (int) $today->diffInDays($dueDate, false);

            $level = match (true) {
                $daysLeft === 7 => 'warning',
                $daysLeft === 3 => 'critical',
                $daysLeft === 0 => 'reminder',
                $daysLeft < 0 => 'overdue',
                default => null,
            };

            if (is_null($level)) {
                continue;
            }

            $levels[$level]->push($task);
        }

        $fromName = (string) config('mail.from.name', 'Movaflex Task Manager');
        $fromAddress = (string) config('mail.from.address', 'noreply@example.com');

        $dailyReportRecipientsRaw = trim((string) SystemSetting::valueOf('daily_report_recipients', ''));
        $personalAlertEmail = trim((string) SystemSetting::valueOf('personal_alert_email', env('PERSONAL_ALERT_EMAIL', '')));
        $deadlineAlertBcc = trim((string) SystemSetting::valueOf('deadline_alert_bcc', env('DEADLINE_ALERT_BCC', '')));
        $overdueLastRunAt = trim((string) SystemSetting::valueOf('overdue_reminder_last_run_at', ''));
        $overdueLastSentCount = trim((string) SystemSetting::valueOf('overdue_reminder_last_sent_count', '0'));

        $toPreview = collect([
            $request->user()?->email,
            $personalAlertEmail,
        ])
            ->map(fn ($email) => trim((string) $email))
            ->filter($isDeliverableEmail)
            ->filter()
            ->unique()
            ->values();

        $configuredCcPreview = collect(explode(',', $dailyReportRecipientsRaw))
            ->map(fn ($email) => trim((string) $email))
            ->filter($isDeliverableEmail)
            ->filter();

        $roleCcPreview = User::query()
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->where(function ($query) {
                $query->whereIn('role', ['manager', 'admin'])
                    ->orWhereHas('roles', fn ($roleQuery) => $roleQuery->whereIn('name', ['manager', 'admin']));
            })
            ->pluck('email')
            ->map(fn ($email) => trim((string) $email))
            ->filter($isDeliverableEmail)
            ->filter();

        $ccPreview = $configuredCcPreview
            ->merge($roleCcPreview)
            ->filter(fn ($email) => ! $toPreview->contains($email))
            ->unique()
            ->values();

        $fallbackBccFromDb = User::query()
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->pluck('email')
            ->map(fn ($email) => trim((string) $email))
            ->filter($isDeliverableEmail)
            ->filter(fn ($email) => ! $toPreview->contains($email))
            ->filter(fn ($email) => ! $ccPreview->contains($email))
            ->unique()
            ->first() ?? '';

        $bccPreview = $isDeliverableEmail($deadlineAlertBcc)
            && ! $toPreview->contains($deadlineAlertBcc)
            && ! $ccPreview->contains($deadlineAlertBcc)
            ? $deadlineAlertBcc
            : $fallbackBccFromDb;

        $departmentContacts = [
            'Pre-Sales' => [
                'Ronnel Gusi',
                'Samuel Tabuzo',
            ],
            'Sales' => [
                'Lawrence Solee',
                'Norman Reyes',
            ],
            'Technical' => [
                'Edcel Ching',
                'Rupert Moreno',
                'Ronnel Gusi',
                'Samuel Tabuzo',
                'Jobert Vallejos',
                'Reuben Guevara',
                'Jomer Delgado',
                'Ryan Fallan',
                'Carlo Roldan',
            ],
            'Admin Support' => [
                'Philip Borromeo',
                'Jen Borromeo',
                'Pierre Borromeo',
                'Kacey Arigo',
                'Reagan Timblaco',
                'Yna Garrote',
            ],
        ];

        $contactNames = collect($departmentContacts)
            ->flatten()
            ->unique()
            ->values();

        $contactEmailMap = User::query()
            ->whereIn('name', $contactNames)
            ->whereNotNull('email')
            ->pluck('email', 'name');

        $departmentEmailDirectory = collect($departmentContacts)
            ->map(function (array $names, string $department) use ($contactEmailMap) {
                return [
                    'department' => $department,
                    'members' => collect($names)->map(function (string $name) use ($contactEmailMap) {
                        $email = trim((string) ($contactEmailMap[$name] ?? ''));

                        return [
                            'name' => $name,
                            'email' => $email,
                        ];
                    })->values(),
                ];
            })
            ->values();

        return view('emails.deadline-levels', [
            'today' => $today,
            'warningTasks' => $levels['warning'],
            'criticalTasks' => $levels['critical'],
            'reminderTasks' => $levels['reminder'],
            'overdueTasks' => $levels['overdue'],
            'fromPreview' => trim($fromName.' <'.$fromAddress.'>'),
            'toPreview' => $toPreview,
            'ccPreview' => $ccPreview,
            'bccPreview' => $bccPreview,
            'departmentEmailDirectory' => $departmentEmailDirectory,
            'overdueReminderLastRunAt' => $overdueLastRunAt,
            'overdueReminderLastSentCount' => (int) $overdueLastSentCount,
        ]);
    })->name('email.shortcut');

    Route::post('/chatbot/query', function (Request $request) {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:1000'],
            'language' => ['nullable', 'string', 'in:en,fil'],
        ]);

        $question = strtolower(trim((string) $validated['question']));
        $language = (string) ($validated['language'] ?? 'en');

        $normalizedQuestion = str_replace(['_', '-'], ' ', $question);
        $containsAny = function (string $haystack, array $needles): bool {
            foreach ($needles as $needle) {
                if ($needle !== '' && str_contains($haystack, $needle)) {
                    return true;
                }
            }

            return false;
        };

        $hasPreSales = (bool) preg_match('/\bpre\s*sales?\b|\bpresales\b/', $normalizedQuestion);
        $hasSales = (bool) preg_match('/\bsales\b/', $normalizedQuestion) && ! $hasPreSales;
        $hasTechnical = (bool) preg_match('/\btechnical\b|\btech\b/', $normalizedQuestion);
        $hasAdminSupport = (bool) preg_match('/\badmin\s*(and\s*)?support\b/', $normalizedQuestion);

        $wantsSteps = $containsAny($normalizedQuestion, [
            'step by step',
            'step-by-step',
            'steps',
            'process',
            'workflow',
            'proseso',
            'hakbang',
            'syep by step',
        ]);

        $matchedDepartmentCount = (int) $hasPreSales + (int) $hasSales + (int) $hasTechnical + (int) $hasAdminSupport;
        $wantsDepartmentGuide = $matchedDepartmentCount > 0
            || $containsAny($normalizedQuestion, ['department', 'team', 'lahat', 'all departments', 'all team']);

        $departmentGuides = [
            'pre_sales' => [
                'title_en' => 'Pre-Sales Step-by-Step Guide',
                'summary_en' => 'Use this flow for incoming pre-sales requests and qualification.',
                'steps_en' => [
                    'Open Tasks > Create Task and select the correct project/client.',
                    'Set Task Process as Quotation/For Quote and choose the specific process.',
                    'Set Person-in-charge to a Pre-Sales contact and assign the assignee(s).',
                    'Add deliverables, remarks, and due date, then click Create Task.',
                    'Track progress in Kanban until handoff to Sales/Technical.',
                ],
                'title_fil' => 'Pre-Sales Step-by-Step Guide',
                'summary_fil' => 'Gamitin ang flow na ito para sa incoming pre-sales requests at qualification.',
                'steps_fil' => [
                    'Pumunta sa Tasks > Create Task at piliin ang tamang project/client.',
                    'I-set ang Task Process sa Quotation/For Quote at piliin ang specific process.',
                    'I-set ang Person-in-charge sa Pre-Sales contact at piliin ang assignee(s).',
                    'Ilagay ang deliverables, remarks, at due date, tapos click Create Task.',
                    'I-track ang progress sa Kanban hanggang handoff sa Sales/Technical.',
                ],
            ],
            'sales' => [
                'title_en' => 'Sales Step-by-Step Guide',
                'summary_en' => 'Use this flow for proposal follow-up, endorsement, and closing updates.',
                'steps_en' => [
                    'Open Tasks list and filter by Sales or project/client.',
                    'Review pre-sales handoff details and required deliverables.',
                    'Update status from To-do to In-Progress as execution starts.',
                    'Coordinate required documents/quotes and update remarks regularly.',
                    'Move task to Done when fully completed and validated.',
                ],
                'title_fil' => 'Sales Step-by-Step Guide',
                'summary_fil' => 'Gamitin ang flow na ito para sa proposal follow-up, endorsement, at closing updates.',
                'steps_fil' => [
                    'Buksan ang Tasks list at i-filter sa Sales o specific project/client.',
                    'I-review ang handoff details mula pre-sales at required deliverables.',
                    'I-update ang status mula To-do papuntang In-Progress kapag nagsimula na.',
                    'I-coordinate ang documents/quotes at i-update lagi ang remarks.',
                    'Ilipat sa Done kapag kumpleto at validated na ang output.',
                ],
            ],
            'technical' => [
                'title_en' => 'Technical Step-by-Step Guide',
                'summary_en' => 'Use this flow for implementation, engineering tasks, and technical delivery.',
                'steps_en' => [
                    'Open assigned tasks from Tasks page or Dashboard.',
                    'Check scope, dependency (Blocked By), and target due date before starting.',
                    'Set status to In-Progress and update remarks/checklist while working.',
                    'Upload proof/documents and finalize deliverables in task details.',
                    'Mark as Done only after validation/testing and handoff confirmation.',
                ],
                'title_fil' => 'Technical Step-by-Step Guide',
                'summary_fil' => 'Gamitin ang flow na ito para sa implementation, engineering tasks, at technical delivery.',
                'steps_fil' => [
                    'Buksan ang assigned tasks sa Tasks page o Dashboard.',
                    'I-check ang scope, dependency (Blocked By), at target due date bago mag-start.',
                    'I-set sa In-Progress at i-update ang remarks/checklist habang gumagawa.',
                    'I-upload ang proof/documents at i-finalize ang deliverables sa task details.',
                    'I-mark as Done lang kapag tapos na ang validation/testing at handoff.',
                ],
            ],
            'admin_support' => [
                'title_en' => 'Admin Support Step-by-Step Guide',
                'summary_en' => 'Use this flow for documentation, coordination, and support follow-through.',
                'steps_en' => [
                    'Open the task and verify requested admin/support requirements.',
                    'Prepare required documents (COC, invoices, forms, or internal records).',
                    'Update remarks and attach files/links as each requirement is completed.',
                    'Coordinate with requestor/team lead for confirmation and pending items.',
                    'Set task to Done after all support deliverables are complete.',
                ],
                'title_fil' => 'Admin Support Step-by-Step Guide',
                'summary_fil' => 'Gamitin ang flow na ito para sa documentation, coordination, at support follow-through.',
                'steps_fil' => [
                    'Buksan ang task at i-verify ang admin/support requirements.',
                    'I-prepare ang needed documents (COC, invoices, forms, o internal records).',
                    'I-update ang remarks at mag-attach ng files/links bawat completed requirement.',
                    'Makipag-coordinate sa requestor/team lead para sa confirmation at pending items.',
                    'I-set ang task sa Done kapag kumpleto na lahat ng support deliverables.',
                ],
            ],
        ];

        if ($wantsDepartmentGuide && ($wantsSteps || $matchedDepartmentCount > 0)) {
            $selectedKey = null;

            if ($hasPreSales) {
                $selectedKey = 'pre_sales';
            } elseif ($hasSales) {
                $selectedKey = 'sales';
            } elseif ($hasTechnical) {
                $selectedKey = 'technical';
            } elseif ($hasAdminSupport) {
                $selectedKey = 'admin_support';
            }

            if ($matchedDepartmentCount >= 2 || $selectedKey === null) {
                return response()->json([
                    'ok' => true,
                    'data' => [
                        'title' => $language === 'fil' ? 'Department Step-by-Step Guide' : 'Department Step-by-Step Guide',
                        'summary' => $language === 'fil'
                            ? 'Piliin ang specific team para sa eksaktong step-by-step: Pre-Sales, Sales, Technical, Admin Support.'
                            : 'Ask for a specific team to get exact step-by-step guidance: Pre-Sales, Sales, Technical, Admin Support.',
                        'steps' => $language === 'fil'
                            ? [
                                'Sabihin kung anong team: Pre-Sales, Sales, Technical, o Admin Support.',
                                'Pwede rin itanong: "step by step ng technical" o "process ng sales".',
                                'Magbibigay ang chatbot ng detailed na steps para sa napiling team.',
                            ]
                            : [
                                'Specify the team: Pre-Sales, Sales, Technical, or Admin Support.',
                                'You can ask: "technical step by step" or "sales process".',
                                'The chatbot will return detailed steps for the selected team.',
                            ],
                        'links' => [
                            ['label' => 'Open Tasks', 'url' => route('tasks.list')],
                            ['label' => 'Create Task', 'url' => route('tasks.create')],
                            ['label' => 'Open Kanban', 'url' => route('tasks.kanban')],
                        ],
                    ],
                ]);
            }

            $guide = $departmentGuides[$selectedKey];

            return response()->json([
                'ok' => true,
                'data' => [
                    'title' => $language === 'fil' ? $guide['title_fil'] : $guide['title_en'],
                    'summary' => $language === 'fil' ? $guide['summary_fil'] : $guide['summary_en'],
                    'steps' => $language === 'fil' ? $guide['steps_fil'] : $guide['steps_en'],
                    'links' => [
                        ['label' => 'Open Tasks', 'url' => route('tasks.list')],
                        ['label' => 'Create Task', 'url' => route('tasks.create')],
                        ['label' => 'Open Kanban', 'url' => route('tasks.kanban')],
                    ],
                ],
            ]);
        }

        $rows = ChatbotKnowledge::query()
            ->where('is_active', true)
            ->where('language', $language)
            ->orderBy('sort_order')
            ->get();

        if ($rows->isEmpty() && $language !== 'en') {
            $rows = ChatbotKnowledge::query()
                ->where('is_active', true)
                ->where('language', 'en')
                ->orderBy('sort_order')
                ->get();
        }

        $best = null;
        $bestScore = 0.0;

        foreach ($rows as $row) {
            $keywords = collect($row->keywords ?? [])
                ->map(fn ($k) => strtolower(trim((string) $k)))
                ->filter(fn ($k) => $k !== '')
                ->values();

            $score = 0.0;

            foreach ($keywords as $keyword) {
                if (str_contains($question, $keyword)) {
                    $score += max(1.0, strlen($keyword) / 6);
                }
            }

            if ($score > $bestScore) {
                $best = $row;
                $bestScore = $score;
            }
        }

        if (!$best) {
            $best = $rows->firstWhere('intent', 'website_overview') ?? $rows->first();
        }

        if (!$best) {
            return response()->json([
                'ok' => true,
                'data' => [
                    'title' => $language === 'fil' ? 'Walang Data' : 'No Data',
                    'summary' => $language === 'fil'
                        ? 'Wala pang chatbot knowledge sa database. Paki-seed muna ang chatbot data.'
                        : 'No chatbot knowledge found in database. Please seed chatbot data first.',
                    'steps' => [],
                    'links' => [],
                ],
            ]);
        }

        return response()->json([
            'ok' => true,
            'data' => [
                'title' => $best->title,
                'summary' => $best->summary,
                'steps' => collect($best->steps ?? [])->values()->all(),
                'links' => collect($best->links ?? [])->values()->all(),
            ],
        ]);
    })->name('chatbot.query');

    Route::get('/https:{garbled}', function (Request $request, string $garbled) {
        abort_unless(app()->environment('local'), 404);

        if (str_contains($garbled, 'test-email')) {
            return redirect()->route('dev.test-email', [
                'to' => $request->query('to'),
            ]);
        }

        // Recover from accidentally pasted full local URLs like /https://.../emailmember.
        if (str_contains($garbled, 'email')) {
            return redirect()->route('email.shortcut');
        }

        abort(404);
    })->where('garbled', '.*')->name('dev.test-email.malformed');

    Route::get('/test-email', function (Request $request) {
        abort_unless(app()->environment('local'), 404);

        return redirect()->route('dev.test-email', [
            'to' => $request->query('to'),
        ]);
    })->name('dev.test-email.shortcut');

    Route::get('/dev/test-email', function (Request $request) {
        abort_unless(app()->environment('local'), 404);

        $validated = $request->validate([
            'to' => ['required', 'email'],
        ]);

        try {
            Mail::raw('Gmail SMTP test from Movaflex Task Manager.', function ($message) use ($validated) {
                $message->to($validated['to'])
                    ->subject('SMTP Test Email');
            });
        } catch (\Throwable $exception) {
            if (! $request->expectsJson()) {
                return response()->view('dev.test-email-result', [
                    'status' => 'error',
                    'message' => 'SMTP authentication failed. Use a valid Gmail App Password (16 characters) and ensure 2-Step Verification is enabled.',
                    'to' => $validated['to'],
                    'error' => $exception->getMessage(),
                ], 422);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'SMTP authentication failed. Use a valid Gmail App Password (16 characters) and ensure 2-Step Verification is enabled.',
                'to' => $validated['to'],
                'error' => $exception->getMessage(),
            ], 422);
        }

        if (! $request->expectsJson()) {
            return view('dev.test-email-result', [
                'status' => 'ok',
                'message' => 'Test email sent successfully.',
                'to' => $validated['to'],
                'error' => null,
            ]);
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'Test email sent successfully.',
            'to' => $validated['to'],
        ]);
    })->name('dev.test-email');

    Route::get('/dev/test-email-all', function (Request $request) use ($isDeliverableEmail) {
        abort_unless(app()->environment('local'), 404);

        $validated = $request->validate([
            'subject' => ['nullable', 'string', 'max:150'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        $subject = $validated['subject'] ?? 'SMTP Test Email (All Users)';
        $body = $validated['message'] ?? 'Gmail SMTP broadcast test from Movaflex Task Manager.';

        $emails = User::query()
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->pluck('email')
            ->map(fn ($email) => trim((string) $email))
            ->filter($isDeliverableEmail)
            ->filter()
            ->unique()
            ->values();

        if ($emails->isEmpty()) {
            if (! $request->expectsJson()) {
                return redirect()->route('email.shortcut')->withErrors([
                    'broadcast_email' => 'No recipients found.',
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'No recipients found.',
                'sent_count' => 0,
            ], 422);
        }

        $sender = $request->user()?->email ?? $emails->first();

        try {
            Mail::raw($body, function ($mail) use ($emails, $sender, $subject) {
                $mail->to($sender)
                    ->bcc($emails->all())
                    ->subject($subject);
            });
        } catch (\Throwable $exception) {
            if (! $request->expectsJson()) {
                return redirect()->route('email.shortcut')->withErrors([
                    'broadcast_email' => 'SMTP authentication failed. Use a valid Gmail App Password (16 characters) and ensure 2-Step Verification is enabled.',
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'SMTP authentication failed. Use a valid Gmail App Password (16 characters) and ensure 2-Step Verification is enabled.',
                'sent_count' => 0,
                'error' => $exception->getMessage(),
            ], 422);
        }

        if (! $request->expectsJson()) {
            return redirect()->route('email.shortcut')->with('status', 'Test email sent to all recipients successfully. Sent count: '.$emails->count());
        }

        return response()->json([
            'status' => 'ok',
            'message' => 'Test email sent to all recipients successfully.',
            'sent_count' => $emails->count(),
        ]);
    })->name('dev.test-email-all');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/history', [NotificationController::class, 'history'])->name('notifications.history');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/dashboard/advanced', [DashboardController::class, 'advanced'])->name('dashboard.advanced');
    Route::get('/dashboard/notifications/unread', [DashboardController::class, 'unreadNotifications'])->name('dashboard.notifications.unread');
    Route::get('/dashboard/metrics', [DashboardController::class, 'metrics'])->name('dashboard.metrics');
    Route::get('/dashboard/export/status-overview.csv', [DashboardController::class, 'exportStatusOverviewCsv'])->name('dashboard.export.status-overview.csv');
    Route::get('/dashboard/export/status-overview.pdf', [DashboardController::class, 'exportStatusOverviewPdf'])->name('dashboard.export.status-overview.pdf');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Audit Logs
    Route::get('/audit-logs', [\App\Http\Controllers\AuditLogController::class, 'index'])->name('audit-logs.index');

    // Tasks routes
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.list');
    Route::get('/tasks/kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
    Route::get('/tasks/calendar', [TaskCalendarController::class, 'index'])->name('tasks.calendar');
    Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings.index');
    Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.quickStore');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->whereNumber('task')->name('tasks.edit');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->whereNumber('task')->name('tasks.show');
    Route::get('/tasks/{task}/activities', [TaskActivityController::class, 'index'])->whereNumber('task')->name('tasks.activities');
    Route::get('/tasks/{task}/timeline', [TaskActivityController::class, 'index'])->whereNumber('task')->name('tasks.timeline');
    Route::get('/api/tasks/{task}/activity', [TaskActivityController::class, 'index'])->whereNumber('task')->name('tasks.activity.api');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->whereNumber('task')->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->whereNumber('task')->name('tasks.destroy');
    Route::post('/tasks/{task}/attachments', [AttachmentController::class, 'store'])->whereNumber('task')->name('tasks.attachments.store');
    Route::get('/attachments/{attachment}/download', [AttachmentController::class, 'download'])->whereNumber('attachment')->name('attachments.download');
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->whereNumber('attachment')->name('attachments.destroy');
    Route::post('/tasks/{task}/timer/start', [TaskTimeLogController::class, 'start'])->whereNumber('task')->name('tasks.timer.start');
    Route::post('/tasks/{task}/timer/stop', [TaskTimeLogController::class, 'stop'])->whereNumber('task')->name('tasks.timer.stop');
    Route::post('/tasks/{task}/checklists', [TaskChecklistController::class, 'store'])->whereNumber('task')->name('tasks.checklists.store');
    Route::patch('/tasks/{task}/checklists/{item}', [TaskChecklistController::class, 'toggle'])->whereNumber('task')->whereNumber('item')->name('tasks.checklists.toggle');
    Route::delete('/tasks/{task}/checklists/{item}', [TaskChecklistController::class, 'destroy'])->whereNumber('task')->whereNumber('item')->name('tasks.checklists.destroy');

    // Projects routes (add create form route)
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

    // Reports pages/exports (restricted to non-member elevated roles)
    Route::middleware(['role:admin,manager,project_manager,pm,lead,executive'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export/overdue.csv', [ReportController::class, 'exportOverdueCsv'])->name('reports.export.overdue.csv');
        Route::get('/reports/export/completed.csv', [ReportController::class, 'exportCompletedCsv'])->name('reports.export.completed.csv');
        Route::get('/reports/export/overdue.pdf', [ReportController::class, 'exportOverduePdf'])->name('reports.export.overdue.pdf');
        Route::get('/reports/export/completed.pdf', [ReportController::class, 'exportCompletedPdf'])->name('reports.export.completed.pdf');
    });

    // Reporting data endpoints (viewer-scoped)
        Route::get('/reports/overdue', [ReportController::class, 'overdue'])->name('reports.overdue');
        Route::get('/reports/overdue-by-assignee', [ReportController::class, 'overdueByAssignee'])->name('reports.overdue-by-assignee');
        Route::get('/reports/completed', [ReportController::class, 'completed'])->name('reports.completed');
        Route::get('/reports/cycle-time', [ReportController::class, 'cycleTime'])->name('reports.cycle-time');

    // Custom assign/unassign routes
    Route::post('/tasks/{task}/assign', [TaskController::class, 'assign'])->whereNumber('task')->name('tasks.assign');
    Route::delete('/tasks/{task}/unassign/{userId}', [TaskController::class, 'unassign'])->whereNumber('task')->name('tasks.unassign');

    Route::middleware(['role:manager,admin,member'])->group(function () use ($isDeliverableEmail) {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // User management
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');

        Route::post('/admin/email/broadcast', function (Request $request) use ($isDeliverableEmail) {
            $validated = $request->validate([
                'subject' => ['required', 'string', 'max:150'],
                'message' => ['required', 'string', 'max:5000'],
            ]);

            $emails = User::query()
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->pluck('email')
                ->map(fn ($email) => trim((string) $email))
                ->filter($isDeliverableEmail)
                ->filter()
                ->unique()
                ->values()
                ->all();

            if (empty($emails)) {
                return back()->withErrors([
                    'broadcast_email' => 'No recipients found.',
                ]);
            }

            $replyTo = trim((string) ($request->user()?->email ?? ''));
            $sender = $replyTo !== '' ? $replyTo : $emails[0];

            try {
                foreach (array_chunk($emails, 50) as $chunk) {
                    Mail::raw($validated['message'], function ($mail) use ($chunk, $sender, $replyTo, $validated) {
                        $mail->to($sender)
                            ->bcc($chunk)
                            ->subject($validated['subject']);

                        if ($replyTo !== '') {
                            $mail->replyTo($replyTo);
                        }
                    });
                }
            } catch (\Throwable $exception) {
                return back()->withErrors([
                    'broadcast_email' => 'Failed to send broadcast email. Check SMTP settings and try again.',
                ])->withInput();
            }

            return back()->with('status', 'Broadcast email sent successfully to '.count($emails).' recipients.');
        })->name('admin.email.broadcast');
    });

    Route::middleware(['role:manager,executive,admin'])->group(function () {
        Route::get('/manager', [ManagerController::class, 'index'])->name('manager.index');
    });

    Route::middleware(['role:manager,admin'])->group(function () {
        Route::post('/meetings', [MeetingController::class, 'store'])->name('meetings.store');
        Route::put('/meetings/{meeting}', [MeetingController::class, 'update'])->name('meetings.update');
        Route::delete('/meetings/{meeting}', [MeetingController::class, 'destroy'])->name('meetings.destroy');
        Route::post('/holidays', [HolidayController::class, 'store'])->name('holidays.store');
        Route::put('/holidays/{holiday}', [HolidayController::class, 'update'])->name('holidays.update');
        Route::delete('/holidays/{holiday}', [HolidayController::class, 'destroy'])->name('holidays.destroy');
    });

    Route::middleware(['role:manager,admin,member,employee,project_manager,pm,lead,team_lead,teamlead'])->group(function () {
        Route::get('/admin/configuration', [AdminConfigurationController::class, 'index'])->name('admin.config.index');
        Route::post('/admin/configuration/logo', [AdminConfigurationController::class, 'uploadLogo'])->name('admin.config.logo.update');
        Route::post('/admin/configuration/companies', [AdminConfigurationController::class, 'storeCompany'])->name('admin.config.companies.store');
        Route::put('/admin/configuration/companies/{company}', [AdminConfigurationController::class, 'updateCompany'])->name('admin.config.companies.update');
        Route::delete('/admin/configuration/companies/{company}', [AdminConfigurationController::class, 'deleteCompany'])->name('admin.config.companies.delete');
        Route::post('/admin/configuration/processes', [AdminConfigurationController::class, 'storeProcess'])->name('admin.config.processes.store');
        Route::put('/admin/configuration/processes/{process}', [AdminConfigurationController::class, 'updateProcess'])->name('admin.config.processes.update');
        Route::delete('/admin/configuration/processes/{process}', [AdminConfigurationController::class, 'deleteProcess'])->name('admin.config.processes.delete');
        Route::post('/admin/configuration/teams', [AdminConfigurationController::class, 'storeTeam'])->name('admin.config.teams.store');
        Route::put('/admin/configuration/teams/{team}', [AdminConfigurationController::class, 'updateTeam'])->name('admin.config.teams.update');
        Route::delete('/admin/configuration/teams/{team}', [AdminConfigurationController::class, 'deleteTeam'])->name('admin.config.teams.delete');
        Route::put('/admin/configuration/announcement', [AdminConfigurationController::class, 'updateAnnouncement'])->name('admin.config.announcement.update');

        Route::get('/admin/chatbot-knowledge', [ChatbotKnowledgeController::class, 'index'])->name('admin.chatbot.index');
        Route::post('/admin/chatbot-knowledge', [ChatbotKnowledgeController::class, 'store'])->name('admin.chatbot.store');
        Route::put('/admin/chatbot-knowledge/{knowledge}', [ChatbotKnowledgeController::class, 'update'])->name('admin.chatbot.update');
        Route::delete('/admin/chatbot-knowledge/{knowledge}', [ChatbotKnowledgeController::class, 'destroy'])->name('admin.chatbot.destroy');
    });

    Route::middleware(['role:project_manager,pm,admin'])->group(function () {
        Route::get('/project-manager', [ProjectManagerController::class, 'index'])->name('project-manager.index');
    });

    Route::middleware(['role:member,employee,admin'])->group(function () {
        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    });

    Route::middleware(['role:executive,admin'])->group(function () {
        Route::get('/executive', [ExecutiveController::class, 'index'])->name('executive.index');
    });

    Route::middleware(['role:lead,admin'])->group(function () {
        Route::get('/lead', [LeadController::class, 'index'])->name('lead.index');
    });

    // GroupChat routes
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/messages', [App\Http\Controllers\ChatController::class, 'fetchMessages'])->name('messages.fetch');
    Route::post('/messages', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('messages.send');
});


// Fallback route for 404 Not Found
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

require __DIR__.'/settings.php';
