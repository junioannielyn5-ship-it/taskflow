<?php

namespace App\Modules\Tasks\Http\Controllers;

use App\Modules\Projects\Models\Project;
use App\Modules\Tasks\Http\Requests\AssignTaskRequest;
use App\Modules\Tasks\Filters\TaskFilters;
use App\Modules\Tasks\Http\Requests\StoreTaskRequest;
use App\Modules\Tasks\Http\Requests\UpdateTaskRequest;
use App\Modules\Tasks\Models\Task;
use App\Modules\Shared\Enums\TaskStatus;
use App\Modules\Tasks\Services\TaskService;
use App\Modules\Tasks\Support\TaskProcessCatalog;
use App\Modules\Workflow\Services\WorkflowService;
use App\Modules\Admin\Models\TaskCompany;
use App\Modules\Admin\Models\TaskProcessOption;
use App\Modules\Admin\Models\TaskTeamOption;
use App\Modules\Projects\Services\ProjectService;
use App\Modules\Identity\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class TaskController extends Controller
{
    /**
     * Resolve project ID from route or object.
     */
    private function resolveProjectId(mixed $projectRoute): int
    {
        if ($projectRoute instanceof Project) {
            return (int) $projectRoute->getKey();
        }
        if (is_object($projectRoute) && method_exists($projectRoute, 'getKey')) {
            return (int) $projectRoute->getKey();
        }
        if (is_numeric($projectRoute)) {
            return (int) $projectRoute;
        }
        return 0;
    }
    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $projects = Project::all();
        $assignees = User::all();
        $workflowService = app(WorkflowService::class);

        $currentStatus = (string) $task->status;
        $statusOptions = collect([$currentStatus, ...$workflowService->getValidTransitions($currentStatus)])
            ->filter()
            ->unique()
            ->values()
            ->all();

        $statusLabels = [
            TaskStatus::TODO->value => 'To Do',
            TaskStatus::IN_PROGRESS->value => 'In Progress',
            TaskStatus::BLOCKED->value => 'Blocked',
            TaskStatus::FOR_REVIEW->value => 'For Review',
            TaskStatus::DONE->value => 'Done',
            TaskStatus::CANCELLED->value => 'Cancelled',
        ];

        return view('tasks.edit', [
            'task' => $task,
            'projects' => $projects,
            'assignees' => $assignees,
            'statusOptions' => $statusOptions,
            'statusLabels' => $statusLabels,
        ]);
    }
    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $user = Auth::user();

        $processCatalog = TaskProcessCatalog::all();
        $tasks = Task::all();

        $projectsQuery = Project::query()
            ->with(['tasks:id,project_id,title,status', 'members:id,project_id,user_id'])
            ->select(['id', 'name', 'created_by'])
            ->orderBy('name');

        // If user doesn't have create-task permission, only show projects they're members of
        if (!Gate::allows('create-task', $user)) {
            $projectsQuery->where(function ($query) use ($user) {
                $query->where('created_by', $user->id)
                    ->orWhereHas('members', function ($memberQuery) use ($user) {
                        $memberQuery->where('user_id', $user->id);
                    });
            });
        }

        $projects = $projectsQuery->get();

        $assigneeWhitelistNames = collect([
            'Edcel Ching',
            'Rupert Moreno',
            'Ronnel Gusi',
            'Samuel Tabuzo',
            'Jobert Vallejos',
            'Reuben Guevara',
            'Jomer Delgado',
            'Ryan Fallan',
            'Carlo Roldan',
            'Employee User',
            'Lawrence Solee',
            'Norman Reyes',
            'Philip Borromeo',
            'Jen Borromeo',
            'Pierre Borromeo',
            'Kacey Arigo',
            'Reagan Timblaco',
            'Yna Garrote',
            'Yen Junio',
            'yen junio',
        ])
        ->unique()
        ->values();

        $assigneeWhitelistLower = $assigneeWhitelistNames
            ->map(fn ($name) => mb_strtolower(trim($name)))
            ->unique()
            ->values();

        $allUsers = User::query()
            ->whereIn(DB::raw('LOWER(TRIM(name))'), $assigneeWhitelistLower->all())
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn ($u) => ['id' => $u->id, 'name' => $u->name])
            ->values();

        $employeeDefaultAssigneeIds = User::query()
            ->whereIn('role', ['member', 'employee'])
            ->orderBy('name')
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->values();

        $projectMembers = $projects->mapWithKeys(function ($project) use ($allUsers) {
            return [$project->id => $allUsers];
        });

        $projectDefaultAssignees = $projects->mapWithKeys(function ($project) use ($employeeDefaultAssigneeIds) {
            return [$project->id => $employeeDefaultAssigneeIds];
        });

        $projectTasks = $projects->mapWithKeys(function ($project) {
            return [
                $project->id => $project->tasks
                    ->sortBy('title')
                    ->map(fn ($task) => [
                        'id' => $task->id,
                        'title' => $task->title,
                        'status' => $task->status,
                    ])
                    ->values(),
            ];
        });

        // Only use the exact keys from processCatalog to avoid mismatch
        $taskProcessOptions = collect(array_keys($processCatalog))->values();

        $personInChargeDirectory = [
            'Pre-Sales' => [
                'Ronnel Gusi',
                'Samuel Tabuzo',
            ],
            'Sales' => [
                'Lawrence Solee',
                'Norman Reyes',
                'Philip Borromeo',
                'Vera Andino',
                'Edcel Ching',
            ],
            'Technical' => [
                'Edcel Ching',
                'Rupert Moreno',
                'Ronnel Gusi',
                'Samuel Tabuzo',
                'Jobert Vallejos',
                'Reuben Guevara',
                'Jomer Delgado',
                'Ryan Fallan',
                'Carlo Roldan',
                'Yen Junio',
            ],
            'Admin and Support' => [
                'Vera Andino',
                'Philip Borromeo',
                'Jen Borromeo',
                'Pierre Borromeo',
                'Kacey Arigo',
                'Reagan Timblaco',
                'Yna Garrote',
            ],
        ];

        // Remove legacyTeamOptions and only use directory for dropdown
        $flattenedPicOptions = collect($personInChargeDirectory)
            ->flatten()
            ->unique()
            ->values();

        // Ensure any admin-defined process still has a selectable specific process.
        foreach ($taskProcessOptions as $processName) {
            if (!array_key_exists($processName, $processCatalog)) {
                $processCatalog[$processName] = [
                    ['name' => 'General', 'sla_days' => 1],
                ];
            }
        }

        $nextTaskSequence = (int) (Task::max('id') ?? 0) + 1;

        return view('tasks.create', [
            'projects' => $projects,
            'projectMembers' => $projectMembers,
            'projectDefaultAssignees' => $projectDefaultAssignees,
            'projectTasks' => $projectTasks,
            'nextTaskSequence' => $nextTaskSequence,
            'companyOptions' => TaskCompany::query()->where('is_active', true)->orderBy('name')->pluck('name'),
            'taskProcessOptions' => $taskProcessOptions,
            'teamOptions' => $flattenedPicOptions,
            'personInChargeDirectory' => $personInChargeDirectory,
            'processCatalog' => $processCatalog,
                'tasks' => $tasks,
        ]);
    }

    public function __construct(
        private TaskService $taskService
    ) {}

    /**
     * Get all tasks in a project with filters.
     */
    public function index()
    {
        $projectId = $this->resolveProjectId(request()->route('project'));
        /** @var \App\Modules\Identity\Models\User $user */
        $user = Auth::user();
        $filters = request()->all();
        $perPage = max(1, min(100, (int) request()->integer('per_page', 20)));

        if ($projectId > 0) {
            $project = Project::findOrFail($projectId);
            $this->authorize('view', $project);

            $tasks = $this->taskService->getProjectTasks($projectId, $user->id, $filters, $perPage);

            return response()->json([
                'data' => $tasks->items(),
                'count' => $tasks->count(),
                'total' => $tasks->total(),
                'pagination' => [
                    'current_page' => $tasks->currentPage(),
                    'last_page' => $tasks->lastPage(),
                    'per_page' => $tasks->perPage(),
                    'total' => $tasks->total(),
                ],
            ], 200);
        }

        $tasksQuery = Task::query()
            ->with([
                'project.members',
                'creator',
                'assignees',
                'blockedByTask:id,title,status',
                'latestComment.user:id,name',
            ])
            ->withCount('comments');

        if (!$user->isAdmin()) {
            $tasksQuery->where(function ($query) use ($user) {
                $query->whereHas('project', function ($projectQuery) use ($user) {
                    $projectQuery->where('created_by', $user->id);
                })->orWhereHas('project.members', function ($memberQuery) use ($user) {
                    $memberQuery->where('user_id', $user->id);
                })->orWhereHas('assignees', function ($assigneeQuery) use ($user) {
                    $assigneeQuery->where('user_id', $user->id);
                });
            });
        }

        $assigneeWhitelistNames = collect([
            'Edcel Ching',
            'Rupert Moreno',
            'Ronnel Gusi',
            'Samuel Tabuzo',
            'Jobert Vallejos',
            'Reuben Guevara',
            'Jomer Delgado',
            'Ryan Fallan',
            'Carlo Roldan',
            'Employee User',
            'Yen Junio',
            'yen junio',
        ]);

        $assigneeWhitelistLower = $assigneeWhitelistNames
            ->map(fn ($name) => mb_strtolower(trim($name)))
            ->unique()
            ->values();

        $assignees = User::query()
            ->whereIn(DB::raw('LOWER(TRIM(name))'), $assigneeWhitelistLower->all())
            ->orderBy('name')
            ->get(['id', 'name']);

        $dependencyOptions = (clone $tasksQuery)
            ->select(['id', 'title'])
            ->orderBy('title')
            ->get();

        $activeProjectsCount = Project::query()
            ->where(function ($query) use ($user) {
                $query->where('created_by', $user->id)
                    ->orWhereHas('members', function ($memberQuery) use ($user) {
                        $memberQuery->where('user_id', $user->id);
                    });
            })
            ->count();

        $visibleTasksSummaryQuery = Task::query();

        if (! $user->isAdmin()) {
            $visibleTasksSummaryQuery->where(function ($query) use ($user) {
                $query->whereHas('project', function ($projectQuery) use ($user) {
                    $projectQuery->where('created_by', $user->id);
                })->orWhereHas('project.members', function ($memberQuery) use ($user) {
                    $memberQuery->where('user_id', $user->id);
                })->orWhereHas('assignees', function ($assigneeQuery) use ($user) {
                    $assigneeQuery->where('user_id', $user->id);
                });
            });
        }

        $myTasksCount = (clone $visibleTasksSummaryQuery)
            ->whereHas('assignees', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereRaw('LOWER(TRIM(status)) != ?', [TaskStatus::DONE->value])
            ->count();

        $pendingReviewCount = (clone $visibleTasksSummaryQuery)
            ->whereRaw('LOWER(TRIM(status)) = ?', [TaskStatus::FOR_REVIEW->value])
            ->when(! $user->hasAnyRole(['admin', 'lead', 'manager', 'project_manager', 'pm']), function ($query) use ($user) {
                return $query->whereHas('assignees', function ($assigneeQuery) use ($user) {
                    $assigneeQuery->where('user_id', $user->id);
                });
            })
            ->count();

        $overdueCount = (clone $visibleTasksSummaryQuery)
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now()->toDateString())
            ->whereRaw('LOWER(TRIM(status)) != ?', [TaskStatus::DONE->value])
            ->whereHas('assignees', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->count();

        $activeTaskFilters = [
            'status' => $filters['status'] ?? null,
            'priority' => $filters['priority'] ?? null,
            'search' => $filters['search'] ?? null,
            'assignee' => $filters['assignee'] ?? null,
            'company' => $filters['company'] ?? null,
            'date_received' => $filters['date_received'] ?? null,
            'blocked_by_task_id' => $filters['blocked_by_task_id'] ?? null,
        ];

        $doneTaskFilters = $activeTaskFilters;
        $doneTaskFilters['status'] = TaskStatus::DONE->value;

        $tasks = TaskFilters::apply($tasksQuery, $activeTaskFilters);

        if (empty($filters['status'])) {
            $tasks->whereRaw('LOWER(TRIM(status)) != ?', [TaskStatus::DONE->value]);
        }

        $tasks = $tasks
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();

        // Add member_role to each task's project
        $tasks->getCollection()->transform(function ($task) use ($user) {
            if ($task->project) {
                if ($user->isAdmin()) {
                    $task->project->member_role = 'admin';
                } else {
                    $member = $task->project->members->firstWhere('user_id', $user->id);
                    $task->project->member_role = $member ? $member->role : 'member';
                }
            }
            return $task;
        });

        $doneTasksQuery = Task::query()
            ->with([
                'project.members',
                'creator',
                'assignees',
                'blockedByTask:id,title,status',
                'latestComment.user:id,name',
            ])
            ->withCount('comments');

        $canViewGlobalDone = $user->isAdmin() || $user->hasAnyRole(['manager', 'project_manager', 'pm', 'lead']);

        if (!$canViewGlobalDone) {
            $doneTasksQuery->where(function ($query) use ($user) {
                $query->whereHas('project', function ($projectQuery) use ($user) {
                    $projectQuery->where('created_by', $user->id);
                })->orWhereHas('project.members', function ($memberQuery) use ($user) {
                    $memberQuery->where('user_id', $user->id);
                })->orWhereHas('assignees', function ($assigneeQuery) use ($user) {
                    $assigneeQuery->where('user_id', $user->id);
                });
            });
        }

        $doneTasks = TaskFilters::apply($doneTasksQuery, $doneTaskFilters)
            ->orderByDesc('updated_at')
            ->paginate(10, ['*'], 'done_page')
            ->withQueryString();

        // Add member_role to each done task's project
        $doneTasks->getCollection()->transform(function ($task) use ($user) {
            if ($task->project) {
                if ($user->isAdmin()) {
                    $task->project->member_role = 'admin';
                } else {
                    $member = $task->project->members->firstWhere('user_id', $user->id);
                    $task->project->member_role = $member ? $member->role : 'member';
                }
            }
            return $task;
        });

        $doneTasksCount = TaskFilters::apply(clone $doneTasksQuery, $doneTaskFilters)->count();

        if (request()->expectsJson()) {
            return response()->json([
                'data' => $tasks->items(),
                'count' => $tasks->count(),
                'total' => $tasks->total(),
                'pagination' => [
                    'current_page' => $tasks->currentPage(),
                    'last_page' => $tasks->lastPage(),
                    'per_page' => $tasks->perPage(),
                    'total' => $tasks->total(),
                ],
                'summary' => [
                    'active_projects' => $activeProjectsCount,
                    'my_tasks' => $myTasksCount,
                    'pending_review' => $pendingReviewCount,
                    'overdue' => $overdueCount,
                    'done_tasks' => $doneTasksCount,
                ],
            ], 200);
        }

        return view('tasks.index', compact(
            'tasks',
            'filters',
            'assignees',
            'dependencyOptions',
            'activeProjectsCount',
            'myTasksCount',
            'pendingReviewCount',
            'overdueCount',
            'doneTasks',
            'doneTasksCount'
        ));
    }

    /**
     * Display tasks in Kanban format.
     */
    public function kanban()
    {
        /** @var \App\Modules\Identity\Models\User $user */
        $user = Auth::user();

        $tasksQuery = Task::query()->with(['project', 'creator:id,name', 'assignees', 'blockedByTask:id,title,status']);

        if (!$user->isAdmin()) {
            $tasksQuery->where(function ($query) use ($user) {
                $query->whereHas('project.members', function ($memberQuery) use ($user) {
                    $memberQuery->where('user_id', $user->id);
                })->orWhereHas('assignees', function ($assigneeQuery) use ($user) {
                    $assigneeQuery->where('user_id', $user->id);
                })->orWhereHas('project', function ($projectQuery) use ($user) {
                    $projectQuery->where('created_by', $user->id);
                });
            });
        }

        $tasks = $tasksQuery
            ->orderByDesc('created_at')
            ->get();

        $projects = $tasks
            ->pluck('project')
            ->filter(fn ($project) => !is_null($project))
            ->unique('id')
            ->sortBy('name')
            ->values()
            ->map(fn ($project) => [
                'id' => $project->id,
                'name' => $project->name,
            ]);

        $columns = [
            'backlogs' => $tasks->filter(fn (Task $task) => in_array($task->status, ['blocked', 'cancelled'], true))->values(),
            'todo' => $tasks->where('status', 'todo')->values(),
            'in_progress' => $tasks->filter(fn (Task $task) => in_array($task->status, ['in_progress', 'for_review'], true))->values(),
            'done' => $tasks->where('status', 'done')->values(),
        ];

        return view('tasks.kanban', [
            'columns' => $columns,
            'projects' => $projects,
        ]);
    }

    /**
     * Create a new task in a project.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            $projectId = $this->resolveProjectId($request->route('project'));

            if ($projectId <= 0) {
                $projectId = (int) $request->input('project_id');
            }

            if ($projectId <= 0) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Project is required',
                        'errors' => ['project_id' => ['Project is required']],
                    ], 422);
                }

                return back()->withErrors(['project_id' => 'Project is required'])->withInput();
            }

            $user = Auth::user();

            $data = $request->validated();

            // If a file was uploaded, store it and use its URL as document_link
            if ($request->hasFile('document_file') && $request->file('document_file')->isValid()) {
                $path = $request->file('document_file')->store('task-documents', 'public');
                $data['document_link'] = Storage::url($path);
            }
            unset($data['document_file']);

            $task = $this->taskService->createTask($projectId, $user->id, $data);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Task created successfully',
                    'data' => $task->load('creator', 'assignees'),
                ], 201);
            }

            return redirect()->route('tasks.list')->with('success', 'Task created successfully and added to your To-Do list.');
        } catch (\Exception $e) {
            Log::error('Task creation error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'error' => $e->getMessage(),
                ], 403);
            }

            return back()->withErrors(['task' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Get a specific task.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load([
            'creator',
            'assignees',
            'project',
            'blockedByTask:id,title,status',
            'comments.user',
            'activityLogs.actor',
            'attachments' => fn ($query) => $query->latest(),
            'timeLogs' => fn ($query) => $query->latest('started_at'),
            'checklistItems.completedBy',
        ]);

        if (!request()->expectsJson()) {
            $myTimeLogs = $task->timeLogs
                ->where('user_id', Auth::id())
                ->values();

            $hasActiveTimer = $myTimeLogs->contains(function ($log) {
                return $log->started_at && is_null($log->stopped_at);
            });

            $myTotalSeconds = (int) $myTimeLogs->sum(function ($log) {
                if (!is_null($log->total_seconds)) {
                    return (int) $log->total_seconds;
                }

                if ($log->started_at && is_null($log->stopped_at)) {
                    return max(0, $log->started_at->diffInSeconds(now(), false));
                }

                return 0;
            });

            return view('tasks.show', [
                'task' => $task,
                'myTotalSeconds' => $myTotalSeconds,
                'hasActiveTimer' => $hasActiveTimer,
                'recentTimeLogs' => $myTimeLogs->take(10),
            ]);
        }

        return response()->json([
            'data' => $task,
        ], 200);
    }

    /**
     * Update a task.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $oldStatus = $task->status;

        $validated = $request->validated();

        if (array_key_exists('status', $validated) && $validated['status'] !== $task->status) {
            $workflowService = app(WorkflowService::class);

            $transitioned = $workflowService->updateStatus(
                $task,
                $validated['status'],
                Auth::user()
            );

            if (!$transitioned) {
                $message = 'Invalid status transition. Move task through the workflow stages first.';

                if (!$request->expectsJson()) {
                    return back()
                        ->withErrors(['status' => $message])
                        ->withInput();
                }

                return response()->json([
                    'message' => $message,
                ], 422);
            }

            unset($validated['status']);
        }

        $task = $this->taskService->updateTask($task, $validated);

        if (!$request->expectsJson()) {
            return redirect()->route('tasks.show', $task)->with('success', 'Task updated successfully');
        }

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task->load('creator', 'assignees'),
            'status_changed' => $oldStatus !== $task->status,
        ], 200);
    }

    /**
     * Delete a task.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $this->taskService->deleteTask($task);

        if (!request()->expectsJson()) {
            return redirect()->route('tasks.list')->with('success', 'Task deleted successfully');
        }

        return response()->json([
            'message' => 'Task deleted successfully',
        ], 200);
    }

    /**
     * Assign a user to a task.
     */
    public function assign(AssignTaskRequest $request, Task $task)
    {
        $this->authorize('assign', $task);

        try {
            $this->taskService->assignUser($task, $request->user_id, Auth::user());

            return response()->json([
                'message' => 'User assigned to task successfully',
                'data' => $task->load('assignees'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 403);
        }
    }

    /**
     * Remove a user from a task.
     */
    public function unassign(Task $task, int $userId)
    {
        /** @var \App\Modules\Identity\Models\User $actor */
        $actor = Auth::user();

        $projectId = (int) ($task->project_id ?? 0);

        $canUnassign = $actor->isAdmin()
            || (int) $actor->id === (int) $task->created_by
            || ($projectId > 0 && app(ProjectService::class)->isLead($projectId, (int) $actor->id));

        abort_unless($canUnassign, 403);

        $this->taskService->unassignUser($task, $userId);

        return response()->json([
            'message' => 'User unassigned from task successfully',
            'data' => $task->load('assignees'),
        ], 200);
    }
}
