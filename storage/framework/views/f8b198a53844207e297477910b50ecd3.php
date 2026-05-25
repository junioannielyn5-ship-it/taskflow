
<?php $__env->startSection('content'); ?>
<?php
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
?>
<?php
    $logoPath = \App\Modules\Admin\Models\SystemSetting::valueOf('branding_logo_path', null);
?>
<div class="mv-dashboard-shell">
<div class="relative w-full min-h-[calc(100vh-4rem)] bg-transparent text-slate-700 dark:text-slate-200 transition-colors duration-300">

<!-- Dashboard Navbar (Glass) -->
<div class="mv-navbar relative overflow-hidden h-14 border-b border-white/40 dark:border-white/10 bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl flex items-center justify-between px-5 sticky top-0 z-20 shadow-[0_4px_30px_rgba(0,0,0,0.05)]">
    <div class="pointer-events-none absolute right-0 top-0 h-28 w-28 translate-x-1/3 -translate-y-1/3 rounded-full bg-gradient-to-br from-[#00E5FF]/30 to-[#2962FF]/30 blur-3xl"></div>
    <div class="pointer-events-none absolute bottom-0 left-24 h-20 w-20 rounded-full bg-[#9D4EDD]/20 blur-2xl"></div>
    
    <div class="relative z-10 flex items-center gap-4 pl-6">
        <h1 class="text-2xl font-semibold text-slate-800 dark:text-slate-100">Dashboard</h1>
        <span class="hidden sm:inline text-xs text-slate-600 dark:text-slate-400"><?php echo e($greeting); ?>, <?php echo e(auth()->user()->name); ?></span>
    </div>
    
    <div class="relative z-10 flex items-center gap-3">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-project')): ?>
            <a href="<?php echo e(route('projects.create')); ?>" class="dashboard-create-btn rounded-xl bg-gradient-to-r from-[#2962FF] to-[#00E5FF] px-4 py-2 text-sm font-medium text-white shadow-[0_0_15px_rgba(0,229,255,0.28)] transition hover:-translate-y-0.5 hover:shadow-[0_0_24px_rgba(0,229,255,0.45)] backdrop-blur-sm">+ New Project</a>
        <?php endif; ?>
    </div>
