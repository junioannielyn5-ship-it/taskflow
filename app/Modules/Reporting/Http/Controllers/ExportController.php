<?php

namespace App\Modules\Reporting\Http\Controllers;

use App\Modules\Reporting\Services\ReportingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController
{
    public function __construct(private ReportingService $reportingService) {}

    public function exportOverdueCsv(Request $request): StreamedResponse
    {
        $user = Auth::user();
        $projectId = $request->query('project_id');
        $tasks = $this->reportingService->getOverdueTasks($projectId, $user->id);
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="overdue_tasks.csv"',
        ];
        $callback = function () use ($tasks) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Title', 'Due Date', 'Status']);
            foreach ($tasks as $task) {
                fputcsv($handle, [$task->id, $task->title, $task->due_date, $task->status]);
            }
            fclose($handle);
        };
        return response()->stream($callback, 200, $headers);
    }
}
