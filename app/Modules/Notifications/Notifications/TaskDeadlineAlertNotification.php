<?php

namespace App\Modules\Notifications\Notifications;

use App\Modules\Tasks\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineAlertNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Task $task,
        public string $level,
        public int $daysLeft,
        public array $ccEmails = [],
        public array $bccEmails = [],
    ) {}

    public function via($notifiable): array
    {
        if ($notifiable instanceof AnonymousNotifiable) {
            return ['mail'];
        }

        return ['database', 'mail'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => $this->buildMessage(),
            'task_id' => $this->task->id,
            'deadline_level' => $this->level,
            'days_left' => $this->daysLeft,
            'link' => route('tasks.show', $this->task),
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        $fromAddress = (string) config('mail.from.address', '');
        $fromName = (string) config('mail.from.name', 'Task Manager');
        $toAddress = $this->resolveRecipientEmail($notifiable);

        $ccList = collect($this->ccEmails)
            ->map(fn ($email) => trim((string) $email))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
            ->unique()
            ->reject(fn ($email) => strtolower($email) === strtolower($toAddress))
            ->values()
            ->all();

        $bccList = collect($this->bccEmails)
            ->map(fn ($email) => trim((string) $email))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL) !== false)
            ->unique()
            ->reject(fn ($email) => strtolower($email) === strtolower($toAddress))
            ->values()
            ->all();

        $taskNo = (string) ($this->task->task_no ?: sprintf('TSK-%05d', $this->task->id));
        $projectName = (string) ($this->task->project?->name ?? 'N/A');
        $dueDate = optional($this->task->due_date)?->format('m-d-Y') ?? 'N/A';
        $assignedTo = $this->task->assignees
            ->pluck('name')
            ->filter()
            ->implode(', ');
        $assignedTo = $assignedTo !== '' ? $assignedTo : 'N/A';
        $signatureName = trim($fromName) !== '' ? $fromName : 'Task Manager';
        $isUrgent = $this->level === 'urgent';
        $isReminder = $this->level === 'reminder';
        $isOverdue = $this->level === 'overdue';

        $subject = match (true) {
            $isOverdue => 'OVERDUE TASK - Immediate Action Required',
            $isUrgent => 'URGENT: Task Due Within 24 Hours',
            default => 'Task Reminder: Upcoming Deadline',
        };

        $introLine = match (true) {
            $isOverdue => 'Please be advised that the following task is now OVERDUE:',
            $isUrgent => 'This is to inform you that the task below is due within the next 24 hours:',
            default => 'Just a quick reminder regarding the task below, which is approaching its target due date:',
        };

        $actionLine = match (true) {
            $isOverdue => 'May we request an immediate update and action plan to close this item.',
            $isUrgent => 'Kindly prioritize this item and advise on its current status.',
            default => 'Please let me know if this is already in progress or if any assistance is needed.',
        };

        $mailMessage = (new MailMessage)
            ->from($fromAddress, $fromName)
            ->subject($subject)
            ->line('Good day,')
            ->line('')
            ->line($introLine)
            ->line('')
            ->line('Project: '.$projectName)
            ->line('Task No: '.$taskNo)
            ->line('Target Due Date: '.$dueDate)
            ->when($isOverdue, fn (MailMessage $message) => $message->line('Assigned To: '.$assignedTo))
            ->line('')
            ->line($actionLine)
            ->line('')
            ->line('Thank you.')
            ->line('')
            ->line('Best regards,')
            ->line($signatureName);

        if (!empty($ccList)) {
            $mailMessage->cc($ccList);
        }

        if (!empty($bccList)) {
            $mailMessage->bcc($bccList);
        }

        return $mailMessage;
    }

    private function resolveRecipientEmail($notifiable): string
    {
        if ($notifiable instanceof AnonymousNotifiable) {
            $route = $notifiable->routeNotificationFor('mail');

            if (is_string($route) && $route !== '') {
                return $route;
            }

            if (is_array($route)) {
                $first = array_key_first($route);

                if (is_string($first) && $first !== '') {
                    return $first;
                }

                $value = reset($route);
                if (is_string($value) && $value !== '') {
                    return $value;
                }
            }

            return 'N/A';
        }

        return (string) ($notifiable->email ?? 'N/A');
    }

    private function buildMessage(): string
    {
        return match ($this->level) {
            'urgent' => 'Urgent: Task "'.$this->task->title.'" is due within 24 hours.',
            'warning' => 'Warning: Task "'.$this->task->title.'" is due in 7 days.',
            'critical' => 'Critical: Task "'.$this->task->title.'" is due in 3 days.',
            'reminder' => 'Reminder: Task "'.$this->task->title.'" is due today.',
            'overdue' => 'Overdue: Task "'.$this->task->title.'" has passed its deadline.',
            default => 'Deadline update for task "'.$this->task->title.'".',
        };
    }
}
