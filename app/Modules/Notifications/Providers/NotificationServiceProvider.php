<?php

namespace App\Modules\Notifications\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Modules\Tasks\Events\TaskAssigned::class => [
            \App\Modules\Notifications\Listeners\SendTaskAssignedNotification::class,
        ],
        \App\Modules\Tasks\Events\TaskStatusChanged::class => [
            \App\Modules\Notifications\Listeners\SendTaskStatusChangedNotification::class,
        ],
        \App\Modules\Tasks\Events\TaskUpdated::class => [
            \App\Modules\Notifications\Listeners\SendDelayedTaskNotification::class,
        ],
        \App\Modules\Comments\Events\CommentCreated::class => [
            \App\Modules\Notifications\Listeners\SendNewCommentNotification::class,
        ],
    ];
}
