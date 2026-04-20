<?php

namespace App\Modules\Notifications\Listeners;

use App\Modules\Tasks\Events\TaskAssigned;
use App\Modules\Notifications\Notifications\TaskAssignedNotification;
use Illuminate\Support\Facades\Log;

class SendTaskAssignedNotification
{
    public function handle(TaskAssigned $event)
    {
        foreach ($event->task->assignees as $user) {
            try {
                $user->notify(new TaskAssignedNotification($event->task, $event->actor));
            } catch (\Throwable $e) {
                Log::error('Failed to send task assigned notification: ' . $e->getMessage());
            }
        }
    }
}

