@extends('layouts.app')

@section('content')
<style>
    .tasks-table th:last-child,
    .tasks-table td:last-child {
        position: sticky;
        right: 0;
        z-index: 5;
        background-color: #ffffff;
        box-shadow: -6px 0 15px -3px rgba(0, 0, 0, 0.05);
        border-left: 1px solid #e2e8f0;
        transition: background-color 0.2s;
    }
    html.dark .tasks-table th:last-child,
    html.dark .tasks-table td:last-child {
        background-color: #1e293b; /* slate-800 */
        box-shadow: -6px 0 15px -3px rgba(0, 0, 0, 0.4);
        border-left: 1px solid #334155;
    }
    /* Match row hover */
    .tasks-table tr:hover td:last-child {
        background-color: #f8fafc; /* slate-50 */
    }
    html.dark .tasks-table tr:hover td:last-child {
        background-color: #334155; /* slate-700 */
    }
    .tasks-table thead th:last-child {
        z-index: 15;
        background-color: #ffffff;
    }
    html.dark .tasks-table thead th:last-child {
        background-color: #1e293b;
    }
    /* Priority pin badges */
    .priority-pin {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.12);
        border: 1px solid transparent;
    }
    .pin-dot {
        box-shadow: 0 0 0 3px rgba(255,255,255,0.45);
    }
    .dark .pin-dot {
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.5);
    }
    .priority-pin.pin-urgent {
        background: #fef2f2 !important;
        color: #dc2626 !important;
        border-color: #fca5a5 !important;
    }
    .priority-pin.pin-high {
        background: #fff7ed !important;
        color: #ea580c !important;
        border-color: #fdba74 !important;
    }
    .priority-pin.pin-medium {
        background: #fefce8 !important;
        color: #ca8a04 !important;
        border-color: #fde047 !important;
    }
    .priority-pin.pin-low {
        background: #f0fdf4 !important;
        color: #16a34a !important;
        border-color: #86efac !important;
    }
    .dark .priority-pin.pin-urgent {
        background: rgba(220, 38, 38, 0.15) !important;
        color: #fca5a5 !important;
        border-color: rgba(220, 38, 38, 0.3) !important;
    }
    .dark .priority-pin.pin-high {
        background: rgba(234, 88, 12, 0.15) !important;
        color: #fdba74 !important;
        border-color: rgba(234, 88, 12, 0.3) !important;
    }
    .dark .priority-pin.pin-medium {
        background: rgba(202, 138, 4, 0.15) !important;
        color: #fde047 !important;
        border-color: rgba(202, 138, 4, 0.3) !important;
    }
    .dark .priority-pin.pin-low {
        background: rgba(22, 163, 74, 0.15) !important;
        color: #86efac !important;
        border-color: rgba(22, 163, 74, 0.3) !important;
    }
    .dark .pin-dot {
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.5);
    }
    .filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: flex-end;
    }
    .filter-group > div {
        flex: 1 1 160px;
        min-width: 120px;
    }
    .filter-advanced-toggle {
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        font-size: 1.2em;
        margin-left: 0.5rem;
        padding: 0.25em;
        transition: color 0.2s;
    }
    .filter-advanced-toggle:hover {
        color: #0ea5e9;
    }
    .action-btn {
        background: none;
        border: none;
        padding: 0.4em 0.6em;
        border-radius: 0.5em;
        color: #64748b;
        transition: background 0.2s, color 0.2s;
        font-size: 1.1em;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .action-btn:hover {
        background: #e0e7ef;
        color: #0ea5e9;
    }
    .dark .action-btn:hover {
        background: #334155;
        color: #38bdf8;
    }
    .tasks-table th.w-20, .tasks-table td.w-20 { width: 80px !important; min-width: 60px; }
    .tasks-table th.w-40, .tasks-table td.w-40 { width: 180px !important; min-width: 120px; }
    .tasks-table th.w-44, .tasks-table td.w-44 { width: 220px !important; min-width: 140px; }
    .tasks-table th.w-48, .tasks-table td.w-48 { width: 260px !important; min-width: 160px; }
    .tasks-table th.w-52, .tasks-table td.w-52 { width: 280px !important; min-width: 180px; }
    .tasks-table th.w-36, .tasks-table td.w-36 { width: 140px !important; min-width: 100px; }
    .tasks-table th.w-28, .tasks-table td.w-28 { width: 110px !important; min-width: 80px; }
    .tasks-table th.w-24, .tasks-table td.w-24 { width: 90px !important; min-width: 70px; }
    .tasks-table th.w-32, .tasks-table td.w-32 { width: 120px !important; min-width: 90px; }
</style>
<div class="relative space-y-6 tasks-page">
    <div class="pointer-events-none absolute right-0 top-0 h-64 w-64 translate-x-1/3 -translate-y-1/3 rounded-full bg-blue-100/40 blur-3xl dark:hidden"></div>
    <div class="pointer-events-none absolute bottom-0 left-20 h-52 w-52 rounded-full bg-slate-200/30 blur-3xl dark:hidden"></div>
    @php
        $currentTab = request('tab') === 'done' ? 'done' : 'active';
    @endphp

    <div class="relative inline-flex w-fit overflow-hidden rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-5 py-2.5 shadow-md dark:shadow-none" style="border-left: 4px solid #2563eb;">
        <p class="text-2xl font-bold uppercase tracking-wide text-slate-800 dark:text-slate-100 md:text-3xl">Task Manager</p>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
        <!-- Active Projects -->
          <a href="{{ route('tasks.list') }}"
              class="block rounded-2xl border border-slate-300 dark:border-slate-700 border-l-4 border-l-blue-400 bg-white dark:bg-slate-800 shadow-md dark:shadow-none px-4 py-3 transition hover:-translate-y-0.5 hover:shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">Active Projects</p>
            <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $activeProjectsCount ?? 0 }}</p>
        </a>
        <!-- My Tasks -->
          <a href="{{ route('tasks.list', ['assignee' => auth()->id()]) }}"
              class="block rounded-2xl border border-slate-300 dark:border-slate-700 border-l-4 border-l-purple-400 bg-white dark:bg-slate-800 shadow-md dark:shadow-none px-4 py-3 transition hover:-translate-y-0.5 hover:shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-wide text-purple-600 dark:text-purple-400">My Tasks</p>
            <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $myTasksCount ?? 0 }}</p>
        </a>
        <!-- Pending Review -->
          <a href="{{ route('tasks.list', ['status' => 'for_review']) }}"
              class="block rounded-2xl border border-slate-300 dark:border-slate-700 border-l-4 border-l-yellow-400 bg-white dark:bg-slate-800 shadow-md dark:shadow-none px-4 py-3 transition hover:-translate-y-0.5 hover:shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-wide text-yellow-600 dark:text-yellow-400">Pending Review</p>
            <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $pendingReviewCount ?? 0 }}</p>
        </a>
        <!-- Overdue -->
          <a href="{{ route('tasks.list', ['overdue' => 1]) }}"
              class="block rounded-2xl border border-slate-300 dark:border-slate-700 border-l-4 border-l-red-500 bg-white dark:bg-slate-800 shadow-md dark:shadow-none px-4 py-3 transition hover:-translate-y-0.5 hover:shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-wide text-red-600 dark:text-red-400">Overdue</p>
            <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $overdueCount ?? 0 }}</p>
        </a>
        <!-- Done -->
          <a href="{{ route('tasks.list', ['tab' => 'done']) }}"
              class="block rounded-2xl border border-slate-300 dark:border-slate-700 border-l-4 border-l-emerald-400 bg-white dark:bg-slate-800 shadow-md dark:shadow-none px-4 py-3 transition hover:-translate-y-0.5 hover:shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 dark:text-emerald-400">Done</p>
            <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $doneTasksCount ?? 0 }}</p>
        </a>
    </div>

    <div class="relative overflow-hidden rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 shadow-md dark:shadow-none">
        <span class="mr-1 text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Status Colors:</span>
        <span class="inline-flex items-center rounded-full border border-amber-300 bg-amber-100 px-3 py-1 text-xs font-bold tracking-wide text-amber-900 shadow-sm">TO-DO</span>
        <span class="inline-flex items-center rounded-full border border-blue-300 bg-blue-100 px-3 py-1 text-xs font-bold tracking-wide text-blue-900 shadow-sm">IN-PROGRESS</span>
        <span class="inline-flex items-center rounded-full border border-orange-300 bg-orange-100 px-3 py-1 text-xs font-bold tracking-wide text-orange-900 shadow-sm">FOR REVIEW</span>
        <span class="inline-flex items-center rounded-full border border-emerald-300 bg-emerald-100 px-3 py-1 text-xs font-bold tracking-wide text-emerald-900 shadow-sm">DONE</span>
    </div>

    <div class="relative inline-flex overflow-hidden rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-1 shadow-md dark:shadow-none">
        <a
            href="{{ route('tasks.list', array_merge(request()->except(['tab', 'done_page', 'page']), ['tab' => 'active'])) }}"
            class="rounded-lg px-4 py-2 text-sm font-semibold {{ $currentTab === 'active' ? 'bg-teal-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-white' }}"
        >
            Active Tasks
        </a>
        <a
            href="{{ route('tasks.list', array_merge(request()->except(['tab', 'page']), ['tab' => 'done'])) }}"
            class="rounded-lg px-4 py-2 text-sm font-semibold {{ $currentTab === 'done' ? 'bg-emerald-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-white' }}"
        >
            Checklist / Completed
        </a>
    </div>

    <form method="GET" action="{{ route('tasks.list') }}" class="relative overflow-hidden rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-md dark:shadow-none">
        <input type="hidden" name="tab" value="{{ request('tab', 'active') }}">
        <div class="grid grid-cols-1 gap-4 {{ $currentTab === 'done' ? 'md:grid-cols-6' : 'md:grid-cols-8' }}">
            <div>
                <label for="search" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Search</label>
                <input
                    id="search"
                    type="text"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    placeholder="Title, description, or company"
                    class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white placeholder:text-slate-500 dark:placeholder-slate-400 ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40"
                >
            </div>

            <div>
                <label for="company" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Company/Client</label>
                <input
                    id="company"
                    type="text"
                    name="company"
                    value="{{ $filters['company'] ?? '' }}"
                    placeholder="Filter by company"
                    class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white placeholder:text-slate-500 dark:placeholder-slate-400 ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40"
                >
            </div>

            <div>
                <label for="status" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                <select id="status" name="status" class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40">
                    <option value="">All statuses</option>
                    <option value="blocked" @selected(($filters['status'] ?? '') === 'blocked')>BACKLOG</option>
                    <option value="todo" @selected(($filters['status'] ?? '') === 'todo')>TO-DO</option>
                    <option value="in_progress" @selected(($filters['status'] ?? '') === 'in_progress')>IN-PROGRESS</option>
                    <option value="for_review" @selected(($filters['status'] ?? '') === 'for_review')>FOR REVIEW</option>
                    <option value="done" @selected(($filters['status'] ?? '') === 'done')>DONE</option>
                    <option value="cancelled" @selected(($filters['status'] ?? '') === 'cancelled')>Cancelled</option>
                </select>
            </div>

            @if ($currentTab === 'active')
                <div>
                    <label for="priority" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Priority</label>
                    <select id="priority" name="priority" class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40">
                        <option value="">All priorities</option>
                        <option value="low" @selected(($filters['priority'] ?? '') === 'low')>Low</option>
                        <option value="medium" @selected(($filters['priority'] ?? '') === 'medium')>Medium</option>
                        <option value="high" @selected(($filters['priority'] ?? '') === 'high')>High</option>
                        <option value="urgent" @selected(($filters['priority'] ?? '') === 'urgent')>Urgent</option>
                    </select>
                </div>
            @endif

            <div>
                <label for="assignee" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Assignee</label>
                <select id="assignee" name="assignee" class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40">
                    <option value="">All assignees</option>
                    @foreach ($assignees as $assignee)
                        <option value="{{ $assignee->id }}" @selected((string) ($filters['assignee'] ?? '') === (string) $assignee->id)>
                            {{ $assignee->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date_received" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Date Received</label>
                <input
                    id="date_received"
                    type="date"
                    name="date_received"
                    value="{{ $filters['date_received'] ?? '' }}"
                    class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40"
                >
            </div>

            @if ($currentTab === 'active')
                <div>
                    <label for="blocked_by_task_id" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Blocked By</label>
                    <select id="blocked_by_task_id" name="blocked_by_task_id" class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40">
                        <option value="">All dependencies</option>
                        @foreach ($dependencyOptions as $dependencyOption)
                            <option value="{{ $dependencyOption->id }}" @selected((string) ($filters['blocked_by_task_id'] ?? '') === (string) $dependencyOption->id)>
                                {{ $dependencyOption->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="flex items-end gap-2">
                <button type="submit" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">Apply</button>
                <a href="{{ route('tasks.list') }}" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600">Clear</a>
            </div>
        </div>
    </form>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($currentTab === 'active')
        @if ($tasks->isEmpty())
            <div class="rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-6 py-8 text-center text-slate-500 dark:text-slate-400 shadow-md dark:shadow-none">
                No tasks found.
            </div>
        @else
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Active Project Tasks</h2>
                <span class="text-xs text-slate-400">Showing non-done tasks</span>
            </div>
            <div class="overflow-x-auto rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-md dark:shadow-none">
                <table class="tasks-table min-w-[1700px] divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="sticky top-0 z-10 bg-white dark:bg-slate-800 shadow-sm border-b-2 border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="w-20 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Task No</th>
                        <th class="w-24 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Priority</th>
                        <th class="w-44 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Project Owner</th>
                        <th class="w-40 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Person-in-Charge</th>
                        <th class="w-36 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Task Process</th>
                        <th class="w-36 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Specific Process</th>
                        <th class="w-36 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Blocked By</th>
                        <th class="w-36 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Company Client</th>
                        <th class="w-28 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Project</th>
                        <th class="w-44 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Deliverables</th>
                        <th class="w-44 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Document Link</th>
                        <th class="w-52 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Remarks / Latest Comment</th>
                        <th class="w-28 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Status</th>
                        <th class="w-24 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Your Role</th>
                        <th class="w-32 whitespace-nowrap px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Date Received</th>
                        <th class="w-32 whitespace-nowrap px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Date Started</th>
                        <th class="w-32 whitespace-nowrap px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Date Finish</th>
                        <th class="w-36 whitespace-nowrap px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Target Deadline</th>
                        <th class="w-32 whitespace-nowrap px-3 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @foreach ($tasks as $index => $task)
                        @php
                            $isDelayed = $task->isOverdue();
                            $rowAccentClass = match($task->priority) {
                                'urgent', 'high' => 'border-l-4 border-red-500',
                                'medium' => 'border-l-4 border-yellow-400',
                                default => 'border-l-4 border-emerald-400',
                            };
                            $priorityBadgeClass = match($task->priority) {
                                'urgent' => 'priority-pin pin-urgent',
                                'high' => 'priority-pin pin-high',
                                'medium' => 'priority-pin pin-medium',
                                default => 'priority-pin pin-low',
                            };
                            $workflowStatusLabel = $isDelayed
                                ? 'DELAYED'
                                : match($task->status) {
                                    'blocked' => 'BACKLOG',
                                    'in_progress' => 'IN-PROGRESS',
                                    'for_review' => 'FOR REVIEW',
                                    'done' => 'DONE',
                                    default => 'TO-DO',
                                };
                            $statusBadgeClass = $isDelayed
                                ? 'border border-red-300 bg-red-100 text-red-900 dark:bg-red-900/30 dark:text-red-300 dark:border-red-700 shadow-sm'
                                : match($task->status) {
                                    'in_progress' => 'border border-blue-300 bg-blue-100 text-blue-900 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-700 shadow-sm',
                                    'for_review' => 'border border-orange-300 bg-orange-100 text-orange-900 dark:bg-orange-900/30 dark:text-orange-300 dark:border-orange-700 shadow-sm',
                                    'done' => 'border border-emerald-300 bg-emerald-100 text-emerald-900 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-700 shadow-sm',
                                    default => 'border border-amber-300 bg-amber-100 text-amber-900 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-700 shadow-sm',
                                };
                            $priorityLabel = strtoupper($task->priority ?? 'low');
                            $projectOwner = $task->project?->project_owner ?: 'Sales (Sales Project)';
                            $dateFinish = $task->status === 'done' ? $task->done_at : null;
                            $taskNumber = $task->task_no ?: sprintf('TSK-%05d', $task->id);
                            $overdueDays = $isDelayed && $task->due_date ? (int) $task->due_date->diffInDays(now()) : 0;
                        @endphp
                        <tr class="{{ $rowAccentClass }} {{ $isDelayed ? 'is-overdue-row' : '' }} border-b border-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-200">
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <a href="{{ route('tasks.show', $task) }}" class="font-medium text-blue-600 hover:underline">{{ $taskNumber }}</a>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <span class="{{ $priorityBadgeClass }}">
                                    @if(($task->priority ?? '') === 'urgent')
                                        <span class="pin-dot inline-block h-2 w-2 rounded-full bg-current animate-pulse"></span>
                                    @endif
                                    {{ $priorityLabel }}
                                </span>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $projectOwner }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->team_in_charge ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @if($task->task_process)
                                    <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold text-slate-700 dark:text-slate-200">{{ $task->task_process }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->specific_process ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @if($task->blockedByTask)
                                    <a href="{{ route('tasks.show', $task->blockedByTask) }}" class="text-blue-600 hover:underline">{{ $task->blockedByTask->title }}</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->company ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->project?->name ?? 'N/A' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->deliverables ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @if($task->document_link)
                                    <a href="{{ $task->document_link }}" target="_blank" class="text-blue-600 hover:underline">Open Link</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <p>{{ $task->remarks ?: '-' }}</p>
                                @if(($task->comments_count ?? 0) > 0 && $task->latestComment)
                                    <div class="mt-2 rounded border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 p-2">
                                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-100">Latest comment ({{ $task->comments_count }})</p>
                                        <p class="mt-1 line-clamp-2 text-xs text-slate-600 dark:text-slate-400">"{{ \Illuminate\Support\Str::limit($task->latestComment->body, 90) }}"</p>
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">{{ $task->latestComment->user?->name ?? 'Unknown' }} • {{ $task->latestComment->created_at?->diffForHumans() }}</p>
                                    </div>
                                @endif
                            </td>
                            <td class="py-5 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <span class="inline-flex items-center rounded-full border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold tracking-wide text-slate-800 dark:text-slate-200">
                                    {{ $task->specific_process ?: 'General' }}
                                </span>
                                <div class="mt-2">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide {{ $statusBadgeClass }}">
                                        {{ $workflowStatusLabel }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @php
                                    $roleLabel = $task->project?->member_role ?? 'member';
                                    $roleClass = match($roleLabel) {
                                        'admin' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-700',
                                        'lead' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-700',
                                        'member' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-700',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-900/30 dark:text-gray-300 dark:border-gray-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $roleClass }}">{{ ucwords(str_replace('_', ' ', $roleLabel)) }}</span>
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->date_received ? \Carbon\Carbon::parse($task->date_received)->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->date_started ? $task->date_started->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $dateFinish ? $dateFinish->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium leading-relaxed {{ $isDelayed ? 'font-semibold text-amber-700 dark:text-amber-400' : 'text-slate-800 dark:text-slate-100' }}">
                                {{ $task->due_date ? $task->due_date->format('m-d-Y') : '-' }}
                                @if($isDelayed)
                                    <span class="ml-2 inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-900/30 px-2 py-0.5 text-xs font-semibold text-amber-800 dark:text-amber-300">Overdue {{ $overdueDays }} day(s)</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-right text-xs">
                                <a href="{{ route('tasks.show', $task) }}" class="mr-2 rounded border border-blue-200 dark:border-blue-700 px-3 py-1 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30">Open</a>
                                @if(auth()->user()?->isAdmin())
                                    <a href="{{ route('tasks.edit', $task) }}" class="mr-2 rounded border border-yellow-200 dark:border-yellow-700 px-3 py-1 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30">Edit</a>
                                @else
                                    @can('update-task', $task)
                                        <a href="{{ route('tasks.edit', $task) }}" class="mr-2 rounded border border-yellow-200 dark:border-yellow-700 px-3 py-1 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30">Edit</a>
                                    @endcan
                                @endif
                                @can('delete-task', $task)
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded border border-red-200 dark:border-red-700 px-3 py-1 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30" onclick="return confirm('Delete this task?')">Delete</button>
                                    </form>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

            @if(method_exists($tasks, 'hasPages') && $tasks->hasPages())
                <div class="mt-4">
                    {{ $tasks->links() }}
                </div>
            @endif
        @endif
    @endif

    @if ($currentTab === 'done')
        <div id="done-tasks" class="mt-2 mb-3 flex items-center justify-between">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Checklist / Completed Tasks</h2>
            <span class="text-xs text-slate-400">{{ $doneTasksCount ?? 0 }} completed task(s)</span>
        </div>

        @if (($doneTasksCount ?? 0) === 0)
            <div class="rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-6 py-8 text-center text-slate-500 dark:text-slate-400 shadow-md dark:shadow-none">
                No done tasks yet.
            </div>
        @else
            <div class="overflow-x-auto rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-md dark:shadow-none">
                <table class="tasks-table min-w-[1450px] divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="sticky top-0 z-10 bg-white dark:bg-slate-800 shadow-sm border-b-2 border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="w-20 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Task No</th>
                        <th class="w-44 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Project Owner</th>
                        <th class="w-40 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Person-in-Charge</th>
                        <th class="w-36 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Task Process</th>
                        <th class="w-36 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Specific Process</th>
                        <th class="w-36 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Company Client</th>
                        <th class="w-28 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Project</th>
                        <th class="w-44 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Deliverables</th>
                        <th class="w-44 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Document Link</th>
                        <th class="w-52 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Remarks / Latest Comment</th>
                        <th class="w-28 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Status</th>
                        <th class="w-24 px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Your Role</th>
                        <th class="w-32 whitespace-nowrap px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Date Received</th>
                        <th class="w-32 whitespace-nowrap px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Date Started</th>
                        <th class="w-32 whitespace-nowrap px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Date Finish</th>
                        <th class="w-36 whitespace-nowrap px-3 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Target Deadline</th>
                        <th class="w-32 whitespace-nowrap px-3 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    @foreach ($doneTasks as $index => $task)
                        @php
                            $projectOwner = $task->project?->project_owner ?: 'Sales (Sales Project)';
                            $dateFinish = $task->done_at;
                            $taskNumber = $task->task_no ?: sprintf('TSK-%05d', $task->id);
                            $statusBadgeClass = 'border border-emerald-300 bg-emerald-100 text-emerald-900 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-700 shadow-sm';
                        @endphp
                        <tr class="border-l-4 border-emerald-500 border-b border-slate-200 dark:border-slate-700 bg-emerald-50/30 dark:bg-emerald-950/30 hover:bg-slate-50 dark:hover:bg-slate-700 dark:hover:bg-slate-700 transition-colors duration-200">
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <a href="{{ route('tasks.show', $task) }}" class="font-medium text-blue-600 hover:underline">{{ $taskNumber }}</a>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $projectOwner }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->team_in_charge ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @if($task->task_process)
                                    <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold text-slate-700 dark:text-slate-200">{{ $task->task_process }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->specific_process ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->company ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->project?->name ?? 'N/A' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->deliverables ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @if($task->document_link)
                                    <a href="{{ $task->document_link }}" target="_blank" class="text-blue-600 hover:underline">Open Link</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <p>{{ $task->remarks ?: '-' }}</p>
                                @if(($task->comments_count ?? 0) > 0 && $task->latestComment)
                                    <div class="mt-2 rounded border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 p-2">
                                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-100">Latest comment ({{ $task->comments_count }})</p>
                                        <p class="mt-1 line-clamp-2 text-xs text-slate-600 dark:text-slate-400">"{{ \Illuminate\Support\Str::limit($task->latestComment->body, 90) }}"</p>
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">{{ $task->latestComment->user?->name ?? 'Unknown' }} • {{ $task->latestComment->created_at?->diffForHumans() }}</p>
                                    </div>
                                @endif
                            </td>
                            <td class="py-5 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <span class="inline-flex items-center rounded-full border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold tracking-wide text-slate-800 dark:text-slate-200">
                                    {{ $task->specific_process ?: 'General' }}
                                </span>
                                <div class="mt-2">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide {{ $statusBadgeClass }}">
                                        DONE
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-3 text-[11px] font-medium text-slate-700 dark:text-slate-200 leading-relaxed">
                                @php
                                    $roleLabel = $task->project?->member_role ?? 'member';
                                    $roleClass = match($roleLabel) {
                                        'admin' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-700',
                                        'lead' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-700',
                                        'member' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-700',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-900/30 dark:text-gray-300 dark:border-gray-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $roleClass }}">{{ ucwords(str_replace('_', ' ', $roleLabel)) }}</span>
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->date_received ? \Carbon\Carbon::parse($task->date_received)->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->date_started ? $task->date_started->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $dateFinish ? $dateFinish->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->due_date ? $task->due_date->format('m-d-Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-right text-xs">
                                <a href="{{ route('tasks.show', $task) }}" class="mr-2 rounded border border-blue-200 dark:border-blue-700 px-3 py-1 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30">Open</a>
                                <span class="text-gray-300">-</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

            @if(method_exists($doneTasks, 'hasPages') && $doneTasks->hasPages())
                <div class="mt-4">
                    {{ $doneTasks->links() }}
                </div>
            @endif
        @endif
    @endif
</div>
@endsection
