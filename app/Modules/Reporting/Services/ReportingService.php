<?php

namespace App\Modules\Reporting\Services;

use App\Modules\Projects\Services\ProjectService;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;
use Illuminate\Support\Carbon;

class ReportingService
{
    public function __construct(private ProjectService $projectService) {}

    /**
     * Get total hours spent per project or per member.
     *
     * @param int|null $projectId
     * @param int|null $userId
     * @return float Total hours
     */
    public function getTotalHoursSpent(?int $projectId = null, ?int $userId = null): float
    {
        $query = \App\Modules\Tasks\Models\TaskTimeLog::query();
        if ($projectId) {
            $query->whereHas('task', function ($q) use ($projectId) {
                $q->where('project_id', $projectId);
            });
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }
        $totalSeconds = $query->whereNotNull('total_seconds')->sum('total_seconds');
        return round($totalSeconds / 3600, 2); // hours
    }

    public function getOverdueTasks(int $projectId, int $userId)
    {
        if (!$this->projectService->isMember($projectId, $userId)) {
            return collect();
        }
        return Task::where('project_id', $projectId)
            ->where('status', '!=', 'done')
            ->whereDate('due_date', '<', now())
            ->get();
    }

    public function getCompletionStats(?int $userId = null, ?int $projectId = null, ?string $from = null, ?string $to = null)
    {
        $query = Task::query();
        if ($userId) {
            $query->where('created_by', $userId);
        }
        if ($projectId) {
            $query->where('project_id', $projectId);
        }
        if ($from) {
            $query->whereDate('completed_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('completed_at', '<=', $to);
        }
        $completed = (clone $query)->where('status', 'done')->count();
        $pending = (clone $query)->where('status', '!=', 'done')->count();
        return [
            'completed' => $completed,
            'pending' => $pending,
        ];
    }

    public function getCycleTime(int $projectId, int $userId)
    {
        if (!$this->projectService->isMember($projectId, $userId)) {
            return null;
        }
        $tasks = Task::where('project_id', $projectId)->where('status', 'done')->get();
        $totalDays = 0;
        $count = 0;
        foreach ($tasks as $task) {
            $start = TaskActivityLog::where('task_id', $task->id)
                ->where('new_status', 'in_progress')
                ->orderBy('created_at')
                ->first();
            $end = TaskActivityLog::where('task_id', $task->id)
                ->where('new_status', 'done')
                ->orderBy('created_at')
                ->first();
            if ($start && $end) {
                $totalDays += $end->created_at->diffInDays($start->created_at);
                $count++;
            }
        }
        return $count > 0 ? round($totalDays / $count, 2) : null;
    }
}
