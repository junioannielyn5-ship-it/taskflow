<?php

namespace App\Modules\Notifications\Listeners;

use App\Modules\Notifications\Notifications\DelayedTaskAlertNotification;
use App\Modules\Identity\Models\User;
use App\Modules\Tasks\Events\TaskUpdated;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Log;

class SendDelayedTaskNotification
{
    public function handle(TaskUpdated $event): void
    {
        $task = $event->task->loadMissing('assignees');
        $changes = $event->changes;

        $currentDueDate = $task->due_date;
        $currentStatus = $task->status;

        $oldDueDateValue = $changes['due_date']['old'] ?? ($currentDueDate?->toDateString());
        $oldStatus = $changes['status']['old'] ?? $currentStatus;

        $wasDelayed = $this->isDelayed(
            $oldDueDateValue ? Carbon::parse($oldDueDateValue) : null,
            (string) $oldStatus
        );
        $isDelayed = $this->isDelayed($currentDueDate, (string) $currentStatus);

        if ($isDelayed && !$wasDelayed) {
            $recipients = $task->assignees->keyBy('id');

            $managerUsers = User::query()
                ->whereIn('role', ['manager', 'admin'])
                ->whereNotNull('email')
                ->get();

            foreach ($managerUsers as $managerUser) {
                $recipients->put($managerUser->id, $managerUser);
            }

            foreach ($recipients as $recipient) {
                try {
                    $recipient->notify(new DelayedTaskAlertNotification($task));
                } catch (\Throwable $e) {
                    Log::error('Failed to send delayed task notification: ' . $e->getMessage());
                }
            }
        }
    }

    private function isDelayed(?CarbonInterface $dueDate, string $status): bool
    {
        if (is_null($dueDate)) {
            return false;
        }

        return $dueDate->isPast() && $status !== 'done';
    }
}
