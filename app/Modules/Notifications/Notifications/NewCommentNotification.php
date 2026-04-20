<?php

namespace App\Modules\Notifications\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Modules\Tasks\Models\Task;
use App\Modules\Comments\Models\TaskComment;

class NewCommentNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task, public TaskComment $comment) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $actorName = $this->comment->user?->name ?? 'Someone';

        return [
            'message' => $actorName . ' commented on ' . $this->task->title,
            'task_id' => $this->task->id,
            'comment_id' => $this->comment->id,
            'link' => route('tasks.show', $this->task->id),
        ];
    }
}
