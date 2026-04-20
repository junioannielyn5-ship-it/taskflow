<?php

namespace App\Modules\Notifications\Notifications;

use App\Modules\Tasks\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DelayedTaskAlertNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task) {}

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'Task marked as Delayed: '.$this->task->title,
            'task_id' => $this->task->id,
            'status' => 'delayed',
            'link' => route('tasks.show', $this->task),
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Movaflex Alert: Delayed Task - '.$this->task->title)
            ->view('emails.delayed-task-alert', [
                'task' => $this->task,
                'notifiable' => $notifiable,
                'taskUrl' => route('tasks.show', $this->task),
            ]);
    }
}
