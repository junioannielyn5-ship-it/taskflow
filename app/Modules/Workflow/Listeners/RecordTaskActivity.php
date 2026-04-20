<?php

namespace App\Modules\Workflow\Listeners;

use App\Modules\Tasks\Events\TaskCreated;
use App\Modules\Tasks\Events\TaskStatusChanged;
use App\Modules\Tasks\Events\TaskUpdated;
use App\Modules\Identity\Models\User;
use App\Modules\Workflow\Services\WorkflowService;
use Illuminate\Support\Facades\Auth;

class RecordTaskActivity
{
    /**
     * Create the event listener.
     */
    public function __construct(private WorkflowService $workflowService)
    {
    }

    /**
     * Handle TaskCreated event.
     */
    public function handleTaskCreated(TaskCreated $event): void
    {
        $actor = $this->resolveActorForTask($event->task->created_by);

        if (!$actor) {
            return;
        }

        $this->workflowService->recordActivityLog(
            task: $event->task,
            actor: $actor,
            actionType: 'created',
            oldValue: null,
            newValue: $event->task->status
        );
    }

    /**
     * Handle TaskStatusChanged event.
     */
    public function handleTaskStatusChanged(TaskStatusChanged $event): void
    {
        $actor = $this->resolveActorForTask($event->task->created_by);

        if (!$actor) {
            return;
        }

        $this->workflowService->recordActivityLog(
            task: $event->task,
            actor: $actor,
            actionType: 'status_change',
            oldValue: $event->fromStatus,
            newValue: $event->toStatus
        );
    }

    /**
     * Handle TaskUpdated event to track other changes.
     */
    public function handleTaskUpdate(TaskUpdated $event): void
    {
        $actor = $this->resolveActorForTask($event->task->created_by);

        if (!$actor) {
            return;
        }

        $allowedFields = ['assignees', 'priority', 'due_date'];

        // Track required audit fields only
        foreach ($event->changes as $field => $change) {
            if (!in_array($field, $allowedFields, true)) {
                continue;
            }

            $actionType = match($field) {
                'status' => 'status_change',
                'assignees' => 'assignee_change',
                'priority' => 'priority_change',
                'due_date' => 'due_date_change',
                default => "{$field}_change",
            };

            $this->workflowService->recordActivityLog(
                task: $event->task,
                actor: $actor,
                actionType: $actionType,
                oldValue: $change['old'] ?? null,
                newValue: $change['new'] ?? null
            );
        }
    }

    private function resolveActorForTask(int $fallbackUserId): ?User
    {
        $actor = Auth::user();

        if ($actor instanceof User) {
            return $actor;
        }

        return User::find($fallbackUserId);
    }
}
