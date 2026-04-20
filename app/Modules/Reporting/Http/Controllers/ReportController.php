<?php

namespace App\Modules\Reporting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Reporting\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Show the reports index page.
     */
    public function index(Request $request, ReportService $service)
    {
        $overdueByAssignee = $service->overdueByAssignee($request->user());

        return view('reports.index', [
            'overdueByAssignee' => $overdueByAssignee,
        ]);
    }

    public function overdue(Request $request, ReportService $service)
    {
        $perPage = max(1, min(100, (int) $request->integer('per_page', 20)));

        $tasks = $service
            ->overdueTasksQuery($request->project_id, $request->assignee_id, $request->user())
            ->with(['project', 'assignees'])
            ->latest('due_date')
            ->paginate($perPage)
            ->withQueryString();

        return response()->json([
            'data' => $tasks->items(),
            'pagination' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    public function completed(Request $request, ReportService $service)
    {
        $from = $request->input('from', now()->subMonth()->toDateString());
        $to = $request->input('to', now()->toDateString());
        $count = $service->completedTasks($from, $to, $request->project_id, $request->assignee_id, $request->user());
        return response()->json(['completed' => $count]);
    }

    public function cycleTime(Request $request, ReportService $service)
    {
        $avg = $service->cycleTime($request->project_id, $request->user());
        return response()->json([
            'average_cycle_time_hours' => $avg,
            'data' => [
                'average_days' => is_null($avg) ? null : round($avg / 24, 2),
            ],
        ]);
    }

    public function overdueByAssignee(Request $request, ReportService $service)
    {
        return response()->json([
            'data' => $service->overdueByAssignee($request->user()),
        ]);
    }

    public function exportOverdueCsv(Request $request, ReportService $service): StreamedResponse
    {
        abort_unless($request->user()?->hasAnyRole(['admin', 'manager', 'project_manager', 'pm', 'lead', 'executive']), 403);

        $tasks = $service->overdueTasks($request->project_id, $request->assignee_id, $request->user());
        $fileName = 'overdue-tasks-'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($tasks) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Task ID', 'Title', 'Project', 'Status', 'Priority', 'Due Date', 'Assignees']);

            foreach ($tasks as $task) {
                fputcsv($handle, [
                    $task->id,
                    $task->title,
                    $task->project?->name,
                    $task->status,
                    $task->priority,
                    optional($task->due_date)->format('Y-m-d'),
                    $task->assignees->pluck('name')->implode(', '),
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportCompletedCsv(Request $request, ReportService $service): StreamedResponse
    {
        abort_unless($request->user()?->hasAnyRole(['admin', 'manager', 'project_manager', 'pm', 'lead', 'executive']), 403);

        $from = $request->input('from', now()->subMonth()->toDateString());
        $to = $request->input('to', now()->toDateString());
        $tasks = $service->completedTasksData($from, $to, $request->project_id, $request->assignee_id, $request->user());
        $fileName = 'completed-tasks-'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($tasks) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Task ID', 'Title', 'Project', 'Priority', 'Completed At', 'Assignees']);

            foreach ($tasks as $task) {
                fputcsv($handle, [
                    $task->id,
                    $task->title,
                    $task->project?->name,
                    $task->priority,
                    optional($task->done_at)->format('Y-m-d H:i'),
                    $task->assignees->pluck('name')->implode(', '),
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportOverduePdf(Request $request, ReportService $service)
    {
        abort_unless($request->user()?->hasAnyRole(['admin', 'manager', 'project_manager', 'pm', 'lead', 'executive']), 403);

        $tasks = $service->overdueTasks($request->project_id, $request->assignee_id, $request->user());

        $pdf = Pdf::loadView('reports.exports.tasks-pdf', [
            'title' => 'Overdue Tasks Report',
            'generatedAt' => now(),
            'columns' => ['Task ID', 'Title', 'Project', 'Status', 'Priority', 'Due Date', 'Assignees'],
            'rows' => $tasks->map(fn ($task) => [
                $task->id,
                $task->title,
                $task->project?->name ?? '-',
                $task->status,
                $task->priority,
                optional($task->due_date)->format('Y-m-d') ?? '-',
                $task->assignees->pluck('name')->implode(', '),
            ]),
        ]);

        return $pdf->download('overdue-tasks-'.now()->format('Ymd_His').'.pdf');
    }

    public function exportCompletedPdf(Request $request, ReportService $service)
    {
        abort_unless($request->user()?->hasAnyRole(['admin', 'manager', 'project_manager', 'pm', 'lead', 'executive']), 403);

        $from = $request->input('from', now()->subMonth()->toDateString());
        $to = $request->input('to', now()->toDateString());
        $tasks = $service->completedTasksData($from, $to, $request->project_id, $request->assignee_id, $request->user());

        $pdf = Pdf::loadView('reports.exports.tasks-pdf', [
            'title' => 'Completed Tasks Report',
            'generatedAt' => now(),
            'columns' => ['Task ID', 'Title', 'Project', 'Priority', 'Completed At', 'Assignees'],
            'rows' => $tasks->map(fn ($task) => [
                $task->id,
                $task->title,
                $task->project?->name ?? '-',
                $task->priority,
                optional($task->done_at)->format('Y-m-d H:i') ?? '-',
                $task->assignees->pluck('name')->implode(', '),
            ]),
        ]);

        return $pdf->download('completed-tasks-'.now()->format('Ymd_His').'.pdf');
    }
}
