<?php

namespace App\Modules\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Modules\Tasks\Models\Task;
use App\Modules\Identity\Models\User;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task, public ?User $actor = null) {}

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'You have been assigned to ' . $this->task->title,
            'task_id' => $this->task->id,
            'link' => route('tasks.show', $this->task->id),
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Movaflex Task Assignment: '.$this->task->title)
            ->view('emails.task-assigned', [
                'task' => $this->task,
                'notifiable' => $notifiable,
                'actor' => $this->actor,
                'taskUrl' => route('tasks.show', $this->task),
            ]);
    }
}
