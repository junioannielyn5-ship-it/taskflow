<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\Tasks\Models\Task;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('project_manager')) {
            return true;
        }

        if ($task->created_by === $user->id) {
            return true;
        }

        if ($task->assignees()->where('user_id', $user->id)->exists()) {
            return true;
        }

        return (bool) $task->project?->hasMember($user);
    }

    public function update(User $user, Task $task): bool
    {
        // Admin can update any task
        if ($user->hasRole('admin')) return true;
        // Project Manager can update any task
        if ($user->hasRole('project_manager')) return true;
        // Team Lead can update tasks in project
        if ($task->project->isLead($user)) return true;
        // Task creator can always update
        if ($task->created_by === $user->id) return true;

        // Members can update tasks assigned to them
        if ($task->assignees()->where('user_id', $user->id)->exists()) return true;

        // Members can update tasks within projects they belong to
        return $task->project->hasMember($user);
    }

    public function delete(User $user, Task $task): bool
    {
        // Admin can delete any task
        if ($user->hasRole('admin')) return true;
        // Project Manager can delete any task
        if ($user->hasRole('project_manager')) return true;
        // Team Lead can delete tasks in project
        if ($task->project->isLead($user)) return true;
        return false;
    }

    public function markDone(User $user, Task $task): bool
    {
        // Only Team Lead, Project Manager, or Admin can mark as done
        if ($user->hasRole('admin')) return true;
        if ($user->hasRole('project_manager')) return true;
        if ($task->project->isLead($user)) return true;
        return false;
    }
}
