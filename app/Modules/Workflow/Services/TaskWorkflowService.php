<?php

namespace App\Modules\Workflow\Services;

use App\Modules\Tasks\Models\Task;
use App\Modules\Identity\Models\User;
use Illuminate\Validation\ValidationException;

class TaskWorkflowService
{
    /**
     * Validate and perform a status transition.
     *
     * @throws ValidationException
     */
    public function transition(Task $task, string $newStatus, User $actor, ?string $comment = null): void
    {
        $oldStatus = $task->status;
        $valid = false;

        switch ($oldStatus) {
            case 'todo':
                $valid = in_array($newStatus, ['in_progress', 'blocked']);
                break;
            case 'in_progress':
                $valid = in_array($newStatus, ['for_review', 'blocked']);
                break;
            case 'for_review':
                // Only Lead/Admin can move to done
                $valid = $newStatus === 'done' && ($actor->hasRole('admin') || $actor->hasRole('lead'));
                break;
            case 'blocked':
                $valid = $newStatus === 'in_progress';
                break;
        }

        if (!$valid) {
            throw ValidationException::withMessages(['status' => 'Invalid status transition.']);
        }

        if ($newStatus === 'blocked' && empty($comment)) {
            throw ValidationException::withMessages(['comment' => 'A comment is required when blocking a task.']);
        }

        $task->status = $newStatus;
        $task->save();
    }
}
