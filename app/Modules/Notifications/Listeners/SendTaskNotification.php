<?php

namespace App\Modules\Notifications\Listeners;

use App\Modules\Notifications\Notifications\TaskUpdateNotification;
use Illuminate\Contracts\Events\Dispatcher;

class SendTaskNotification
{
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            'App\\Modules\\Tasks\\Events\\TaskAssigned',
            [self::class, 'handleTaskAssigned']
        );
        $events->listen(
            'App\\Modules\\Workflow\\Events\\TaskStatusChanged',
            [self::class, 'handleTaskStatusChanged']
        );
        $events->listen(
            'App\\Modules\\Comments\\Events\\CommentCreated',
            [self::class, 'handleCommentCreated']
        );
    }

    public function handleTaskAssigned($event): void
    {
        $event->user->notify(new TaskUpdateNotification($event));
    }

    public function handleTaskStatusChanged($event): void
    {
        $event->task->assignees->each(function ($user) use ($event) {
            $user->notify(new TaskUpdateNotification($event));
        });
    }

    public function handleCommentCreated($event): void
    {
        $event->task->assignees->each(function ($user) use ($event) {
            $user->notify(new TaskUpdateNotification($event));
        });
    }
}
