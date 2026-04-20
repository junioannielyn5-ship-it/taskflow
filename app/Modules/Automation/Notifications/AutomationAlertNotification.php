<?php

namespace App\Modules\Automation\Notifications;

use App\Modules\Tasks\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AutomationAlertNotification extends Notification
{
    use Queueable;

    public function __construct(public string $message, public ?Task $task = null)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => $this->message,
            'task_id' => $this->task?->id,
            'link' => $this->task ? route('tasks.show', $this->task->id) : route('dashboard'),
        ];
    }
}
