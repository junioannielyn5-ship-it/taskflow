<?php

namespace App\Modules\Tasks\Services;

use App\Modules\Projects\Services\ProjectService;
use App\Modules\Identity\Models\User;
use App\Modules\Tasks\Events\TaskAssigned;
use App\Modules\Tasks\Events\TaskCreated;
use App\Modules\Tasks\Events\TaskUpdated;
use App\Modules\Tasks\Filters\TaskFilters;
use App\Modules\Tasks\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TaskService
{
        /**
         * Get all tasks assigned to a user.
         *
         * @param int $userId
         * @return \Illuminate\Support\Collection
         */
        public function getTasksAssignedTo($userId)
        {
            // Assumes Task has a many-to-many relationship with users via 'assignees' or a user_id column
            // Adjust as needed for your schema
            return Task::whereHas('assignees', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();
        }
    public function __construct(
        private ProjectService $projectService
    ) {}

    /**
     * Get tasks in a project with optional filters.
     */
    public function getProjectTasks(int $projectId, int $userId, array $filters = [], int $perPage = 20)
    {
        // Verify user is member of project
        if (!$this->projectService->isMember($projectId, $userId)) {
            return Task::query()->whereRaw('1 = 0')->paginate($perPage);
        }

        $query = Task::query()->where('project_id', $projectId);

        return TaskFilters::apply($query, $filters)
            ->with('creator', 'assignees')
            ->orderBy('priority', 'desc')
            ->orderBy('due_date', 'asc')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Get a task by ID.
     */
    public function getTask(int $taskId): ?Task
    {
        return Task::with('creator', 'assignees', 'project')->find($taskId);
    }

    /**
     * Create a new task.
     */
    public function createTask(int $projectId, int $userId, array $data): Task
    {
        $user = User::find($userId);

        // Only allow users who have create-task permission (admin/pm/lead/executive)
        if (!Gate::allows('create-task', $user)) {
            throw new \Exception('User does not have permission to create tasks');
        }

        $task = DB::transaction(function () use ($projectId, $userId, $data) {
            $assigneeIds = collect($data['assignees'] ?? [])->map(fn ($id) => (int) $id)->unique()->values()->all();
            unset($data['assignees'], $data['project_id']);

            // Prevent duplicate task creation on repeated client submission
            $normalizedTitle = trim(strtolower((string) ($data['title'] ?? '')));
            $duplicateTaskQuery = Task::query()
                ->where('project_id', $projectId)
                ->whereRaw('LOWER(TRIM(title)) = ?', [$normalizedTitle])
                ->where('created_by', $userId)
                ->where('status', '!=', 'done');

            if (!empty($data['date_received'])) {
                $duplicateTaskQuery->whereDate('date_received', $data['date_received']);
            }

            if (!empty($data['due_date'])) {
                $duplicateTaskQuery->whereDate('due_date', $data['due_date']);
            }

            if (!empty($data['task_process'])) {
                $duplicateTaskQuery->where('task_process', $data['task_process']);
            }

            if (!empty($data['specific_process'])) {
                $duplicateTaskQuery->where('specific_process', $data['specific_process']);
            }

            if ($duplicateTaskQuery->exists()) {
                throw new \Exception('Duplicate task detected: this task may already have been created. Please verify existing tasks before trying again.');
            }

            if (empty($data['due_date']) && !empty($data['date_started']) && !empty($data['sla_days'])) {
                $data['due_date'] = Carbon::parse($data['date_started'])
                    ->addDays((int) $data['sla_days'])
                    ->toDateString();
            }

            $hasScheduleDates = !empty($data['date_received'])
                && !empty($data['date_started'])
                && !empty($data['due_date']);

            if (!$hasScheduleDates) {
                $data['status'] = 'blocked';
                $data['blocked_by_task_id'] = null;
            } else {
                $data['status'] = $data['status'] ?? 'todo';
            }

            // Auto-fill team key based on legacy person-in-charge mapping when missing
            $data['team'] = $data['team'] ?? $this->deriveTeamFromPersonInCharge($data['team_in_charge'] ?? null);

            $this->ensureAssigneesAreProjectMembers($projectId, $assigneeIds);

            $task = Task::create(array_merge($data, [
                'project_id' => $projectId,
                'created_by' => $userId,
                'done_at' => (($data['status'] ?? null) === 'done') ? now() : null,
            ]));

            if (empty($task->task_no)) {
                $project = \App\Modules\Projects\Models\Project::find($projectId);
                $ownerInitials = 'XX';
                $ownerProjectCount = 1;

                if ($project && $project->project_owner) {
                    $words = explode(' ', trim($project->project_owner));
                    $initials = '';
                    foreach ($words as $word) {
                        if (!empty($word)) {
                            $initials .= strtoupper($word[0]);
                        }
                    }
                    if (strlen($initials) > 0) {
                        $ownerInitials = substr($initials, 0, 2);
                    }

                    $ownerProjectCount = \App\Modules\Projects\Models\Project::where('project_owner', $project->project_owner)
                        ->where('id', '<=', $project->id)
                        ->count();
                }

                $task->task_no = sprintf('P%s-%04d-%04d', $ownerInitials, $ownerProjectCount, $task->id);
                $task->save();
            }

            $task->assignees()->sync($assigneeIds);

            return $task->refresh()->load('creator', 'assignees', 'project');
        });

        TaskCreated::dispatch($task);
        TaskAssigned::dispatch($task, User::find($userId));

        return $task;
    }

    /**
     * Update a task.
     */
    private function deriveTeamFromPersonInCharge(?string $person): ?string
    {
        if (empty($person)) {
            return null;
        }

        $lower = strtolower(trim($person));

        $salesPeople = ['lawrence solee', 'norman reyes', 'philip borromeo', 'vera andino'];
        $technicalPeople = ['edcel ching', 'rupert moreno', 'ronnel gusi', 'samuel tabuzo', 'jobert vallejos', 'reuben guevara', 'jomer delgado', 'ryan fallan', 'carlo roldan', 'yen junio'];

        if (in_array($lower, $salesPeople, true)) {
            return 'sales';
        }
        if (in_array($lower, $technicalPeople, true)) {
            return 'technical';
        }

        return null;
    }

    public function updateTask(Task $task, array $data): Task
    {
        if (
            (array_key_exists('due_date', $data) && empty($data['due_date']))
            && !empty($data['date_started'])
            && !empty($data['sla_days'])
        ) {
            $data['due_date'] = Carbon::parse($data['date_started'])
                ->addDays((int) $data['sla_days'])
                ->toDateString();
        }

        $resolvedDateReceived = array_key_exists('date_received', $data)
            ? $data['date_received']
            : $task->date_received;
        $resolvedDateStarted = array_key_exists('date_started', $data)
            ? $data['date_started']
            : $task->date_started;
        $resolvedDueDate = array_key_exists('due_date', $data)
            ? $data['due_date']
            : $task->due_date;

        $hasScheduleDates = !empty($resolvedDateReceived)
            && !empty($resolvedDateStarted)
            && !empty($resolvedDueDate);

        if (!$hasScheduleDates) {
            $data['status'] = 'blocked';
            $data['blocked_by_task_id'] = null;
        } elseif ($task->status === 'blocked' && !array_key_exists('status', $data)) {
            $data['status'] = 'todo';
        }

        $task->update($data);
        return $task->refresh();
    }

    /**
     * Delete a task.
     */
    public function deleteTask(Task $task): bool
    {
        return $task->delete();
    }

    /**
     * Assign a user to a task.
     */
    public function assignUser(Task $task, int $userId, ?User $actor = null): void
    {
        $assignee = User::find($userId);

        if (!$assignee) {
            throw new \Exception('User not found');
        }

        $this->ensureAssigneesAreProjectMembers($task->project_id, [$userId]);

        $oldAssigneeIds = $task->assignees()->pluck('users.id')->map(fn ($id) => (int) $id)->sort()->values()->all();

        $task->assign($assignee);
        TaskAssigned::dispatch($task->fresh('assignees'), $actor);

        $newAssigneeIds = $task->assignees()->pluck('users.id')->map(fn ($id) => (int) $id)->sort()->values()->all();
        if ($oldAssigneeIds !== $newAssigneeIds) {
            TaskUpdated::dispatch($task->fresh(), [
                'assignees' => [
                    'old' => json_encode($oldAssigneeIds),
                    'new' => json_encode($newAssigneeIds),
                ],
            ]);
        }
    }

    /**
     * Unassign a user from a task.
     */
    public function unassignUser(Task $task, int $userId): void
    {
        $oldAssigneeIds = $task->assignees()->pluck('users.id')->map(fn ($id) => (int) $id)->sort()->values()->all();

        $task->unassign(\App\Modules\Identity\Models\User::find($userId));

        $newAssigneeIds = $task->assignees()->pluck('users.id')->map(fn ($id) => (int) $id)->sort()->values()->all();
        if ($oldAssigneeIds !== $newAssigneeIds) {
            TaskUpdated::dispatch($task->fresh(), [
                'assignees' => [
                    'old' => json_encode($oldAssigneeIds),
                    'new' => json_encode($newAssigneeIds),
                ],
            ]);
        }
    }

    /**
     * Get tasks assigned to a user in a project.
     */
    public function getUserTasksInProject(int $projectId, int $userId): int
    {
        return Task::where('project_id', $projectId)
            ->whereHas('assignees', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->count();
    }

    /**
     * Ensure assignees are project members so they can access assigned tasks.
     */
    private function ensureAssigneesAreProjectMembers(int $projectId, array $assigneeIds): void
    {
        foreach ($assigneeIds as $assigneeId) {
            $normalizedAssigneeId = (int) $assigneeId;

            if ($normalizedAssigneeId <= 0) {
                continue;
            }

            if (! $this->projectService->isMember($projectId, $normalizedAssigneeId)) {
                $this->projectService->addMember($projectId, $normalizedAssigneeId);
            }
        }
    }
}