</div>

            <div class="mv-content-inner w-full max-w-full mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 pb-6 pt-6 space-y-6 transition-all duration-300">

            <style>
                /* Glassmorphism Panel Utilities */
                .dashboard-glass-panel {
                    background: rgba(255, 255, 255, 0.60);
                    backdrop-filter: blur(16px) saturate(180%);
                    -webkit-backdrop-filter: blur(16px) saturate(180%);
                    border: 1px solid rgba(255, 255, 255, 0.45);
                    box-shadow: 0 4px 30px rgba(15, 23, 42, 0.05), inset 0 1px 0 rgba(255, 255, 255, 0.6);
                }
                html.dark .dashboard-glass-panel {
                    background: rgba(15, 23, 42, 0.65);
                    backdrop-filter: blur(16px) saturate(160%);
                    -webkit-backdrop-filter: blur(16px) saturate(160%);
                    border: 1px solid rgba(255, 255, 255, 0.08);
                    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.05);
                }
                .glass-override {
                    background: transparent !important;
                    border: none !important;
                }
            </style>
            
            <div class="relative mt-0 overflow-hidden rounded-3xl dashboard-glass-panel border-none p-5 md:p-6 shadow-md dark:shadow-none transition-all duration-300">

                
                <div class="relative z-10 flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">

                    
                    <div class="max-w-2xl space-y-3">
                        
                        
                        <h2 class="text-2xl font-black tracking-wide text-slate-800 dark:text-slate-100 md:text-3xl">
                            Welcome to <span class="text-blue-600">TaskFlow Workspace</span>
                        </h2>

                        
                        <p class="border-l-2 border-blue-500 pl-4 text-sm font-medium italic leading-relaxed text-slate-600 dark:text-slate-400">
                            "<?php echo e($systemAnnouncement); ?>"
                        </p>
                    </div>

                    
                    <div class="flex w-full shrink-0 flex-col gap-2 sm:flex-row md:w-auto">
                        <a href="<?php echo e(route('tasks.list')); ?>" class="flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow-md dark:shadow-none transition-all duration-300 hover:bg-blue-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Open My Tasks
                        </a>

                        <a href="<?php echo e(route('tasks.kanban')); ?>" class="dashboard-glass-panel flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold text-slate-800 dark:text-slate-200 transition-all duration-300 hover:bg-white/40 dark:hover:bg-white/10">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path></svg>
                            Kanban Board
                        </a>

                        <?php if(auth()->user()?->hasAnyRole(['admin', 'manager'])): ?>
                        <a href="<?php echo e(route('admin.config.index')); ?>#broadcast-email" class="dashboard-glass-panel flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold text-slate-800 dark:text-slate-200 transition-all duration-300 hover:bg-white/40 dark:hover:bg-white/10">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                            Email Broadcast
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="dashboard-stats grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 -mt-4">
                
                <a href="/projects" class="relative overflow-hidden rounded-3xl dashboard-glass-panel border-none p-6 group hover:shadow-lg transition-all duration-300">
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-blue-600 text-xs font-bold uppercase tracking-wider">Active Projects</p>
                            <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600 border border-blue-200 dark:border-blue-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-slate-800 dark:text-slate-100 text-4xl font-black"><?php echo e($totalProjects); ?></h3>
                        <div class="mt-4 h-1.5 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full w-[60%] bg-blue-500"></div>
                        </div>
                    </div>
                </a>

                <a href="<?php echo e(route('tasks.list')); ?>" class="relative overflow-hidden rounded-3xl dashboard-glass-panel border-none p-6 group hover:shadow-lg transition-all duration-300">
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-purple-600 text-xs font-bold uppercase tracking-wider">My Tasks</p>
                            <div class="p-2 bg-purple-50 dark:bg-purple-900/30 rounded-lg text-purple-600 border border-purple-200 dark:border-purple-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-slate-800 dark:text-slate-100 text-4xl font-black"><?php echo e($totalTasks); ?></h3>
                        <div class="mt-4 h-1.5 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full w-[80%] bg-purple-500"></div>
                        </div>
                    </div>
                </a>

                <a href="<?php echo e(route('tasks.list', ['status' => 'for_review'])); ?>" class="relative overflow-hidden rounded-3xl dashboard-glass-panel border-none p-6 group hover:shadow-lg transition-all duration-300">
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-orange-600 text-xs font-bold uppercase tracking-wider">Pending Review</p>
                            <div class="p-2 bg-orange-50 dark:bg-orange-900/30 rounded-lg text-orange-600 border border-orange-200 dark:border-orange-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-slate-800 dark:text-slate-100 text-4xl font-black"><?php echo e($pendingReview); ?></h3>
                        <div class="mt-4 h-1.5 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full w-[30%] bg-orange-500"></div>
                        </div>
                    </div>
                </a>

                <a href="<?php echo e(route('tasks.list')); ?>" class="relative overflow-hidden rounded-3xl dashboard-glass-panel border-none p-6 group hover:shadow-lg transition-all duration-300">
                    
                    <div class="relative z-10">
                        <div class="flex justify-between items-start mb-4">
                            <p class="text-rose-600 text-xs font-bold uppercase tracking-wider">Overdue</p>
                            <div class="p-2 bg-rose-50 dark:bg-rose-900/30 rounded-lg text-rose-600 border border-rose-200 dark:border-rose-800">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <h3 class="text-slate-800 dark:text-slate-100 text-4xl font-black"><?php echo e($overdue); ?></h3>
                        <div class="mt-4 h-1.5 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full w-[100%] bg-rose-500"></div>
                        </div>
                    </div>
                </a>

            </div>

            <div class="dashboard-analytics grid grid-cols-1 gap-4 xl:grid-cols-2">
                <div id="latest-notifications-card" class="relative overflow-hidden rounded-2xl dashboard-glass-panel border-none p-5 shadow-md dark:shadow-none transition-all scroll-mt-24" style="border-left: 4px solid #2563eb;">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-slate-100">Task Status Overview</h3>
                        <div class="flex items-center gap-2">
                            <a href="<?php echo e(route('dashboard.export.status-overview.csv')); ?>" class="rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-1.5 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600">CSV</a>
                            <a href="<?php echo e(route('dashboard.export.status-overview.pdf')); ?>" class="rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-1.5 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600">PDF</a>
                        </div>
                    </div>
                    <p class="mb-3 text-sm text-slate-600 dark:text-slate-400">Done: <span id="done-percentage" class="font-semibold text-emerald-600"><?php echo e($donePercentage); ?>%</span> · In Progress: <span id="in-progress-percentage" class="font-semibold text-blue-600"><?php echo e($inProgressPercentage); ?>%</span></p>
                    <div class="relative h-64 w-full">
                        <canvas id="taskStatusChart"></canvas>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-2xl dashboard-glass-panel border-none p-5 shadow-md dark:shadow-none transition-all" style="border-left: 4px solid #10b981;">
                    <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-slate-100">Tasks Over Time</h3>
                    <div class="relative h-64 w-full">
                        <canvas id="tasksOverTimeChart"></canvas>
                    </div>
                </div>
            </div>

            
            <div class="dashboard-panel relative overflow-hidden rounded-3xl dashboard-glass-panel border-none p-5 shadow-md dark:shadow-none transition-all hover:shadow-lg" id="mv-progress-panel">

                
                <div class="relative z-10 mb-4 flex items-center gap-2">
                    <h3 class="mr-auto text-lg font-semibold text-slate-800 dark:text-slate-100">Project Progress</h3>
                    <button id="mv-tab-sales"
                        onclick="mvSwitchTab('sales')"
                        class="mv-tab-btn rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wide transition">
                        Sales
                    </button>
                    <button id="mv-tab-technical"
                        onclick="mvSwitchTab('technical')"
                        class="mv-tab-btn rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wide transition">
                        Technical
                    </button>
                </div>

                <?php if(collect($projectProgress ?? [])->isEmpty()): ?>
                    <p class="text-sm text-slate-500 dark:text-slate-400">No project progress available yet.</p>
                <?php else: ?>
                    
                    <div id="mv-tab-content-sales" class="mv-tab-content relative z-10 space-y-2">
                        <?php $salesHasAny = collect($projectProgress)->contains(fn($p) => count($p['sales']['tasks']) > 0); ?>
                        <?php if(!$salesHasAny): ?>
                            
                            <?php $__currentLoopData = [
                                ['name' => 'Brand Campaign 2026', 'tasks' => 5, 'done' => 3, 'total' => 5, 'percent' => 60],
                                ['name' => 'Client Onboarding Pipeline', 'tasks' => 4, 'done' => 1, 'total' => 4, 'percent' => 25],
                            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ex): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="rounded-xl border-2 border-emerald-300 dark:border-emerald-500/50 overflow-hidden bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/25 dark:to-green-900/15 shadow-[0_0_10px_rgba(16,185,129,0.18)] pointer-events-none">
                                <div class="flex w-full items-center justify-between px-4 py-3">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span class="h-2.5 w-2.5 flex-shrink-0 rounded-full bg-emerald-500 shadow-[0_0_6px_rgba(16,185,129,0.7)]"></span>
                                        <span class="truncate text-sm font-bold text-emerald-800 dark:text-emerald-200"><?php echo e($ex['name']); ?></span>
                                    </div>
                                    <div class="ml-3 flex flex-shrink-0 items-center gap-3">
                                        <span class="rounded-full bg-emerald-200 dark:bg-emerald-500/30 px-2 py-0.5 text-[11px] font-bold text-emerald-800 dark:text-emerald-300 shadow-sm">
                                            <?php echo e($ex['tasks']); ?> tasks
                                        </span>
                                        <span class="tabular-nums text-xs font-semibold text-emerald-700 dark:text-emerald-400"><?php echo e($ex['done']); ?>/<?php echo e($ex['total']); ?></span>
                                        <div class="relative h-2 w-24 overflow-hidden rounded-full bg-emerald-100 dark:bg-emerald-900/40">
                                            <div class="absolute inset-y-0 left-0 rounded-full bg-gradient-to-r from-emerald-400 to-emerald-600 shadow-[0_0_6px_rgba(16,185,129,0.5)] progress-bar" data-width="<?php echo e($ex['percent']); ?>"></div>
                                        </div>
                                        <span class="w-8 text-right text-sm font-extrabold text-emerald-600 dark:text-emerald-400"><?php echo e($ex['percent']); ?>%</span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <p class="text-center text-[11px] italic text-emerald-400 dark:text-emerald-600 mt-1">— Example data (no real Sales tasks yet) —</p>
                        <?php else: ?>
                            <?php $__currentLoopData = $projectProgress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pi => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($project['sales']['tasks']) > 0): ?>
                                <div class="mv-accordion rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                                    
                                    <button
                                        class="mv-accordion-trigger flex w-full items-center justify-between px-4 py-3 text-left hover:bg-slate-50 dark:hover:bg-slate-800/50 transition"
                                        onclick="mvToggleAccordion(this)">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="h-2 w-2 flex-shrink-0 rounded-full bg-emerald-500"></span>
                                            <span class="truncate text-sm font-semibold text-slate-800 dark:text-white"><?php echo e($project['name']); ?></span>
                                        </div>
                                        <div class="ml-3 flex flex-shrink-0 items-center gap-3">
                                            <span class="rounded-full bg-emerald-100 dark:bg-emerald-500/20 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 dark:text-emerald-400">
                                                <?php echo e(count($project['sales']['tasks'])); ?> task<?php echo e(count($project['sales']['tasks']) !== 1 ? 's' : ''); ?>

                                            </span>
                                            <span class="tabular-nums text-xs text-slate-500">
                                                <?php echo e($project['sales']['done']); ?>/<?php echo e($project['sales']['total']); ?>

                                            </span>
                                            <div class="relative h-1.5 w-20 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                                                <?php
                                                    $salesPercent = isset($project['sales']['percent']) ? ((float) $project['sales']['percent']) : 0;
                                                ?>
                                                <div class="absolute inset-y-0 left-0 rounded-full bg-emerald-500 transition-all progress-bar"
                                                    data-width="<?php echo e($salesPercent); ?>"></div>
                                            </div>
                                            <span class="w-8 text-right text-xs font-semibold text-emerald-600 dark:text-emerald-400"><?php echo e($project['sales']['percent']); ?>%</span>
                                            <svg class="mv-chevron h-4 w-4 flex-shrink-0 text-slate-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </button>
                                    
                                    <div class="mv-accordion-body hidden border-t border-slate-100 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-800/30 px-4 py-4">
                                        <div class="mv-task-flow space-y-4">
                                            <div class="relative overflow-x-auto pb-2">
                                                <div class="relative min-w-[680px] px-2 pt-1">
                                                    <div class="flex min-w-[680px] items-start justify-between gap-1">
                                                        <?php $__currentLoopData = $project['sales']['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ti => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $statusLabel = ucwords(str_replace('_', ' ', $task['status']));
                                                                $nodeState = match($task['status']) {
                                                                    'done' => 'mv-node-done',
                                                                    'in_progress' => 'mv-node-in-progress',
                                                                    'for_review' => 'mv-node-for-review',
                                                                    'todo', 'backlog' => 'mv-node-todo',
                                                                    default => 'mv-node-todo',
                                                                };
                                                            ?>
                                                            <button type="button" class="mv-task-node relative flex flex-col items-center px-1 text-center <?php echo e($ti === 0 ? 'is-selected' : ''); ?>" data-target="sales-<?php echo e($project['id']); ?>-task-<?php echo e($task['id']); ?>" onclick="mvSelectTask(this)">
                                                                <span class="mv-node <?php echo e($nodeState); ?>"></span>
                                                                <span class="mt-2 text-xs font-semibold text-slate-700 dark:text-slate-300"><?php echo e($task['task_no'] ?: ('Task ' . ($ti + 1))); ?></span>
                                                                <span class="text-xs uppercase tracking-wide text-slate-500"><?php echo e($statusLabel); ?></span>
                                                            </button>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="space-y-2">
                                                <?php $__currentLoopData = $project['sales']['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ti => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $statusBadgeClass = match($task['status']) {
                                                            'done' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400',
                                                            'in_progress' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400',
                                                            'for_review' => 'bg-orange-100 dark:bg-orange-500/20 text-orange-700 dark:text-orange-400',
                                                            'todo', 'backlog' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400',
                                                            default => 'bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300',
                                                        };
                                                    ?>
                                                    <div id="sales-<?php echo e($project['id']); ?>-task-<?php echo e($task['id']); ?>" class="mv-task-detail rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 p-3 <?php echo e($ti === 0 ? '' : 'hidden'); ?>">
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400"><?php echo e($task['task_no'] ?: ('Task ' . ($ti + 1))); ?></span>
                                                            <span class="truncate text-sm font-medium text-slate-700 dark:text-slate-200"><?php echo e($task['title']); ?></span>
                                                            <span class="ml-auto rounded-full px-2 py-0.5 text-[11px] font-semibold <?php echo e($statusBadgeClass); ?>"><?php echo e(ucwords(str_replace('_', ' ', $task['status']))); ?></span>
                                                        </div>
                                                        <?php if($task['due_date']): ?>
                                                            <p class="mt-1 text-xs text-slate-400">Due: <?php echo e($task['due_date']); ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>

                    
                    <div id="mv-tab-content-technical" class="mv-tab-content relative z-10 hidden space-y-2">
                        <?php $techHasAny = collect($projectProgress)->contains(fn($p) => count($p['technical']['tasks']) > 0); ?>
                        <?php if(!$techHasAny): ?>
                            <p class="text-sm text-slate-300">No Technical tasks found.</p>
                        <?php else: ?>
                            <?php $__currentLoopData = $projectProgress; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pi => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($project['technical']['tasks']) > 0): ?>
                                <div class="mv-accordion rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                                    <button
                                        class="mv-accordion-trigger flex w-full items-center justify-between px-4 py-3 text-left hover:bg-slate-50 dark:hover:bg-slate-800/50 transition"
                                        onclick="mvToggleAccordion(this)">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="h-2 w-2 flex-shrink-0 rounded-full bg-blue-500"></span>
                                            <span class="truncate text-sm font-semibold text-slate-800 dark:text-white"><?php echo e($project['name']); ?></span>
                                        </div>
                                        <div class="ml-3 flex flex-shrink-0 items-center gap-3">
                                            <span class="rounded-full bg-blue-100 dark:bg-blue-500/20 px-2 py-0.5 text-[11px] font-semibold text-blue-700 dark:text-blue-400">
                                                <?php echo e(count($project['technical']['tasks'])); ?> task<?php echo e(count($project['technical']['tasks']) !== 1 ? 's' : ''); ?>

                                            </span>
                                            <span class="tabular-nums text-xs text-slate-500">
                                                <?php echo e($project['technical']['done']); ?>/<?php echo e($project['technical']['total']); ?>

                                            </span>
                                            <div class="relative h-1.5 w-20 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                                                <?php
                                                    $techPercent = isset($project['technical']['percent']) ? ((float) $project['technical']['percent']) : 0;
                                                ?>
                                                <div class="absolute inset-y-0 left-0 rounded-full bg-blue-500 transition-all progress-bar"
                                                    data-width="<?php echo e($techPercent); ?>"></div>
                                            </div>
                                            <span class="w-8 text-right text-xs font-semibold text-blue-600 dark:text-blue-400"><?php echo e($project['technical']['percent']); ?>%</span>
                                            <svg class="mv-chevron h-4 w-4 flex-shrink-0 text-slate-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </button>
                                    <div class="mv-accordion-body hidden border-t border-slate-100 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-800/30 px-4 py-4">
                                        <div class="mv-task-flow space-y-4">
                                            <div class="relative overflow-x-auto pb-2">
                                                <div class="relative min-w-[680px] px-2 pt-1">
                                                    <div class="flex min-w-[680px] items-start justify-between gap-1">
                                                        <?php $__currentLoopData = $project['technical']['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ti => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $statusLabel = ucwords(str_replace('_', ' ', $task['status']));
                                                                $nodeState = match($task['status']) {
                                                                    'done' => 'mv-node-done',
                                                                    'in_progress' => 'mv-node-in-progress',
                                                                    'for_review' => 'mv-node-for-review',
                                                                    'todo', 'backlog' => 'mv-node-todo',
                                                                    default => 'mv-node-todo',
                                                                };
                                                            ?>
                                                            <button type="button" class="mv-task-node relative flex flex-col items-center px-1 text-center <?php echo e($ti === 0 ? 'is-selected' : ''); ?>" data-target="technical-<?php echo e($project['id']); ?>-task-<?php echo e($task['id']); ?>" onclick="mvSelectTask(this)">
                                                                <span class="mv-node <?php echo e($nodeState); ?>"></span>
                                                                <span class="mt-2 text-xs font-semibold text-slate-700 dark:text-slate-300"><?php echo e($task['task_no'] ?: ('Task ' . ($ti + 1))); ?></span>
                                                                <span class="text-xs uppercase tracking-wide text-slate-500"><?php echo e($statusLabel); ?></span>
                                                            </button>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="space-y-2">
                                                <?php $__currentLoopData = $project['technical']['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ti => $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $statusBadgeClass = match($task['status']) {
                                                            'done' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400',
                                                            'in_progress' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400',
                                                            'for_review' => 'bg-orange-100 dark:bg-orange-500/20 text-orange-700 dark:text-orange-400',
                                                            'todo', 'backlog' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400',
                                                            default => 'bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300',
                                                        };
                                                    ?>
                                                    <div id="technical-<?php echo e($project['id']); ?>-task-<?php echo e($task['id']); ?>" class="mv-task-detail rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 p-3 <?php echo e($ti === 0 ? '' : 'hidden'); ?>">
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400"><?php echo e($task['task_no'] ?: ('Task ' . ($ti + 1))); ?></span>
                                                            <span class="truncate text-sm font-medium text-slate-700 dark:text-slate-200"><?php echo e($task['title']); ?></span>
                                                            <span class="ml-auto rounded-full px-2 py-0.5 text-[11px] font-semibold <?php echo e($statusBadgeClass); ?>"><?php echo e(ucwords(str_replace('_', ' ', $task['status']))); ?></span>
                                                        </div>
                                                        <?php if($task['due_date']): ?>
                                                            <p class="mt-1 text-xs text-slate-400">Due: <?php echo e($task['due_date']); ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <style>
                .mv-tab-btn { background: rgba(255, 255, 255, 0.4); backdrop-filter: blur(8px); color: #475569; border: 1px solid rgba(255, 255, 255, 0.5); transition: all 0.2s; }
                .mv-tab-btn.mv-tab-active-sales { background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(52, 211, 153, 0.2)); color: #065f46; border: 1px solid rgba(16, 185, 129, 0.4); font-weight: 800; box-shadow: 0 0 14px rgba(16, 185, 129, 0.3); transform: scale(1.06); }
                .mv-tab-btn.mv-tab-active-technical { background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(96, 165, 250, 0.2)); color: #1e40af; border: 1px solid rgba(59, 130, 246, 0.4); font-weight: 800; box-shadow: 0 0 14px rgba(59, 130, 246, 0.3); transform: scale(1.06); }
                html.dark .mv-tab-btn { background: rgba(30, 41, 59, 0.4); backdrop-filter: blur(8px); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.2s; }
                html.dark .mv-tab-btn.mv-tab-active-sales { background: linear-gradient(135deg, rgba(16, 185, 129, 0.30), rgba(16, 185, 129, 0.18)); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.5); font-weight: 800; box-shadow: 0 0 18px rgba(16, 185, 129, 0.4); transform: scale(1.06); }
                html.dark .mv-tab-btn.mv-tab-active-technical { background: linear-gradient(135deg, rgba(59, 130, 246, 0.30), rgba(59, 130, 246, 0.18)); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.5); font-weight: 800; box-shadow: 0 0 18px rgba(59, 130, 246, 0.4); transform: scale(1.06); }
                .mv-chevron.open { transform: rotate(180deg); }
                .mv-task-node:not(:first-child)::before {
                    content: '';
                    position: absolute;
                    right: 50%;
                    top: 9px;
                    width: 100%;
                    height: 2px;
                    background: #334155;
                    z-index: 0;
                }
                .mv-task-node.is-selected .mv-node {
                    transform: scale(1.08);
                    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.25);
                }
                .mv-node {
                    position: relative;
                    z-index: 1;
                    width: 18px;
                    height: 18px;
                    border-radius: 999px;
                    border: 2px solid transparent;
                    background: #1e293b;
                    transition: all 0.2s ease;
                }
                .mv-node-done {
                    background: #10b981;
                    border-color: #10b981;
                }
                .mv-node-in-progress {
                    background: #3b82f6;
                    border-color: #3b82f6;
                }
                .mv-node-todo {
                    background: #f59e0b;
                    border-color: #f59e0b;
                }
                .mv-node-for-review {
                    background: #f59e0b;
                    border-color: #f59e0b;
                }
            </style>
            <script>
                function mvSwitchTab(tab) {
                    document.querySelectorAll('.mv-tab-content').forEach(el => el.classList.add('hidden'));
                    document.querySelectorAll('.mv-tab-btn').forEach(btn => { btn.classList.remove('mv-tab-active-sales','mv-tab-active-technical'); });
                    document.getElementById('mv-tab-content-' + tab).classList.remove('hidden');
                    document.getElementById('mv-tab-' + tab).classList.add('mv-tab-active-' + tab);
                }
                function mvToggleAccordion(trigger) {
                    var body    = trigger.nextElementSibling;
                    var chevron = trigger.querySelector('.mv-chevron');
                    var isOpen  = !body.classList.contains('hidden');
                    body.classList.toggle('hidden', isOpen);
                    chevron && chevron.classList.toggle('open', !isOpen);
                }
                function mvSelectTask(nodeEl) {
                    var flow = nodeEl.closest('.mv-task-flow');
                    if (!flow) return;

                    flow.querySelectorAll('.mv-task-node').forEach(function (n) {
                        n.classList.remove('is-selected');
                    });
                    nodeEl.classList.add('is-selected');

                    var targetId = nodeEl.getAttribute('data-target');
                    flow.querySelectorAll('.mv-task-detail').forEach(function (detail) {
                        detail.classList.add('hidden');
                    });

                    var target = flow.querySelector('[id="' + targetId + '"]');
                    if (target) {
                        target.classList.remove('hidden');
                    }
                }
                // Init: activate Sales tab by default
                document.addEventListener('DOMContentLoaded', function () { mvSwitchTab('sales'); });
            </script>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                
                <div class="dashboard-panel relative overflow-hidden rounded-3xl dashboard-glass-panel border-none p-4 shadow-md dark:shadow-none transition-all hover:shadow-lg">
                    <div class="relative z-10 mb-3 flex items-center justify-between">
                        <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Urgent Tasks</h3>
                        <a href="<?php echo e(route('tasks.list', ['priority' => 'urgent'])); ?>" class="text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:underline">View All</a>
                    </div>
                    <?php if($urgentTasks->isEmpty()): ?>
                        <div class="relative z-10 flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 dark:border-slate-600 bg-white/40 dark:bg-slate-800/40 px-4 py-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-2 text-xs text-slate-600 dark:text-slate-400">No urgent tasks</p>
                        </div>
                    <?php else: ?>
                        <div class="relative z-10 overflow-x-auto rounded-2xl border border-slate-200/50 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 max-h-80 overflow-y-auto">
                            <table class="min-w-full text-xs">
                                <thead class="sticky top-0 bg-white/60 dark:bg-slate-800/60 backdrop-blur-md">
                                    <tr class="border-b border-slate-200 dark:border-slate-700">
                                        <th class="px-2 py-2 text-left font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">Title</th>
                                        <th class="px-2 py-2 text-left font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">Project</th>
                                        <th class="px-2 py-2 text-left font-semibold uppercase tracking-widest text-slate-500 dark:text-slate-400">Due</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = ($urgentTasks ?? collect())->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="border-b border-slate-100 dark:border-slate-700/50 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800">
                                            <td class="px-2 py-1.5 font-medium text-slate-800 dark:text-slate-200 truncate">
                                                <a href="<?php echo e(route('tasks.show', $task)); ?>" class="text-blue-600 hover:text-blue-800 hover:underline" title="<?php echo e($task->title); ?>"><?php echo e(Illuminate\Support\Str::limit($task->title, 20)); ?></a>
                                            </td>
                                            <td class="px-2 py-1.5 text-slate-500 dark:text-slate-400 text-xs truncate"><?php echo e(Illuminate\Support\Str::limit($task->project->name ?? '-', 12)); ?></td>
                                            <td class="px-2 py-1.5 <?php echo e($task->isOverdue() ? 'font-semibold text-rose-600' : 'text-slate-600 dark:text-slate-400'); ?> text-xs whitespace-nowrap"><?php echo e($task->due_date ? $task->due_date->format('m-d') : '-'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="dashboard-panel relative overflow-hidden rounded-3xl dashboard-glass-panel border-none p-4 shadow-md dark:shadow-none transition-all hover:shadow-lg">
                    <div class="relative z-10 mb-3 flex items-center justify-between">
                        <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Upcoming Meetings</h3>
                        <a href="<?php echo e(route('meetings.index')); ?>" class="text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:underline">View All</a>
                    </div>
                    <?php if($upcomingMeetings->isEmpty()): ?>
                        <div class="relative z-10 flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 dark:border-slate-600 bg-white/40 dark:bg-slate-800/40 px-4 py-6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-xs text-slate-600 dark:text-slate-400">No meetings scheduled</p>
                        </div>
                    <?php else: ?>
                        <div class="relative z-10 space-y-2 max-h-80 overflow-y-auto">
                            <?php $__currentLoopData = $upcomingMeetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="rounded-lg border border-slate-200/50 dark:border-slate-700/50 bg-white/40 dark:bg-slate-800/40 p-2.5 hover:bg-white/60 dark:hover:bg-slate-700/60 transition-colors">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="min-w-0 flex-1">
                                            <a href="<?php echo e(route('meetings.index')); ?>" class="block text-xs font-semibold text-blue-600 hover:text-blue-800 truncate" title="<?php echo e($meeting->title); ?>">
                                                <?php echo e(Illuminate\Support\Str::limit($meeting->title, 24)); ?>

                                            </a>
                                            <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400"><?php echo e($meeting->meeting_date?->format('M d, Y')); ?></p>
                                            <?php if($meeting->start_time): ?>
                                                <p class="text-xs text-slate-500 dark:text-slate-400"><?php echo e($meeting->start_time); ?><?php if($meeting->end_time): ?> - <?php echo e($meeting->end_time); ?><?php endif; ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php if($meeting->location): ?>
                                        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400 truncate">📍 <?php echo e(Illuminate\Support\Str::limit($meeting->location, 20)); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                <div class="dashboard-panel relative flex h-[320px] flex-col overflow-hidden rounded-3xl dashboard-glass-panel border-none p-4 shadow-md dark:shadow-none transition-all hover:shadow-lg">
                    <div class="relative z-10 mb-3 flex items-center justify-between">
                        <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Recent Activity</h3>
                        <a href="<?php echo e(route('tasks.list')); ?>" class="text-xs font-medium text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:underline">View All</a>
                    </div>
                    <ul class="activity-timeline relative z-10 flex-1 space-y-3 overflow-y-auto pr-1" style="padding-left: 2px;">
                        <?php $__empty_1 = true; $__currentLoopData = ($recentActivities ?? $recentActivity); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $logIdx => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $desc = (string) $log->getDescription();
                                $descLower = strtolower($desc);
                                $isAlert = str_contains($descLower, 'overdue') || str_contains($descLower, 'alert') || str_contains($descLower, 'deadline');
                                $isCreate = str_contains($descLower, 'create') || str_contains($descLower, 'added') || str_contains($descLower, 'new');
                                $isStatus = str_contains($descLower, 'status') || str_contains($descLower, 'moved') || str_contains($descLower, 'updated');
                                $dotColor = $isAlert
                                    ? 'background:#f59e0b'
                                    : ($isCreate
                                        ? 'background:#10b981'
                                        : ($isStatus
                                            ? 'background:#3b82f6'
                                            : 'background:#8b5cf6'));
                                $isLatestLog = $logIdx === 0;
                            ?>
                            <li class="relative flex items-start gap-3 <?php echo e($isLatestLog ? 'rounded-lg bg-blue-50 dark:bg-blue-500/10 px-2 py-1 ring-1 ring-blue-200 dark:ring-blue-500/30' : ''); ?>">
                                <?php
                                    $dotColorValue = trim(str_replace('background:', '', $dotColor)) ?: '#8b5cf6';
                                ?>
                                <div class="timeline-dot" <?php echo 'style="background-color:' . e($dotColorValue) . ';"'; ?>></div>
                                <div class="-mt-1 min-w-0 flex-1">
                                    <div class="flex items-start justify-between gap-3">
                                        <p class="text-xs leading-4">
                                            <?php if($isLatestLog): ?>
                                                <span class="mr-1 inline-flex items-center rounded-full bg-blue-500 px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wide text-white">Latest</span>
                                            <?php endif; ?>
                                            <span class="font-bold text-slate-800 dark:text-slate-200"><?php echo e($log->actor?->name ?? 'System'); ?></span>
                                            <span class="text-slate-600 dark:text-slate-400"> <?php echo e($desc); ?></span>
                                        </p>
                                        <span class="whitespace-nowrap text-xs italic text-slate-400"><?php echo e($log->created_at?->diffForHumans()); ?></span>
                                    </div>
                                    <p class="mt-0.5 text-[11px] text-slate-500">Activity Log Entry</p>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="py-3">
                                <div class="flex flex-col items-center rounded-2xl border border-dashed border-slate-300 dark:border-slate-600 bg-white/40 dark:bg-slate-800/40 px-4 py-6 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4V9m2 12H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-2 text-xs text-slate-600">No recent activity yet.</p>
                                    <a href="<?php echo e(route('tasks.create')); ?>" class="mt-3 rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-indigo-500">Get Started</a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="dashboard-panel relative flex h-[320px] flex-col overflow-hidden rounded-3xl dashboard-glass-panel border-none p-4 shadow-md dark:shadow-none transition-all hover:shadow-lg">
                    <div class="relative z-10 mb-3 flex items-center justify-between gap-2">
                        <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">Latest Notifications</h3>
                        <button id="mark-all-notifications-read" type="button" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white/40 dark:bg-slate-800/40 px-2.5 py-1 text-[11px] font-medium text-slate-700 dark:text-slate-300 transition hover:bg-white/60 dark:hover:bg-slate-700/60">Mark all as read</button>
                    </div>
                    <ul id="latest-notifications-list" class="relative z-10 flex-1 divide-y divide-slate-200 dark:divide-slate-700 overflow-y-auto pr-1">
                        <?php $__empty_1 = true; $__currentLoopData = $latestNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notifIdx => $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $isLatestNotif = $notifIdx === 0; ?>
                            <li class="flex items-start justify-between gap-2 py-2 text-xs rounded-lg px-2 <?php echo e($isLatestNotif ? 'bg-blue-50 dark:bg-blue-500/10 ring-1 ring-blue-300 dark:ring-blue-500/40 mb-1' : ''); ?>" data-notification-id="<?php echo e($notif->id); ?>" data-notification-link="<?php echo e($notif->data['link'] ?? ''); ?>">
                                <div class="flex flex-1 items-start gap-1.5 min-w-0">
                                    <?php if($isLatestNotif): ?>
                                        <span class="mt-0.5 flex-shrink-0 rounded-full bg-blue-500 px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wide text-white">Latest</span>
                                    <?php endif; ?>
                                    <a href="<?php echo e($notif->data['link'] ?? route('dashboard')); ?>" class="flex-1 <?php echo e($isLatestNotif ? 'font-semibold text-blue-700 dark:text-blue-300 hover:text-blue-800' : 'text-slate-700 dark:text-slate-300 hover:text-blue-600'); ?> hover:underline">
                                        <?php echo e(Illuminate\Support\Str::limit($notif->data['message'] ?? $notif->data['body'] ?? '-', 72)); ?>

                                    </a>
                                </div>
                                <button type="button" class="mark-notification-read rounded-md p-1 text-slate-400 transition hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-700" aria-label="Mark as read" title="Mark as read">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="py-2 text-xs text-slate-600">No notifications</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            </div>
</div>
</div>
<?php
    $dashboardData = [
        'statusLabelsTransformed' => ['Todo', 'In Progress', 'For Review', 'Done'],
        'chartData' => $chartData ?? $statusCounts,
        'statusCounts' => $statusCounts,
        'tasksPerDayLabelsFormatted' => $tasksPerDayLabelsFormatted,
        'tasksPerDay' => $tasksPerDay,
        'dashboardUrl' => route('dashboard'),
        'unreadNotificationsUrl' => route('dashboard.notifications.unread'),
        'notificationReadUrlTemplate' => route('notifications.read', ['id' => '__ID__']),
        'notificationReadAllUrl' => route('notifications.read-all'),
        'metricsUrl' => route('dashboard.metrics'),
    ];
?>
<script id="dashboard-data" type="application/json"><?php echo json_encode($dashboardData, 15, 512) ?></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const payloadEl = document.getElementById('dashboard-data');
    const payload = payloadEl ? JSON.parse(payloadEl.textContent || '{}') : {};

    // Normalize weekly data to Monday-Sunday order
    const normalizeWeeklyData = (labels, data) => {
        if (!Array.isArray(labels) || !Array.isArray(data)) {
            return { labels, data };
        }

        const dayMap = {
            'Monday': 0, 'Mon': 0,
            'Tuesday': 1, 'Tue': 1,
            'Wednesday': 2, 'Wed': 2,
            'Thursday': 3, 'Thu': 3,
            'Friday': 4, 'Fri': 4,
            'Saturday': 5, 'Sat': 5,
            'Sunday': 6, 'Sun': 6
        };

        // Create array of {day, label, dataValue, index} objects
        const dayObjects = labels.map((label, idx) => {
            const dayKey = Object.keys(dayMap).find(k => label.includes(k));
            const dayIndex = dayKey ? dayMap[dayKey] : -1;
            return {
                dayIndex: dayIndex,
                label: label,
                dataValue: data[idx],
                originalIndex: idx
            };
        });

        // Sort by day index (Monday=0 to Sunday=6)
        dayObjects.sort((a, b) => {
            if (a.dayIndex === -1) return 1;
            if (b.dayIndex === -1) return -1;
            return a.dayIndex - b.dayIndex;
        });

        // Extract sorted labels and data
        const sortedLabels = dayObjects.map(obj => obj.label);
        const sortedData = dayObjects.map(obj => obj.dataValue);

        return { labels: sortedLabels, data: sortedData };
    };

    let statusChart;
    let lineChart;

    const isDarkModeChart = () => document.documentElement.classList.contains('dark');

    if (window.Chart) {
        const statusCtx = document.getElementById('taskStatusChart');
        const lineCtx = document.getElementById('tasksOverTimeChart');

        // ---- TASK STATUS: Doughnut Chart ----
        if (statusCtx) {
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: payload.statusLabelsTransformed || ['Todo', 'In Progress', 'For Review', 'Done'],
                    datasets: [{
                        data: payload.chartData || payload.statusCounts || [],
                        backgroundColor: ['#94A3B8', '#3B82F6', '#FF9100', '#10B981'],
                        hoverBackgroundColor: ['#CBD5E1', '#93C5FD', '#FDBA74', '#6EE7B7'],
                        borderWidth: 3,
                        borderColor: isDarkModeChart() ? '#1e293b' : '#ffffff',
                        hoverOffset: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '0%',
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: isDarkModeChart() ? '#94a3b8' : '#64748b',
                                font: { size: 11 },
                                padding: 16,
                                usePointStyle: true,
                                pointStyle: 'circle',
                            }
                        },
                        tooltip: {
                            backgroundColor: isDarkModeChart() ? '#1e293b' : '#fff',
                            titleColor: isDarkModeChart() ? '#e2e8f0' : '#0f172a',
                            bodyColor: isDarkModeChart() ? '#94a3b8' : '#64748b',
                            borderColor: isDarkModeChart() ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 10,
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((sum, item) => sum + item, 0) || 1;
                                    const pct = Math.round((value / total) * 100);
                                    return ` ${value} tasks (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // ---- TASKS OVER TIME: Recharts-inspired premium area chart ----
        if (lineCtx) {
            const normalizedData = normalizeWeeklyData(
                payload.tasksPerDayLabelsFormatted || [],
                payload.tasksPerDay || []
            );
            const overtimeDataMax = Math.max(0, ...(normalizedData.data || [0]));

            // Blue/cyan gradient fade to mimic the provided AreaChart design.
            const lineCtxCanvas = lineCtx.getContext('2d');
            const gradientFill = lineCtxCanvas.createLinearGradient(0, 0, 0, lineCtx.offsetHeight || 200);
            gradientFill.addColorStop(0.05, 'rgba(0, 229, 255, 0.50)');
            gradientFill.addColorStop(0.95, 'rgba(41, 98, 255, 0.00)');

            lineChart = new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: normalizedData.labels,
                    datasets: [{
                        label: 'Tasks Created',
                        data: normalizedData.data,
                        borderColor: '#00E5FF',
                        backgroundColor: gradientFill,
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointBorderWidth: 2,
                        pointBackgroundColor: '#2962FF',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#2962FF',
                        pointHoverBorderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: isDarkModeChart() ? '#1e293b' : '#fff',
                            titleColor: isDarkModeChart() ? '#e2e8f0' : '#0f172a',
                            bodyColor: isDarkModeChart() ? '#94a3b8' : '#64748b',
                            borderColor: isDarkModeChart() ? '#334155' : '#e2e8f0',
                            borderWidth: 1,
                            padding: 10,
                            callbacks: {
                                label: ctx => ` ${ctx.parsed.y} tasks`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: overtimeDataMax > 0 ? overtimeDataMax + 2 : 5,
                            ticks: {
                                precision: 0,
                                stepSize: 1,
                                color: '#94A3B8',
                                font: { size: 12 }
                            },
                            grid: {
                                color: isDarkModeChart() ? 'rgba(148,163,184,0.30)' : 'rgba(226,232,240,0.60)',
                                borderDash: [3, 3],
                                drawBorder: false
                            },
                            border: { display: false }
                        },
                        x: {
                            ticks: {
                                color: '#64748B',
                                font: { size: 12, weight: '600' },
                                padding: 10
                            },
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });
        }
    }

    const notificationsList = document.getElementById('latest-notifications-list');
    const markAllReadButton = document.getElementById('mark-all-notifications-read');

    const updateGlobalNotificationBadge = (unreadCount) => {
        const badge = document.getElementById('global-notification-badge');

        if (!badge) {
            return;
        }

        if (!unreadCount || unreadCount <= 0) {
            badge.classList.add('hidden');
            badge.textContent = '0';
            return;
        }

        badge.classList.remove('hidden');
        badge.textContent = unreadCount > 99 ? '99+' : String(unreadCount);
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const getNotificationReadUrl = (notificationId) => {
        return (payload.notificationReadUrlTemplate || '').replace('__ID__', encodeURIComponent(notificationId));
    };

    const renderNotifications = (items) => {
        if (!notificationsList) {
            return;
        }

        if (!items || items.length === 0) {
            notificationsList.innerHTML = '<li class="py-2 text-xs text-slate-600">No notifications</li>';
            updateGlobalNotificationBadge(0);
            return;
        }

        notificationsList.innerHTML = items
            .map(item => `
                <li class="flex items-start justify-between gap-2 py-2 text-xs" data-notification-id="${item.id}" data-notification-link="${item.link ?? ''}">
                    <a href="${item.link || payload.dashboardUrl || '#'}" class="flex-1 text-slate-700 hover:text-blue-600 hover:underline">${item.message ?? '-'}</a>
                    <button type="button" class="mark-notification-read rounded-md p-1 text-slate-400 transition hover:bg-white/10 hover:text-white" aria-label="Mark as read" title="Mark as read">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </li>
            `)
            .join('');
    };

    const refreshNotifications = async () => {
        try {
            const response = await fetch(payload.unreadNotificationsUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (response.status === 401) {
                handleSessionExpired();
                return;
            }

            if (!response.ok) {
                return;
            }

            const dataPayload = await response.json();
            const items = dataPayload.data || [];
            renderNotifications(items);
            updateGlobalNotificationBadge(typeof dataPayload.unread_count === 'number' ? dataPayload.unread_count : items.length);
        } catch (error) {
        }
    };

    const markNotificationAsRead = async (notificationId) => {
        if (!notificationId || !payload.notificationReadUrlTemplate) {
            return;
        }

        try {
            const response = await fetch(getNotificationReadUrl(notificationId), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                return;
            }

            const readPayload = await response.json();
            if (typeof readPayload.unread_count === 'number') {
                updateGlobalNotificationBadge(readPayload.unread_count);
            }

            await refreshNotifications();
        } catch (error) {
        }
    };

    const markAllNotificationsAsRead = async () => {
        if (!payload.notificationReadAllUrl) {
            return;
        }

        try {
            const response = await fetch(payload.notificationReadAllUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                return;
            }

            const readPayload = await response.json();
            if (typeof readPayload.unread_count === 'number') {
                updateGlobalNotificationBadge(readPayload.unread_count);
            }

            renderNotifications([]);
        } catch (error) {
        }
    };

    notificationsList?.addEventListener('click', function (event) {
        const target = event.target instanceof Element ? event.target.closest('.mark-notification-read') : null;
        if (!target) {
            return;
        }

        const item = target.closest('[data-notification-id]');
        const notificationId = item?.getAttribute('data-notification-id');
        if (!notificationId) {
            return;
        }

        markNotificationAsRead(notificationId);
    });

    markAllReadButton?.addEventListener('click', function () {
        markAllNotificationsAsRead();
    });

    const refreshMetrics = async () => {
        if (!payload.metricsUrl) {
            return;
        }

        try {
            const response = await fetch(payload.metricsUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (response.status === 401) {
                handleSessionExpired();
                return;
            }

            if (!response.ok) {
                return;
            }

            const metrics = await response.json();

            if (statusChart && Array.isArray(metrics.chartData || metrics.statusCounts)) {
                statusChart.data.datasets[0].data = metrics.chartData || metrics.statusCounts;
                statusChart.update();
            }

            if (lineChart && Array.isArray(metrics.tasksPerDay) && Array.isArray(metrics.tasksPerDayLabelsFormatted)) {
                // Normalize weekly data to Monday-Sunday order
                const normalizedRefreshData = normalizeWeeklyData(
                    metrics.tasksPerDayLabelsFormatted,
                    metrics.tasksPerDay
                );
                const refreshOvertimeMax = Math.max(0, ...(normalizedRefreshData.data || [0]));
                lineChart.data.labels = normalizedRefreshData.labels;
                lineChart.data.datasets[0].data = normalizedRefreshData.data;
                lineChart.options.scales.y.suggestedMax = refreshOvertimeMax > 0 ? refreshOvertimeMax + 1 : 2;
                lineChart.update();
            }

            const donePct = document.getElementById('done-percentage');
            const inProgressPct = document.getElementById('in-progress-percentage');

            if (donePct && typeof metrics.donePercentage === 'number') {
                donePct.textContent = `${metrics.donePercentage}%`;
            }

            if (inProgressPct && typeof metrics.inProgressPercentage === 'number') {
                inProgressPct.textContent = `${metrics.inProgressPercentage}%`;
            }
        } catch (error) {
        }
    };

    // Apply progress bar widths from data attributes
    document.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
        const width = parseFloat(bar.getAttribute('data-width')) || 0;
        bar.style.width = width + '%';
    });

    window.addEventListener('theme-changed', function(e) {
        const isDark = e.detail.theme === 'dark';

        // Update Pie/Doughnut Chart (statusChart)
        if (statusChart) {
            statusChart.data.datasets[0].borderColor = isDark ? '#1e293b' : '#ffffff';
            statusChart.options.plugins.legend.labels.color = isDark ? '#94a3b8' : '#64748b';
            statusChart.options.plugins.tooltip.backgroundColor = isDark ? '#1e293b' : '#fff';
            statusChart.options.plugins.tooltip.titleColor = isDark ? '#e2e8f0' : '#0f172a';
            statusChart.options.plugins.tooltip.bodyColor = isDark ? '#94a3b8' : '#64748b';
            statusChart.options.plugins.tooltip.borderColor = isDark ? '#334155' : '#e2e8f0';
            statusChart.update();
        }

        // Update Line Chart (lineChart)
        if (lineChart) {
            lineChart.options.plugins.tooltip.backgroundColor = isDark ? '#1e293b' : '#fff';
            lineChart.options.plugins.tooltip.titleColor = isDark ? '#e2e8f0' : '#0f172a';
            lineChart.options.plugins.tooltip.bodyColor = isDark ? '#94a3b8' : '#64748b';
            lineChart.options.plugins.tooltip.borderColor = isDark ? '#334155' : '#e2e8f0';
            lineChart.options.scales.y.grid.color = isDark ? 'rgba(148,163,184,0.30)' : 'rgba(226,232,240,0.60)';
            lineChart.update();
        }
    });

    var notifInterval = setInterval(refreshNotifications, 15000);
    var metricsInterval = setInterval(refreshMetrics, 15000);

    function handleSessionExpired() {
        clearInterval(notifInterval);
        clearInterval(metricsInterval);
        window.location.href = '/login';
    }
});

</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/dashboard.blade.php ENDPATH**/ ?>