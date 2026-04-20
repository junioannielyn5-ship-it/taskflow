<?php

namespace App\Modules\Reporting\Http\Controllers;

use App\Modules\Projects\Models\Project;
use App\Modules\Admin\Models\SystemSetting;
use App\Modules\Tasks\Models\Task;
use App\Modules\Workflow\Models\TaskActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController
{
    public function __invoke()
    {
        /** @var \App\Modules\Identity\Models\User $user */
        $user = Auth::user();
        return view('dashboard', $this->buildDashboardData($user));
    }

    public function advanced()
    {
        /** @var \App\Modules\Identity\Models\User $user */
        $user = Auth::user();

        return view('dashboard-advanced', $this->buildDashboardData($user));
    }

    public function unreadNotifications(Request $request): JsonResponse
    {
        /** @var \App\Modules\Identity\Models\User $user */
        $user = Auth::user();

        $notifications = $user
            ->unreadNotifications()
            ->latest()
            ->limit((int) $request->integer('limit', 3))
            ->get()
            ->map(fn ($notification) => [
                'id' => $notification->id,
                'message' => $notification->data['message'] ?? $notification->message ?? '-',
                'link' => $notification->data['link'] ?? null,
            ])
            ->values();

        return response()->json([
            'data' => $notifications,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    public function metrics(): JsonResponse
    {
        /** @var \App\Modules\Identity\Models\User $user */
        $user = Auth::user();

        return response()->json($this->buildMetrics($user));
    }

    public function exportStatusOverviewCsv(): StreamedResponse
    {
        /** @var \App\Modules\Identity\Models\User $user */
        $user = Auth::user();
        $statusOverview = $this->statusOverviewData($user);

        return response()->streamDownload(function () use ($statusOverview) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Status', 'Count']);

            foreach ($statusOverview['rows'] as $row) {
                fputcsv($handle, [$row['status'], $row['count']]);
            }

            fclose($handle);
        }, 'task-status-overview-'.now()->format('Ymd_His').'.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportStatusOverviewPdf()
    {
        /** @var \App\Modules\Identity\Models\User $user */
        $user = Auth::user();
        $statusOverview = $this->statusOverviewData($user);

        $pdf = Pdf::loadView('reports.exports.status-overview-pdf', [
            'generatedAt' => now(),
            'rows' => $statusOverview['rows'],
            'donePercentage' => $statusOverview['donePercentage'],
            'inProgressPercentage' => $statusOverview['inProgressPercentage'],
        ]);

        return $pdf->download('task-status-overview-'.now()->format('Ymd_His').'.pdf');
    }

    private function buildDashboardData($user): array
    {
        $isAdmin = $user->isAdmin();

        $activeProjectsCount = $isAdmin
            ? Project::query()->count()
            : Project::query()
                ->whereHas('members', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->count();

        $myTasksCount = $isAdmin
            ? Task::query()->where('status', '!=', 'done')->count()
            : Task::query()
                ->whereHas('assignees', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->where('status', '!=', 'done')
                ->count();

        $pendingReviewCount = Task::query()
            ->where('status', 'for_review')
            ->when(! $user->hasAnyRole(['admin', 'lead', 'manager', 'project_manager', 'pm']), function ($query) use ($user) {
                return $query->whereHas('assignees', function ($assigneeQuery) use ($user) {
                    $assigneeQuery->where('user_id', $user->id);
                });
            })
            ->count();

        $overdueCount = Task::query()
            ->where('due_date', '<', now())
            ->where('status', '!=', 'done')
            ->when(! $isAdmin, function ($query) use ($user) {
                return $query->whereHas('assignees', function ($assigneeQuery) use ($user) {
                    $assigneeQuery->where('user_id', $user->id);
                });
            })
            ->count();

        $totalProjects = $activeProjectsCount;

        $projectIds = $isAdmin
            ? Project::query()->pluck('id')
            : Project::query()
                ->where(function ($query) use ($user) {
                    $query->where('created_by', $user->id)
                        ->orWhereHas('members', function ($memberQuery) use ($user) {
                            $memberQuery->where('user_id', $user->id);
                        });
                })
                ->pluck('id');

        $projectProgress = Project::query()
            ->whereIn('id', $projectIds)
            ->with([
                'tasks' => fn ($q) => $q
                    ->where(function ($sub) {
                        $sub->where('team', 'sales')
                            ->orWhere('team', 'technical')
                            ->orWhereRaw('LOWER(team_in_charge) IN (?, ?)', ['sales', 'technical']);
                    })
                    ->select(['id', 'project_id', 'task_no', 'title', 'status', 'priority', 'due_date', 'team_in_charge', 'team']),
            ])
            ->withCount([
                'tasks as total_tasks_count',
                'tasks as done_tasks_count' => fn ($query) => $query->where('status', 'done'),
                'tasks as sales_tasks_count' => fn ($query) => $query->where(function ($query) {
                    $salesPeople = ['lawrence solee', 'norman reyes', 'philip borromeo', 'vera andino'];
                    $query->where('team', 'sales')
                        ->orWhere(function ($sub) use ($salesPeople) {
                            $sub->whereRaw('LOWER(team_in_charge) IN ('.implode(',', array_fill(0, count($salesPeople), '?')).')', $salesPeople);
                        });
                }),
                'tasks as sales_done_tasks_count' => fn ($query) => $query->where(function ($query) {
                    $salesPeople = ['lawrence solee', 'norman reyes', 'philip borromeo', 'vera andino'];
                    $query->where('team', 'sales')
                        ->orWhere(function ($sub) use ($salesPeople) {
                            $sub->whereRaw('LOWER(team_in_charge) IN ('.implode(',', array_fill(0, count($salesPeople), '?')).')', $salesPeople);
                        });
                })->where('status', 'done'),
                'tasks as technical_tasks_count' => fn ($query) => $query->where(function ($query) {
                    $technicalPeople = ['edcel ching', 'rupert moreno', 'ronnel gusi', 'samuel tabuzo', 'jobert vallejos', 'reuben guevara', 'jomer delgado', 'ryan fallan', 'carlo roldan'];
                    $query->where('team', 'technical')
                        ->orWhere(function ($sub) use ($technicalPeople) {
                            $sub->whereRaw('LOWER(team_in_charge) IN ('.implode(',', array_fill(0, count($technicalPeople), '?')).')', $technicalPeople);
                        });
                }),
                'tasks as technical_done_tasks_count' => fn ($query) => $query->where(function ($query) {
                    $technicalPeople = ['edcel ching', 'rupert moreno', 'ronnel gusi', 'samuel tabuzo', 'jobert vallejos', 'reuben guevara', 'jomer delgado', 'ryan fallan', 'carlo roldan'];
                    $query->where('team', 'technical')
                        ->orWhere(function ($sub) use ($technicalPeople) {
                            $sub->whereRaw('LOWER(team_in_charge) IN ('.implode(',', array_fill(0, count($technicalPeople), '?')).')', $technicalPeople);
                        });
                })->where('status', 'done'),
            ])
            ->orderBy('name')
            ->take(10)
            ->get()
            ->map(function ($project) {
                $total = max(1, (int) $project->total_tasks_count);
                $done  = (int) $project->done_tasks_count;

                $mapTask = fn ($t) => [
                    'id'       => $t->id,
                    'task_no'  => $t->task_no ?? '',
                    'title'    => $t->title,
                    'status'   => $t->status,
                    'priority' => $t->priority ?? 'medium',
                    'due_date' => $t->due_date?->format('Y-m-d'),
                ];

                $salesPeople = ['lawrence solee', 'norman reyes', 'philip borromeo', 'vera andino'];
                $technicalPeople = ['edcel ching', 'rupert moreno', 'ronnel gusi', 'samuel tabuzo', 'jobert vallejos', 'reuben guevara', 'jomer delgado', 'ryan fallan', 'carlo roldan'];

                $salesTasks = $project->tasks->filter(function ($t) use ($salesPeople) {
                    return $t->team === 'sales' || in_array(strtolower((string) $t->team_in_charge), $salesPeople, true);
                })->values();
                $technicalTasks = $project->tasks->filter(function ($t) use ($technicalPeople) {
                    return $t->team === 'technical' || in_array(strtolower((string) $t->team_in_charge), $technicalPeople, true);
                })->values();

                $salesTotal     = (int) $project->sales_tasks_count;
                $salesDone      = (int) $project->sales_done_tasks_count;
                $technicalTotal = (int) $project->technical_tasks_count;
                $technicalDone  = (int) $project->technical_done_tasks_count;

                return [
                    'id'      => $project->id,
                    'name'    => $project->name,
                    'total'   => (int) $project->total_tasks_count,
                    'done'    => $done,
                    'percent' => (int) round(($done / $total) * 100),
                    'sales' => [
                        'total'   => $salesTotal,
                        'done'    => $salesDone,
                        'percent' => $salesTotal > 0 ? (int) round(($salesDone / $salesTotal) * 100) : 0,
                        'tasks'   => $salesTasks->map($mapTask)->toArray(),
                    ],
                    'technical' => [
                        'total'   => $technicalTotal,
                        'done'    => $technicalDone,
                        'percent' => $technicalTotal > 0 ? (int) round(($technicalDone / $technicalTotal) * 100) : 0,
                        'tasks'   => $technicalTasks->map($mapTask)->toArray(),
                    ],
                ];
            })
            ->values();

        $allMyTasksQuery = Task::query()->with(['project', 'assignees']);

        if (! $isAdmin) {
            $allMyTasksQuery->whereHas('assignees', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $myTasks = (clone $allMyTasksQuery)->get();
        $taskBaseQuery = (clone $allMyTasksQuery)->where('status', '!=', 'done');

        $totalTasks = $myTasksCount;
        $pendingReview = $pendingReviewCount;
        $overdue = $overdueCount;
        $urgentTasks = (clone $taskBaseQuery)
            ->whereNotNull('due_date')
            ->where('due_date', '<=', now()->addHours(48))
            ->orderBy('due_date')
            ->get();
        $upcomingTasks = $myTasks
            ->filter(fn ($t) => $t->due_date && $t->due_date->isFuture() && $t->due_date->lte(now()->addDays(7)))
            ->sortBy('due_date')
            ->take(5)
            ->values();

        $metrics = $this->buildMetrics($user);

        $recentActivity = TaskActivityLog::whereIn('task_id', $myTasks->pluck('id'))
            ->with('actor')
            ->latest()
            ->take(5)
            ->get();

        $recentActivities = TaskActivityLog::query()
            ->with(['actor', 'task'])
            ->latest()
            ->when(! $user->hasAnyRole(['admin', 'lead']), function ($query) use ($user) {
                return $query->whereHas('task.assignees', function ($assigneeQuery) use ($user) {
                    $assigneeQuery->where('user_id', $user->id);
                });
            })
            ->take(5)
            ->get();

        $latestNotifications = $user->unreadNotifications()->latest()->limit(3)->get();

        $adminStats = null;
        if ($user->isAdmin()) {
            $adminStats = [
                'totalUsers' => \App\Modules\Identity\Models\User::count(),
                'totalTasks' => \App\Modules\Tasks\Models\Task::count(),
                'totalProjects' => \App\Modules\Projects\Models\Project::count(),
            ];
        }

        return [
            'totalProjects' => $totalProjects,
            'totalTasks' => $totalTasks,
            'pendingReview' => $pendingReview,
            'overdue' => $overdue,
            'urgentTasks' => $urgentTasks,
            'upcomingTasks' => $upcomingTasks,
            'myTasks' => $myTasks->take(10),
            'recentActivity' => $recentActivity,
            'recentActivities' => $recentActivities,
            'latestNotifications' => $latestNotifications,
            'adminStats' => $adminStats,
            'statusLabels' => $metrics['statusLabels'],
            'statusCounts' => $metrics['statusCounts'],
            'chartData' => $metrics['chartData'],
            'tasksPerDay' => $metrics['tasksPerDay'],
            'tasksPerDayLabels' => $metrics['tasksPerDayLabels'],
            'tasksPerDayLabelsFormatted' => $metrics['tasksPerDayLabelsFormatted'],
            'donePercentage' => $metrics['donePercentage'],
            'inProgressPercentage' => $metrics['inProgressPercentage'],
            'userRoleLabel' => $user->roleLabel(),
            'activeProjectsCount' => $activeProjectsCount,
            'myTasksCount' => $myTasksCount,
            'pendingReviewCount' => $pendingReviewCount,
            'overdueCount' => $overdueCount,
            'projectProgress' => $projectProgress,
            'systemAnnouncement' => SystemSetting::valueOf('system_announcement', 'Manual spreadsheet tracking is now transitioned to a centralized workflow with live status visibility, Kanban execution, and automated daily reports.'),
        ];
    }

    private function buildMetrics($user, $projectIds = null, $myTasks = null): array
    {
        $canViewGlobal = $user->hasAnyRole(['admin', 'manager', 'project_manager', 'pm', 'lead']);

        $projectIds = $projectIds ?? ($canViewGlobal
            ? Project::query()->pluck('id')
            : Project::query()
                ->where(function ($query) use ($user) {
                    $query->where('created_by', $user->id)
                        ->orWhereHas('members', function ($memberQuery) use ($user) {
                            $memberQuery->where('user_id', $user->id);
                        });
                })
                ->pluck('id'));

        $myTasks = $myTasks ?? ($canViewGlobal
            ? Task::query()->get()
            : Task::query()
                ->whereHas('assignees', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get());

        $statusLabels = ['todo', 'in_progress', 'for_review', 'done'];
        $statusCountsByStatus = Task::query()
            ->selectRaw('status, count(*) as total')
            ->when(! $canViewGlobal, function ($query) use ($user) {
                return $query->whereHas('assignees', function ($assigneeQuery) use ($user) {
                    $assigneeQuery->where('user_id', $user->id);
                });
            })
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $inProgressTotal = (int) ($statusCountsByStatus['in_progress'] ?? 0) + (int) ($statusCountsByStatus['for_review'] ?? 0);

        $chartData = [
            (int) ($statusCountsByStatus['todo'] ?? 0),
            $inProgressTotal,
            0,
            (int) ($statusCountsByStatus['done'] ?? 0),
        ];

        $statusCounts = $chartData;

        $totalTasks = max(1, $myTasks->count());
        $doneCount = $myTasks->where('status', 'done')->count();
        // Include tasks in for_review as part of active in-progress pipeline for dashboard overview
        $inProgressCount = $myTasks->whereIn('status', ['in_progress', 'for_review'])->count();

        $days = collect(range(0, 6))->map(fn ($i) => now()->subDays(6 - $i)->format('Y-m-d'));
        $tasksPerDay = $days->map(function ($date) use ($projectIds) {
            return Task::whereDate('created_at', $date)
                ->whereIn('project_id', $projectIds)
                ->count();
        })->values();

        $tasksPerDayLabelsFormatted = $days
            ->map(fn ($day) => \Carbon\Carbon::parse($day)->format('D'))
            ->values();

        return [
            'statusLabels' => $statusLabels,
            'statusCounts' => $statusCounts,
            'chartData' => $chartData,
            'tasksPerDay' => $tasksPerDay,
            'tasksPerDayLabels' => $days,
            'tasksPerDayLabelsFormatted' => $tasksPerDayLabelsFormatted,
            'donePercentage' => (int) round(($doneCount / $totalTasks) * 100),
            'inProgressPercentage' => (int) round(($inProgressCount / $totalTasks) * 100),
        ];
    }

    private function statusOverviewData($user): array
    {
        $metrics = $this->buildMetrics($user);

        return [
            'rows' => [
                ['status' => 'Todo', 'count' => (int) ($metrics['chartData'][0] ?? 0)],
                ['status' => 'In Progress', 'count' => (int) ($metrics['chartData'][1] ?? 0)],
                ['status' => 'For Review', 'count' => (int) ($metrics['chartData'][2] ?? 0)],
                ['status' => 'Done', 'count' => (int) ($metrics['chartData'][3] ?? 0)],
            ],
            'donePercentage' => (int) ($metrics['donePercentage'] ?? 0),
            'inProgressPercentage' => (int) ($metrics['inProgressPercentage'] ?? 0),
        ];
    }
}
