<?php

namespace App\Modules\Workflow\Services;

use App\Modules\Identity\Models\User;
use App\Modules\Shared\Enums\TaskStatus;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

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
     * Roles that can complete (move to done) a task.
     */
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
        if (!$this->canUserTransition($actor, $task, $newStatus)) {
            return false;
        }

        $oldStatus = $task->status;
        $task->status = $newStatus;
        $task->blocked_reason = $newStatus === TaskStatus::BLOCKED->value ? $reason : null;
        $task->done_at = $newStatus === TaskStatus::DONE->value ? now() : null;
        $task->save();

        return true;
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
            'old_value' => $oldValue ? (string)$oldValue : null,
            'new_value' => $newValue ? (string)$newValue : null,
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
