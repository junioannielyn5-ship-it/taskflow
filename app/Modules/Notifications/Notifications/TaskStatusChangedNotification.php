<?php

namespace App\Modules\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Modules\Tasks\Models\Task;

class TaskStatusChangedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Task $task,
        public string $oldStatus,
        public string $newStatus,
        public ?string $actorName = null
    ) {}

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        $prefix = $this->actorName ? $this->actorName . ' moved ' . $this->task->title . ' to ' : 'Task status changed to ';

        return [
            'message' => $prefix . str_replace('_', ' ', ucfirst($this->newStatus)),
            'task_id' => $this->task->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'link' => route('tasks.show', $this->task->id),
        ];
    }

    public function toMail($notifiable): MailMessage
    {
        $humanStatus = str_replace('_', ' ', ucfirst($this->newStatus));
        $actorText = $this->actorName ? $this->actorName.' updated the task status.' : 'A task status update was recorded.';

        return (new MailMessage)
            ->subject('Task Status Update: '.$this->task->title)
            ->greeting('Hello '.($notifiable->name ?? 'Team').',')
            ->line($actorText)
            ->line('Task: '.$this->task->title)
            ->line('New Status: '.$humanStatus)
            ->action('Open Task', route('tasks.show', $this->task))
            ->line('Please review and take action if needed.');
    }
}
