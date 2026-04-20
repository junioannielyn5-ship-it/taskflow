<?php

namespace App\Modules\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class DailyDelayedTasksNotification extends Notification
{
    use Queueable;

    /**
     * @param Collection<int, \App\Modules\Tasks\Models\Task> $tasks
     */
    public function __construct(public Collection $tasks) {}

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'You have '.$this->tasks->count().' delayed task(s) requiring action.',
            'status' => 'delayed_daily_summary',
            'task_ids' => $this->tasks->pluck('id')->values()->all(),
            'link' => route('tasks.list', ['status' => 'ON-GOING']),
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Movaflex Daily Alert: Delayed Tasks Summary')
            ->view('emails.delayed-tasks-daily-summary', [
                'tasks' => $this->tasks,
                'notifiable' => $notifiable,
                'tasksUrl' => route('tasks.list'),
            ]);
    }
}
