<?php

namespace App\Modules\Tasks\Policies;

use App\Modules\Identity\Models\User;
use App\Modules\Projects\Services\ProjectService;
use App\Modules\Tasks\Models\Task;

class TaskPolicy
{
    public function __construct(
        private ProjectService $projectService
    ) {}

    private function getProjectId(Task $task): ?int
    {
        if (!is_null($task->project_id)) {
            return (int) $task->project_id;
        }

        if (!is_null($task->project) && isset($task->project->id)) {
            return (int) $task->project->id;
        }

        $projectId = Task::query()->whereKey($task->id)->value('project_id');

        return is_null($projectId) ? null : (int) $projectId;
    }

    /**
     * Determine if the user can view the task.
     */
    public function view(User $user, Task $task): bool
    {
        // All authenticated users in this internal system can view any task
        // (consistent with kanban/index which shows all tasks to everyone).
        return true;
    }

    /**
     * Determine if the user can create tasks in the project.
     */
    public function create(User $user, int $projectId): bool
    {
        // Admin can create tasks in any project
        if ($user->isAdmin()) {
            return true;
        }

        // User must be a member of the project
        return $this->projectService->isMember($projectId, $user->id);
    }

    /**
     * Determine if the user can update the task.
     */
    public function update(User $user, Task $task): bool
    {
        // Admin can update any task
        if ($user->isAdmin()) {
            return true;
        }

        // Creator can update their own task
        if ((int) $user->id === (int) $task->created_by) {
            return true;
        }

        $projectId = $this->getProjectId($task);

        if (is_null($projectId)) {
            return false;
        }

        // Project leads can update
        if ($this->projectService->isLead($projectId, $user->id)) {
            return true;
        }

        // Project members can update (for now, allow all members)
        return $this->projectService->isMember($projectId, $user->id);
    }

    /**
     * Determine if the user can delete the task.
     */
    public function delete(User $user, Task $task): bool
    {
        // Admin can delete any task
        if ($user->isAdmin()) {
            return true;
        }

        // Creator can delete their own task
        if ((int) $user->id === (int) $task->created_by) {
            return true;
        }

        $projectId = $this->getProjectId($task);

        if (is_null($projectId)) {
            return false;
        }

        // Project leads can delete
        return $this->projectService->isLead($projectId, $user->id);
    }

    /**
     * Determine if the user can assign users to the task.
     */
    public function assign(User $user, Task $task): bool
    {
        // Admin can assign
        if ($user->isAdmin()) {
            return true;
        }

        // Global managers can assign across projects.
        if ($user->hasRole('manager')) {
            return true;
        }

        // Creator can assign
        if ((int) $user->id === (int) $task->created_by) {
            return true;
        }

        $projectId = $this->getProjectId($task);

        if (is_null($projectId)) {
            return false;
        }

        // Project leads can assign
        return $this->projectService->isLead($projectId, $user->id);
    }
}
