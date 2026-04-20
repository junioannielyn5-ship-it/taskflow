<?php

namespace App\Modules\Reporting\Services;

use App\Modules\Identity\Models\User;
use App\Modules\Shared\Enums\TaskStatus;
use Illuminate\Support\Facades\DB;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;
use Illuminate\Database\Eloquent\Builder;

class ReportService
{
    public function overdueTasks($projectId = null, $assigneeId = null, ?User $viewer = null)
    {
        return $this->overdueTasksQuery($projectId, $assigneeId, $viewer)
            ->with(['project', 'assignees'])
            ->get();
    }

    public function overdueTasksQuery($projectId = null, $assigneeId = null, ?User $viewer = null): Builder
    {
        $query = Task::query()
            ->where('status', '!=', TaskStatus::DONE->value)
            ->whereNotNull('due_date')
            ->where('due_date', '<', now());

        $this->applyViewerScope($query, $viewer);

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        if ($assigneeId) {
            $query->whereHas('assignees', function ($q) use ($assigneeId) {
                $q->where('user_id', $assigneeId);
            });
        }

        return $query;
    }

    public function completedTasks($from, $to, $projectId = null, $assigneeId = null, ?User $viewer = null)
    {
        return $this->completedTasksQuery($from, $to, $projectId, $assigneeId, $viewer)->count();
    }

    public function completedTasksData($from, $to, $projectId = null, $assigneeId = null, ?User $viewer = null)
    {
        return $this->completedTasksQuery($from, $to, $projectId, $assigneeId, $viewer)
            ->with(['project', 'assignees'])
            ->get();
    }

    public function cycleTime($projectId = null, ?User $viewer = null)
    {
        $query = Task::query()->where('status', TaskStatus::DONE->value);

        $this->applyViewerScope($query, $viewer);

        $tasks = $query
            ->when($projectId, fn($q) => $q->where('project_id', $projectId))
            ->get();
        $total = 0;
        $count = 0;
        foreach ($tasks as $task) {
            $todoLog = TaskActivityLog::where('task_id', $task->id)
                ->where(function ($query) {
                    $query->where('action_type', 'created')
                        ->orWhere(function ($statusQuery) {
                            $statusQuery->where('action_type', 'status_change')
                                ->whereIn('new_value', [
                                    TaskStatus::TODO->value,
                                    TaskStatus::IN_PROGRESS->value,
                                ]);
                        });
                })
                ->orderBy('created_at')
                ->first();

            $doneLog = TaskActivityLog::where('task_id', $task->id)
                ->where('action_type', 'status_change')
                ->where('new_value', TaskStatus::DONE->value)
                ->orderByDesc('created_at')
                ->first();

            if ($todoLog && $doneLog) {
                $total += abs($doneLog->created_at->diffInSeconds($todoLog->created_at, false));
                $count++;
            }
        }
        return $count ? round($total / $count / 3600, 2) : null; // hours
    }

    public function overdueByAssignee(?User $viewer = null)
    {
        $taskQuery = Task::query()
            ->where('status', '!=', TaskStatus::DONE->value)
            ->whereNotNull('due_date')
            ->where('due_date', '<', now());

        $this->applyViewerScope($taskQuery, $viewer);

        $taskIds = $taskQuery->pluck('id');

        if ($taskIds->isEmpty()) {
            return collect();
        }

        return DB::table('task_assignees')
            ->join('users', 'users.id', '=', 'task_assignees.user_id')
            ->join('tasks', 'tasks.id', '=', 'task_assignees.task_id')
            ->whereIn('task_assignees.task_id', $taskIds)
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('overdue_count')
            ->selectRaw('users.id as assignee_id, users.name as assignee_name, COUNT(task_assignees.task_id) as overdue_count, SUM(CASE WHEN tasks.title LIKE ? THEN 1 ELSE 0 END) as sample_task_overdue_count', ['Sample Task%'])
            ->get();
    }

    private function applyViewerScope(Builder $query, ?User $viewer): void
    {
        if (! $viewer || $viewer->isAdmin()) {
            return;
        }

        $query->where(function (Builder $projectScope) use ($viewer) {
            $projectScope->whereHas('project', function (Builder $projectQuery) use ($viewer) {
                $projectQuery
                    ->where('created_by', $viewer->id)
                    ->orWhereHas('members', function (Builder $memberQuery) use ($viewer) {
                        $memberQuery->where('user_id', $viewer->id);
                    });
            });
        });
    }

    private function completedTasksQuery($from, $to, $projectId = null, $assigneeId = null, ?User $viewer = null): Builder
    {
        $query = Task::query()
            ->where('status', TaskStatus::DONE->value)
            ->whereNotNull('done_at')
            ->whereBetween('done_at', [$from, $to]);

        $this->applyViewerScope($query, $viewer);

        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        if ($assigneeId) {
            $query->whereHas('assignees', function ($q) use ($assigneeId) {
                $q->where('user_id', $assigneeId);
            });
        }

        return $query;
    }
}
