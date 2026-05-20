<?php

namespace App\Modules\Notifications\Listeners;

use App\Modules\Identity\Models\User;
use App\Modules\Tasks\Events\TaskStatusChanged;
use App\Modules\Notifications\Notifications\TaskStatusChangedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SendTaskStatusChangedNotification
{
    public function handle(TaskStatusChanged $event)
    {
        if (!in_array($event->toStatus, ['for_review', 'done'], true)) {
            return;
        }

        $actorName = Auth::user()?->name;
        $recipients = collect($event->task->assignees)->keyBy('id');

        if ($event->toStatus === 'for_review') {
            $managerUsers = User::query()
                ->whereIn('role', ['manager', 'project_manager', 'pm', 'admin', 'lead'])
                ->get();

            foreach ($managerUsers as $managerUser) {
                if ($managerUser instanceof User) {
                    $recipients->put($managerUser->id, $managerUser);
                }
            }
        }

        foreach ($recipients as $recipient) {
            if ($recipient instanceof User) {
                try {
                    $recipient->notify(new TaskStatusChangedNotification($event->task, $event->fromStatus, $event->toStatus, $actorName));
                } catch (\Throwable $e) {
                    Log::error('Failed to send task status changed notification: ' . $e->getMessage());
                }
            }
        }
    }
}
