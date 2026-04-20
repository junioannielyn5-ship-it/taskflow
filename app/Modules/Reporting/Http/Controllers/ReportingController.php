<?php

namespace App\Modules\Reporting\Http\Controllers;

use App\Modules\Reporting\Services\ReportingService;
use App\Modules\Reporting\DTOs\OverdueTaskDTO;
use App\Modules\Reporting\DTOs\CompletionStatsDTO;
use App\Modules\Reporting\DTOs\CycleTimeDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportingController
{
    public function __construct(private ReportingService $reportingService) {}

    public function overdue(Request $request)
    {
        $user = Auth::user();
        $projectId = $request->query('project_id');
        $tasks = $this->reportingService->getOverdueTasks($projectId, $user->id);
        $data = $tasks->map(fn($task) => new OverdueTaskDTO($task->id, $task->title, $task->due_date, $task->status));
        return response()->json(['data' => $data]);
    }

    /**
     * Get total hours spent per project or member.
     */
    public function totalHours(Request $request)
    {
        $user = Auth::user();
        $projectId = $request->query('project_id');
        $memberId = $request->query('user_id');
        // Only allow if user is member of project or requesting own data
        if ($projectId && !$this->reportingService->getProjectService()->isMember($projectId, $user->id)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        if ($memberId && $memberId != $user->id && !$user->isAdmin()) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        $hours = $this->reportingService->getTotalHoursSpent($projectId, $memberId);
        return response()->json(['total_hours' => $hours]);
    }

    public function performance(Request $request)
    {
        $userId = $request->query('user_id') ?? Auth::id();
        $projectId = $request->query('project_id');
        $from = $request->query('from');
        $to = $request->query('to');
        $stats = $this->reportingService->getCompletionStats($userId, $projectId, $from, $to);
        $data = new CompletionStatsDTO($stats['completed'], $stats['pending']);
        return response()->json(['data' => $data]);
    }

    public function cycleTime(Request $request)
    {
        $user = Auth::user();
        $projectId = $request->query('project_id');
        $avg = $this->reportingService->getCycleTime($projectId, $user->id);
        $data = new CycleTimeDTO($avg);
        return response()->json(['data' => $data]);
    }
}
