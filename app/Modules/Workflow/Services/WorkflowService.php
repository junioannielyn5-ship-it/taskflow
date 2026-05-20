<?php

namespace App\Modules\Workflow\Services;

use App\Modules\Identity\Models\User;
use App\Modules\Shared\Enums\TaskStatus;
use App\Modules\Tasks\Events\TaskStatusChanged;
use App\Modules\Tasks\Events\TaskUpdated;
use App\Modules\Tasks\Models\Task;
use App\Models\AuditLog;
use App\Modules\Workflow\Models\TaskActivityLog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

class WorkflowService
{
    /**
     * Allowed status transitions map.
     * Format: from_status => [allowed_to_status, ...]
     */
    private array $transitionMap = [
        TaskStatus::TODO->value => [TaskStatus::IN_PROGRESS->value, TaskStatus::BLOCKED->value],
        TaskStatus::IN_PROGRESS->value => [TaskStatus::BLOCKED->value, TaskStatus::FOR_REVIEW->value],
        TaskStatus::BLOCKED->value => [TaskStatus::IN_PROGRESS->value],
        TaskStatus::FOR_REVIEW->value => [TaskStatus::DONE->value, TaskStatus::IN_PROGRESS->value],
        TaskStatus::DONE->value => [],
    ];

    /**
     * Check if a status transition is allowed.
     */
    public function isTransitionAllowed(string $fromStatus, string $toStatus): bool
    {
        if (!isset($this->transitionMap[$fromStatus])) {
            return false;
        }

        return in_array($toStatus, $this->transitionMap[$fromStatus]);
    }

    /**
     * Check if a user can perform a specific status transition.
     */
    public function canUserTransition(User $user, Task $task, string $toStatus): bool
    {
        $fromStatus = $task->status;

        // Check if transition is allowed
        if (!$this->isTransitionAllowed($fromStatus, $toStatus)) {
            return false;
        }

        // Only admins or project leads can move to 'done'
        if ($toStatus === TaskStatus::DONE->value) {
            return $this->canUserCompleteTask($user, $task);
        }

        return true;
    }

    /**
     * Check if a user can complete (move to done) a task.
     */
    public function canUserCompleteTask(User $user, Task $task): bool
    {
        return Gate::forUser($user)->allows('complete-task', $task);
    }

    /**
     * Update task status with validation.
     */
    public function updateStatus(Task $task, string $newStatus, User $actor, ?string $reason = null): bool
    {
        $normalizedReason = is_string($reason) ? trim($reason) : null;

        if ($newStatus === TaskStatus::BLOCKED->value && $normalizedReason === '') {
            return false;
        }

        $updated = false;
        $expectedFromStatus = $task->status;

        $statusChanges = [];

        DB::transaction(function () use ($task, $newStatus, $actor, $normalizedReason, $expectedFromStatus, &$updated, &$statusChanges) {
            $taskQuery = Task::query()->whereKey($task->id);

            if (DB::connection()->getDriverName() !== 'sqlite') {
                $taskQuery->lockForUpdate();
            }

            $lockedTask = $taskQuery->first();

            if (!$lockedTask) {
                return;
            }

            // Prevent stale updates when another request has already changed the status.
            if ($lockedTask->status !== $expectedFromStatus) {
                return;
            }

            if (!$this->canUserTransition($actor, $lockedTask, $newStatus)) {
                return;
            }

            $lockedTask->status = $newStatus;
            $lockedTask->blocked_reason = $newStatus === TaskStatus::BLOCKED->value ? $normalizedReason : null;
            $lockedTask->done_at = $newStatus === TaskStatus::DONE->value ? now() : null;

            $statusChanges = array_filter([
                'status' => $lockedTask->status,
                'blocked_reason' => $lockedTask->blocked_reason,
                'done_at' => $lockedTask->done_at,
            ], fn ($value) => $value !== null || $value === '' || $value === 0);

            Task::withoutEvents(function () use ($lockedTask) {
                $lockedTask->save();
            });

            $task->setRawAttributes($lockedTask->getAttributes(), true);
            $task->syncOriginal();

            $updated = true;
        });

        if ($updated) {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'Updated',
                'model_type' => Task::class,
                'model_id' => $task->id,
                'model_label' => $task->getAuditLabel(),
                'old_values' => ['status' => $expectedFromStatus],
                'new_values' => ['status' => $newStatus],
                'ip_address' => Request::ip(),
            ]);

            TaskStatusChanged::dispatch($task, $expectedFromStatus, $newStatus);
            TaskUpdated::dispatch($task, ['status' => $newStatus]);
        }

        return $updated;
    }

    /**
     * Record a task activity log entry.
     */
    public function recordActivityLog(
        Task $task,
        User $actor,
        string $actionType,
        mixed $oldValue = null,
        mixed $newValue = null,
        array $metadata = []
    ): TaskActivityLog {
        return TaskActivityLog::create([
            'task_id' => $task->id,
            'actor_id' => $actor->id,
            'action_type' => $actionType,
            'old_value' => $oldValue !== null ? (string) $oldValue : null,
            'new_value' => $newValue !== null ? (string) $newValue : null,
            'metadata' => $metadata ?: null,
        ]);
    }

    /**
     * Get activity timeline for a task.
     */
    public function getActivityTimeline(Task $task): Collection
    {
        return $task->activityLogs()
            ->with(['actor'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Get valid transitions from a specific status.
     */
    public function getValidTransitions(string $fromStatus): array
    {
        return $this->transitionMap[$fromStatus] ?? [];
    }

    /**
     * Get all available statuses.
     */
    public function getAvailableStatuses(): array
    {
        return array_keys($this->transitionMap);
    }
}