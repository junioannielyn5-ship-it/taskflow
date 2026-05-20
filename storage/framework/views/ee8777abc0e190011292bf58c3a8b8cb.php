

<?php $__env->startSection('content'); ?>
<style>
    .tasks-page {
        color: #1e293b;
    }
    html.dark .tasks-page {
        color: #e2e8f0;
    }
    .tasks-page form label {
        color: #475569 !important;
    }
    html.dark .tasks-page form label {
        color: #cbd5e1 !important;
    }
    .tasks-page form input,
    .tasks-page form select {
        background: #ffffff !important;
        border-color: #cbd5e1 !important;
        color: #1e293b !important;
    }
    html.dark .tasks-page form input,
    html.dark .tasks-page form select {
        background: #1e293b !important;
        border-color: #475569 !important;
        color: #e2e8f0 !important;
    }
    .tasks-page form input::placeholder {
        color: #94a3b8 !important;
    }
    .tasks-page form option {
        background: #ffffff;
        color: #1e293b;
    }
    html.dark .tasks-page form option {
        background: #1e293b;
        color: #e2e8f0;
    }
    .tasks-table th,
    .tasks-table td {
        border-right: 1px solid #e2e8f0;
    }
    html.dark .tasks-table th,
    html.dark .tasks-table td {
        border-right: 1px solid rgba(148, 163, 184, 0.22);
    }
    .tasks-table th:last-child,
    .tasks-table td:last-child {
        border-right: none;
        position: sticky;
        right: 0;
        z-index: 5;
        box-shadow: -3px 0 8px rgba(0,0,0,0.08);
        background: #ffffff;
    }
    html.dark .tasks-table th:last-child,
    html.dark .tasks-table td:last-child {
        box-shadow: -3px 0 8px rgba(2, 6, 23, 0.35);
        background: #1e293b;
    }
    .tasks-table thead th {
        background: #f8fafc !important;
        color: #64748b !important;
    }
    html.dark .tasks-table thead th {
        background: #1e293b !important;
        color: #94a3b8 !important;
    }
    .tasks-table thead th:last-child {
        background: #f8fafc;
        z-index: 15;
    }
    html.dark .tasks-table thead th:last-child {
        background: #1e293b;
    }
    .tasks-table tbody tr td:last-child {
        background: #ffffff;
    }
    html.dark .tasks-table tbody tr td:last-child {
        background: #1e293b;
    }
    .tasks-table tbody tr:hover td:last-child {
        background: #f1f5f9;
    }
    html.dark .tasks-table tbody tr:hover td:last-child {
        background: rgba(30, 41, 59, 0.98);
    }
    .tasks-table tbody tr.is-overdue-row td:last-child {
        background: #ffe4e6;
    }
    html.dark .tasks-table tbody tr.is-overdue-row td:last-child {
        background: rgba(30, 41, 59, 0.98);
    }
    .tasks-table tbody tr.bg-emerald-50\/30 td:last-child {
        background: #f0fdf4;
    }
    html.dark .tasks-table tbody tr.bg-emerald-50\/30 td:last-child {
        background: rgba(5, 46, 22, 0.7);
    }
    .tasks-page .tasks-table tbody tr {
        background-color: #ffffff !important;
    }
    html.dark .tasks-page .tasks-table tbody tr {
        background-color: #1e293b !important;
    }
    .tasks-table tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }
    html.dark .tasks-table tbody tr:nth-child(even) {
        background-color: #172033;
    }
    .tasks-page .tasks-table tbody tr:hover {
        background-color: #f1f5f9 !important;
    }
    html.dark .tasks-page .tasks-table tbody tr:hover {
        background-color: rgba(30, 41, 59, 0.98) !important;
    }
    .tasks-page .tasks-table tbody tr.is-overdue-row {
        background-color: #ffe4e6 !important;
        box-shadow: inset 4px 0 0 #ef4444;
    }
    html.dark .tasks-page .tasks-table tbody tr.is-overdue-row {
        background-color: rgba(30, 41, 59, 0.98) !important;
    }
    .tasks-page .tasks-table tbody tr.bg-emerald-50\/30 {
        background-color: #f0fdf4 !important;
    }
    html.dark .tasks-page .tasks-table tbody tr.bg-emerald-50\/30 {
        background-color: rgba(5, 46, 22, 0.35) !important;
    }
    .tasks-page .tasks-table td,
    .tasks-page .tasks-table td p {
        color: #334155 !important;
    }
    html.dark .tasks-page .tasks-table td,
    html.dark .tasks-page .tasks-table td p {
        color: #e2e8f0 !important;
    }
    .tasks-page .tasks-table td a {
        color: #2563eb !important;
    }
    html.dark .tasks-page .tasks-table td a {
        color: #93c5fd !important;
    }
    .tasks-page .tasks-table td .text-slate-500,
    .tasks-page .tasks-table td .text-slate-600,
    .tasks-page .tasks-table td .text-slate-700,
    .tasks-page .tasks-table td .text-slate-800 {
        color: #475569 !important;
    }
    html.dark .tasks-page .tasks-table td .text-slate-500,
    html.dark .tasks-page .tasks-table td .text-slate-600,
    html.dark .tasks-page .tasks-table td .text-slate-700,
    html.dark .tasks-page .tasks-table td .text-slate-800 {
        color: #cbd5e1 !important;
    }
    .tasks-page .tasks-table td .bg-slate-50,
    .tasks-page .tasks-table td .bg-slate-100 {
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
    }
    html.dark .tasks-page .tasks-table td .bg-slate-50,
    html.dark .tasks-page .tasks-table td .bg-slate-100 {
        background-color: #1e293b !important;
        border-color: #334155 !important;
    }
    .tasks-page .tasks-table td .hover\:bg-blue-50:hover {
        background-color: #eff6ff !important;
    }
    html.dark .tasks-page .tasks-table td .hover\:bg-blue-50:hover {
        background-color: #1e3a8a !important;
    }
    .tasks-page .tasks-table td .hover\:bg-yellow-50:hover {
        background-color: #fefce8 !important;
    }
    html.dark .tasks-page .tasks-table td .hover\:bg-yellow-50:hover {
        background-color: #78350f !important;
    }
    .tasks-page .tasks-table td .hover\:bg-red-50:hover {
        background-color: #fff1f2 !important;
    }
    html.dark .tasks-page .tasks-table td .hover\:bg-red-50:hover {
        background-color: #7f1d1d !important;
    }
    /* Softer pastel for priority badges */
    .priority-urgent { background: #fee2e2; color: #b91c1c; }
    .priority-high { background: #ffedd5; color: #c2410c; }
    .priority-medium { background: #fef9c3; color: #a16207; }
    .priority-low { background: #dcfce7; color: #166534; }

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
    /* Pill badge for status indicators */
    .pill-badge {
        display: inline-block;
        border-radius: 9999px;
        padding: 0.25em 0.9em;
        font-size: 0.85em;
        font-weight: 600;
        border: 1.5px solid #cbd5e1;
        background: rgba(255,255,255,0.08);
        color: #334155;
    }
    .dark .pill-badge {
        border-color: #475569;
        background: rgba(30,41,59,0.7);
        color: #e2e8f0;
    }
    /* Compact filter group */
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
    /* Icon buttons for actions */
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
    /* Narrow Task No column, wider text columns */
    .tasks-table th.w-20, .tasks-table td.w-20 { width: 80px !important; min-width: 60px; }
    .tasks-table th.w-40, .tasks-table td.w-40 { width: 180px !important; min-width: 120px; }
    .tasks-table th.w-44, .tasks-table td.w-44 { width: 220px !important; min-width: 140px; }
    .tasks-table th.w-48, .tasks-table td.w-48 { width: 260px !important; min-width: 160px; }
    .tasks-table th.w-52, .tasks-table td.w-52 { width: 280px !important; min-width: 180px; }
    .tasks-table th.w-36, .tasks-table td.w-36 { width: 140px !important; min-width: 100px; }
    .tasks-table th.w-28, .tasks-table td.w-28 { width: 110px !important; min-width: 80px; }
    .tasks-table th.w-24, .tasks-table td.w-24 { width: 90px !important; min-width: 70px; }
    .tasks-table th.w-32, .tasks-table td.w-32 { width: 120px !important; min-width: 90px; }
    .tasks-table th.w-52, .tasks-table td.w-52 { width: 280px !important; min-width: 180px; }
    .tasks-table th.w-36, .tasks-table td.w-36 { width: 140px !important; min-width: 100px; }
    .tasks-table th.w-28, .tasks-table td.w-28 { width: 110px !important; min-width: 80px; }
    .tasks-table th.w-24, .tasks-table td.w-24 { width: 90px !important; min-width: 70px; }
    .tasks-table th.w-32, .tasks-table td.w-32 { width: 120px !important; min-width: 90px; }
    .tasks-table th.w-52, .tasks-table td.w-52 { width: 280px !important; min-width: 180px; }
    .tasks-table th.w-36, .tasks-table td.w-36 { width: 140px !important; min-width: 100px; }
    .tasks-table th.w-28, .tasks-table td.w-28 { width: 110px !important; min-width: 80px; }
    .tasks-table th.w-24, .tasks-table td.w-24 { width: 90px !important; min-width: 70px; }
    .tasks-table th.w-32, .tasks-table td.w-32 { width: 120px !important; min-width: 90px; }
</style>
<div class="relative space-y-6 tasks-page">
    <div class="pointer-events-none absolute right-0 top-0 h-64 w-64 translate-x-1/3 -translate-y-1/3 rounded-full bg-blue-100/40 blur-3xl dark:hidden"></div>
    <div class="pointer-events-none absolute bottom-0 left-20 h-52 w-52 rounded-full bg-slate-200/30 blur-3xl dark:hidden"></div>
    <?php
        $currentTab = request('tab') === 'done' ? 'done' : 'active';
    ?>

    <div class="relative inline-flex w-fit overflow-hidden rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-5 py-2.5 shadow-md dark:shadow-none" style="border-left: 4px solid #2563eb;">
        <p class="text-2xl font-bold uppercase tracking-wide text-slate-800 dark:text-slate-100 md:text-3xl">Task Manager</p>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
        <!-- Active Projects -->
          <a href="<?php echo e(route('tasks.list')); ?>"
              class="block rounded-2xl border border-slate-300 dark:border-slate-700 border-l-4 border-l-blue-400 bg-white dark:bg-slate-800 shadow-md dark:shadow-none px-4 py-3 transition hover:-translate-y-0.5 hover:shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-wide text-blue-600 dark:text-blue-400">Active Projects</p>
            <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-slate-100"><?php echo e($activeProjectsCount ?? 0); ?></p>
        </a>
        <!-- My Tasks -->
          <a href="<?php echo e(route('tasks.list', ['assignee' => auth()->id()])); ?>"
              class="block rounded-2xl border border-slate-300 dark:border-slate-700 border-l-4 border-l-purple-400 bg-white dark:bg-slate-800 shadow-md dark:shadow-none px-4 py-3 transition hover:-translate-y-0.5 hover:shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-wide text-purple-600 dark:text-purple-400">My Tasks</p>
            <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-slate-100"><?php echo e($myTasksCount ?? 0); ?></p>
        </a>
        <!-- Pending Review -->
          <a href="<?php echo e(route('tasks.list', ['status' => 'for_review'])); ?>"
              class="block rounded-2xl border border-slate-300 dark:border-slate-700 border-l-4 border-l-yellow-400 bg-white dark:bg-slate-800 shadow-md dark:shadow-none px-4 py-3 transition hover:-translate-y-0.5 hover:shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-wide text-yellow-600 dark:text-yellow-400">Pending Review</p>
            <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-slate-100"><?php echo e($pendingReviewCount ?? 0); ?></p>
        </a>
        <!-- Overdue -->
          <a href="<?php echo e(route('tasks.list', ['overdue' => 1])); ?>"
              class="block rounded-2xl border border-slate-300 dark:border-slate-700 border-l-4 border-l-red-500 bg-white dark:bg-slate-800 shadow-md dark:shadow-none px-4 py-3 transition hover:-translate-y-0.5 hover:shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-wide text-red-600 dark:text-red-400">Overdue</p>
            <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-slate-100"><?php echo e($overdueCount ?? 0); ?></p>
        </a>
        <!-- Done -->
          <a href="<?php echo e(route('tasks.list', ['tab' => 'done'])); ?>"
              class="block rounded-2xl border border-slate-300 dark:border-slate-700 border-l-4 border-l-emerald-400 bg-white dark:bg-slate-800 shadow-md dark:shadow-none px-4 py-3 transition hover:-translate-y-0.5 hover:shadow-lg">
            <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 dark:text-emerald-400">Done</p>
            <p class="mt-1 text-2xl font-bold text-slate-800 dark:text-slate-100"><?php echo e($doneTasksCount ?? 0); ?></p>
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
            href="<?php echo e(route('tasks.list', array_merge(request()->except(['tab', 'done_page', 'page']), ['tab' => 'active']))); ?>"
            class="rounded-lg px-4 py-2 text-sm font-semibold <?php echo e($currentTab === 'active' ? 'bg-teal-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-white'); ?>"
        >
            Active Tasks
        </a>
        <a
            href="<?php echo e(route('tasks.list', array_merge(request()->except(['tab', 'page']), ['tab' => 'done']))); ?>"
            class="rounded-lg px-4 py-2 text-sm font-semibold <?php echo e($currentTab === 'done' ? 'bg-emerald-600 text-white' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-white'); ?>"
        >
            Checklist / Completed
        </a>
    </div>

    <form method="GET" action="<?php echo e(route('tasks.list')); ?>" class="relative overflow-hidden rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-md dark:shadow-none">
        <input type="hidden" name="tab" value="<?php echo e(request('tab', 'active')); ?>">
        <div class="grid grid-cols-1 gap-4 <?php echo e($currentTab === 'done' ? 'md:grid-cols-6' : 'md:grid-cols-8'); ?>">
            <div>
                <label for="search" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Search</label>
                <input
                    id="search"
                    type="text"
                    name="search"
                    value="<?php echo e($filters['search'] ?? ''); ?>"
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
                    value="<?php echo e($filters['company'] ?? ''); ?>"
                    placeholder="Filter by company"
                    class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white placeholder:text-slate-500 dark:placeholder-slate-400 ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40"
                >
            </div>

            <div>
                <label for="status" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                <select id="status" name="status" class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40">
                    <option value="">All statuses</option>
                    <option value="blocked" <?php if(($filters['status'] ?? '') === 'blocked'): echo 'selected'; endif; ?>>BACKLOG</option>
                    <option value="todo" <?php if(($filters['status'] ?? '') === 'todo'): echo 'selected'; endif; ?>>TO-DO</option>
                    <option value="in_progress" <?php if(($filters['status'] ?? '') === 'in_progress'): echo 'selected'; endif; ?>>IN-PROGRESS</option>
                    <option value="for_review" <?php if(($filters['status'] ?? '') === 'for_review'): echo 'selected'; endif; ?>>FOR REVIEW</option>
                    <option value="done" <?php if(($filters['status'] ?? '') === 'done'): echo 'selected'; endif; ?>>DONE</option>
                    <option value="cancelled" <?php if(($filters['status'] ?? '') === 'cancelled'): echo 'selected'; endif; ?>>Cancelled</option>
                </select>
            </div>

            <?php if($currentTab === 'active'): ?>
                <div>
                    <label for="priority" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Priority</label>
                    <select id="priority" name="priority" class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40">
                        <option value="">All priorities</option>
                        <option value="low" <?php if(($filters['priority'] ?? '') === 'low'): echo 'selected'; endif; ?>>Low</option>
                        <option value="medium" <?php if(($filters['priority'] ?? '') === 'medium'): echo 'selected'; endif; ?>>Medium</option>
                        <option value="high" <?php if(($filters['priority'] ?? '') === 'high'): echo 'selected'; endif; ?>>High</option>
                        <option value="urgent" <?php if(($filters['priority'] ?? '') === 'urgent'): echo 'selected'; endif; ?>>Urgent</option>
                    </select>
                </div>
            <?php endif; ?>

            <div>
                <label for="assignee" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Assignee</label>
                <select id="assignee" name="assignee" class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40">
                    <option value="">All assignees</option>
                    <?php $__currentLoopData = $assignees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($assignee->id); ?>" <?php if((string) ($filters['assignee'] ?? '') === (string) $assignee->id): echo 'selected'; endif; ?>>
                            <?php echo e($assignee->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label for="date_received" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Date Received</label>
                <input
                    id="date_received"
                    type="date"
                    name="date_received"
                    value="<?php echo e($filters['date_received'] ?? ''); ?>"
                    class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40"
                >
            </div>

            <?php if($currentTab === 'active'): ?>
                <div>
                    <label for="blocked_by_task_id" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Blocked By</label>
                    <select id="blocked_by_task_id" name="blocked_by_task_id" class="w-full rounded border-2 border-cyan-300 dark:border-cyan-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white ring-1 ring-cyan-100 dark:ring-cyan-900/30 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-200 dark:focus:border-cyan-400 dark:focus:ring-cyan-900/40">
                        <option value="">All dependencies</option>
                        <?php $__currentLoopData = $dependencyOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dependencyOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dependencyOption->id); ?>" <?php if((string) ($filters['blocked_by_task_id'] ?? '') === (string) $dependencyOption->id): echo 'selected'; endif; ?>>
                                <?php echo e($dependencyOption->title); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            <?php endif; ?>

            <div class="flex items-end gap-2">
                <button type="submit" class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">Apply</button>
                <a href="<?php echo e(route('tasks.list')); ?>" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600">Clear</a>
            </div>
        </div>
    </form>

    <?php if(session('success')): ?>
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($currentTab === 'active'): ?>
        <?php if($tasks->isEmpty()): ?>
            <div class="rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-6 py-8 text-center text-slate-500 dark:text-slate-400 shadow-md dark:shadow-none">
                No tasks found.
            </div>
        <?php else: ?>
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
                        <th class="w-32 whitespace-nowrap px-3 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
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
                        ?>
                        <tr class="<?php echo e($rowAccentClass); ?> <?php echo e($isDelayed ? 'is-overdue-row' : ''); ?> border-b border-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors duration-200">
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <a href="<?php echo e(route('tasks.show', $task)); ?>" class="font-medium text-blue-600 hover:underline"><?php echo e($taskNumber); ?></a>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <span class="<?php echo e($priorityBadgeClass); ?>">
                                    <?php if(($task->priority ?? '') === 'urgent'): ?>
                                        <span class="pin-dot inline-block h-2 w-2 rounded-full bg-current animate-pulse"></span>
                                    <?php endif; ?>
                                    <?php echo e($priorityLabel); ?>

                                </span>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($projectOwner); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->team_in_charge ?: '-'); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <?php if($task->task_process): ?>
                                    <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold text-slate-700 dark:text-slate-200"><?php echo e($task->task_process); ?></span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->specific_process ?: '-'); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <?php if($task->blockedByTask): ?>
                                    <a href="<?php echo e(route('tasks.show', $task->blockedByTask)); ?>" class="text-blue-600 hover:underline"><?php echo e($task->blockedByTask->title); ?></a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->company ?: '-'); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->project?->name ?? 'N/A'); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->deliverables ?: '-'); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <?php if($task->document_link): ?>
                                    <a href="<?php echo e($task->document_link); ?>" target="_blank" class="text-blue-600 hover:underline">Open Link</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <p><?php echo e($task->remarks ?: '-'); ?></p>
                                <?php if(($task->comments_count ?? 0) > 0 && $task->latestComment): ?>
                                    <div class="mt-2 rounded border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 p-2">
                                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-100">Latest comment (<?php echo e($task->comments_count); ?>)</p>
                                        <p class="mt-1 line-clamp-2 text-xs text-slate-600 dark:text-slate-400">"<?php echo e(\Illuminate\Support\Str::limit($task->latestComment->body, 90)); ?>"</p>
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-300"><?php echo e($task->latestComment->user?->name ?? 'Unknown'); ?> • <?php echo e($task->latestComment->created_at?->diffForHumans()); ?></p>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-5 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <span class="inline-flex items-center rounded-full border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold tracking-wide text-slate-800 dark:text-slate-200">
                                    <?php echo e($task->specific_process ?: 'General'); ?>

                                </span>
                                <div class="mt-2">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide <?php echo e($statusBadgeClass); ?>">
                                        <?php echo e($workflowStatusLabel); ?>

                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <?php
                                    $roleLabel = $task->project?->member_role ?? 'member';
                                    $roleClass = match($roleLabel) {
                                        'admin' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-700',
                                        'lead' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-700',
                                        'member' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-700',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-900/30 dark:text-gray-300 dark:border-gray-700',
                                    };
                                ?>
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($roleClass); ?>"><?php echo e(ucwords(str_replace('_', ' ', $roleLabel))); ?></span>
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->date_received ? \Carbon\Carbon::parse($task->date_received)->format('M d, Y') : '-'); ?></td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->date_started ? $task->date_started->format('M d, Y') : '-'); ?></td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($dateFinish ? $dateFinish->format('M d, Y') : '-'); ?></td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium leading-relaxed <?php echo e($isDelayed ? 'font-semibold text-amber-700 dark:text-amber-400' : 'text-slate-800 dark:text-slate-100'); ?>">
                                <?php echo e($task->due_date ? $task->due_date->format('m-d-Y') : '-'); ?>

                                <?php if($isDelayed): ?>
                                    <span class="ml-2 inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-900/30 px-2 py-0.5 text-xs font-semibold text-amber-800 dark:text-amber-300">Overdue <?php echo e($overdueDays); ?> day(s)</span>
                                <?php endif; ?>
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-right text-xs">
                                <a href="<?php echo e(route('tasks.show', $task)); ?>" class="mr-2 rounded border border-blue-200 dark:border-blue-700 px-3 py-1 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30">Open</a>
                                <?php if(auth()->user()?->isAdmin()): ?>
                                    <a href="<?php echo e(route('tasks.edit', $task)); ?>" class="mr-2 rounded border border-yellow-200 dark:border-yellow-700 px-3 py-1 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30">Edit</a>
                                <?php else: ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-task', $task)): ?>
                                        <a href="<?php echo e(route('tasks.edit', $task)); ?>" class="mr-2 rounded border border-yellow-200 dark:border-yellow-700 px-3 py-1 text-yellow-600 dark:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30">Edit</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-task', $task)): ?>
                                    <form method="POST" action="<?php echo e(route('tasks.destroy', $task)); ?>" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="rounded border border-red-200 dark:border-red-700 px-3 py-1 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30" onclick="return confirm('Delete this task?')">Delete</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-gray-300">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                </table>
            </div>

            <?php if(method_exists($tasks, 'hasPages') && $tasks->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($tasks->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($currentTab === 'done'): ?>
        <div id="done-tasks" class="mt-2 mb-3 flex items-center justify-between">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Checklist / Completed Tasks</h2>
            <span class="text-xs text-slate-400"><?php echo e($doneTasksCount ?? 0); ?> completed task(s)</span>
        </div>

        <?php if(($doneTasksCount ?? 0) === 0): ?>
            <div class="rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-6 py-8 text-center text-slate-500 dark:text-slate-400 shadow-md dark:shadow-none">
                No done tasks yet.
            </div>
        <?php else: ?>
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
                    <?php $__currentLoopData = $doneTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $projectOwner = $task->project?->project_owner ?: 'Sales (Sales Project)';
                            $dateFinish = $task->done_at;
                            $taskNumber = $task->task_no ?: sprintf('TSK-%05d', $task->id);
                            $statusBadgeClass = 'border border-emerald-300 bg-emerald-100 text-emerald-900 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-700 shadow-sm';
                        ?>
                        <tr class="border-l-4 border-emerald-500 border-b border-slate-200 dark:border-slate-700 bg-emerald-50/30 dark:bg-emerald-950/30 hover:bg-slate-50 dark:hover:bg-slate-700 dark:hover:bg-slate-700 transition-colors duration-200">
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <a href="<?php echo e(route('tasks.show', $task)); ?>" class="font-medium text-blue-600 hover:underline"><?php echo e($taskNumber); ?></a>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($projectOwner); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->team_in_charge ?: '-'); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <?php if($task->task_process): ?>
                                    <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold text-slate-700 dark:text-slate-200"><?php echo e($task->task_process); ?></span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->specific_process ?: '-'); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->company ?: '-'); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->project?->name ?? 'N/A'); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->deliverables ?: '-'); ?></td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <?php if($task->document_link): ?>
                                    <a href="<?php echo e($task->document_link); ?>" target="_blank" class="text-blue-600 hover:underline">Open Link</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <p><?php echo e($task->remarks ?: '-'); ?></p>
                                <?php if(($task->comments_count ?? 0) > 0 && $task->latestComment): ?>
                                    <div class="mt-2 rounded border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 p-2">
                                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-100">Latest comment (<?php echo e($task->comments_count); ?>)</p>
                                        <p class="mt-1 line-clamp-2 text-xs text-slate-600 dark:text-slate-400">"<?php echo e(\Illuminate\Support\Str::limit($task->latestComment->body, 90)); ?>"</p>
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-300"><?php echo e($task->latestComment->user?->name ?? 'Unknown'); ?> • <?php echo e($task->latestComment->created_at?->diffForHumans()); ?></p>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="py-5 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <span class="inline-flex items-center rounded-full border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold tracking-wide text-slate-800 dark:text-slate-200">
                                    <?php echo e($task->specific_process ?: 'General'); ?>

                                </span>
                                <div class="mt-2">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide <?php echo e($statusBadgeClass); ?>">
                                        DONE
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-3 text-[11px] font-medium text-slate-700 dark:text-slate-200 leading-relaxed">
                                <?php
                                    $roleLabel = $task->project?->member_role ?? 'member';
                                    $roleClass = match($roleLabel) {
                                        'admin' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-700',
                                        'lead' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-700',
                                        'member' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-700',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-900/30 dark:text-gray-300 dark:border-gray-700',
                                    };
                                ?>
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold <?php echo e($roleClass); ?>"><?php echo e(ucwords(str_replace('_', ' ', $roleLabel))); ?></span>
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->date_received ? \Carbon\Carbon::parse($task->date_received)->format('M d, Y') : '-'); ?></td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->date_started ? $task->date_started->format('M d, Y') : '-'); ?></td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($dateFinish ? $dateFinish->format('M d, Y') : '-'); ?></td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed"><?php echo e($task->due_date ? $task->due_date->format('m-d-Y') : '-'); ?></td>
                            <td class="whitespace-nowrap py-4 px-3 text-right text-xs">
                                <a href="<?php echo e(route('tasks.show', $task)); ?>" class="mr-2 rounded border border-blue-200 dark:border-blue-700 px-3 py-1 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30">Open</a>
                                <span class="text-gray-300">-</span>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                </table>
            </div>

            <?php if(method_exists($doneTasks, 'hasPages') && $doneTasks->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($doneTasks->links()); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/tasks/index.blade.php ENDPATH**/ ?>