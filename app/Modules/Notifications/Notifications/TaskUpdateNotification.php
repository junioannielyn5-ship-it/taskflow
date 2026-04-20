<?php

namespace App\Modules\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class TaskUpdateNotification extends Notification
{
    use Queueable;

    protected $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        // Build a generic payload based on event type
        $type = class_basename($this->event);
        $data = [];
        if ($type === 'TaskAssigned') {
            $data = [
                'message' => 'You have been assigned to a task.',
                'task_id' => $this->event->task->id,
                'task_title' => $this->event->task->title,
            ];
        } elseif ($type === 'TaskStatusChanged') {
            $data = [
                'message' => 'Task status updated to ' . $this->event->status,
                'task_id' => $this->event->task->id,
                'task_title' => $this->event->task->title,
                'status' => $this->event->status,
            ];
        } elseif ($type === 'CommentCreated') {
            $data = [
                'message' => 'A new comment was added to a task.',
                'task_id' => $this->event->task->id,
                'task_title' => $this->event->task->title,
                'comment_id' => $this->event->comment->id,
            ];
        }
        return new DatabaseMessage($data);
    }
}
