(

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="bg-white/70 backdrop-blur-md border border-white/20 shadow-xl rounded-3xl p-6 dark:bg-slate-900/40 dark:border-white/10 dark:shadow-none">
        <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Company Calendar</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Split view: Event Calendar and Tasks Calendar</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="<?php echo e(route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => 'all', 'activity' => ($activity ?? 'all')])); ?>" class="rounded-full px-4 py-2 text-xs font-semibold transition-all <?php echo e(($panel ?? 'all') === 'all' ? 'bg-teal-500 text-white shadow-[0_0_15px_rgba(20,184,166,0.4)]' : 'bg-slate-200/50 text-slate-600 border border-slate-300/50 dark:bg-white/5 dark:text-slate-300 dark:border-white/10 hover:bg-white/20'); ?>">All</a>
            <a href="<?php echo e(route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => 'events', 'activity' => ($activity ?? 'all')])); ?>" class="rounded-full px-4 py-2 text-xs font-semibold transition-all <?php echo e(($panel ?? 'all') === 'events' ? 'bg-teal-500 text-white shadow-[0_0_15px_rgba(20,184,166,0.4)]' : 'bg-slate-200/50 text-slate-600 border border-slate-300/50 dark:bg-white/5 dark:text-slate-300 dark:border-white/10 hover:bg-white/20'); ?>">Event Calendar</a>
            <a href="<?php echo e(route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => 'tasks', 'activity' => ($activity ?? 'all')])); ?>" class="rounded-full px-4 py-2 text-xs font-semibold transition-all <?php echo e(($panel ?? 'all') === 'tasks' ? 'bg-teal-500 text-white shadow-[0_0_15px_rgba(20,184,166,0.4)]' : 'bg-slate-200/50 text-slate-600 border border-slate-300/50 dark:bg-white/5 dark:text-slate-300 dark:border-white/10 hover:bg-white/20'); ?>">Tasks Calendar</a>
            <a href="<?php echo e(route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => ($panel ?? 'all'), 'activity' => 'all'])); ?>" class="rounded-full px-4 py-2 text-xs font-semibold transition-all <?php echo e(($activity ?? 'all') === 'all' ? 'bg-teal-500 text-white shadow-[0_0_15px_rgba(20,184,166,0.4)]' : 'bg-slate-200/50 text-slate-600 border border-slate-300/50 dark:bg-white/5 dark:text-slate-300 dark:border-white/10 hover:bg-white/20'); ?>">All Movaflex</a>
            <a href="<?php echo e(route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => ($panel ?? 'all'), 'activity' => 'sales'])); ?>" class="rounded-full px-4 py-2 text-xs font-semibold transition-all <?php echo e(($activity ?? 'all') === 'sales' ? 'bg-teal-500 text-white shadow-[0_0_15px_rgba(20,184,166,0.4)]' : 'bg-slate-200/50 text-slate-600 border border-slate-300/50 dark:bg-white/5 dark:text-slate-300 dark:border-white/10 hover:bg-white/20'); ?>">Sales</a>
            <a href="<?php echo e(route('tasks.calendar', ['month' => $month->format('Y-m'), 'panel' => ($panel ?? 'all'), 'activity' => 'technical'])); ?>" class="rounded-full px-4 py-2 text-xs font-semibold transition-all <?php echo e(($activity ?? 'all') === 'technical' ? 'bg-teal-500 text-white shadow-[0_0_15px_rgba(20,184,166,0.4)]' : 'bg-slate-200/50 text-slate-600 border border-slate-300/50 dark:bg-white/5 dark:text-slate-300 dark:border-white/10 hover:bg-white/20'); ?>">Technical</a>
            <a href="<?php echo e(route('meetings.index')); ?>" class="rounded-full px-4 py-2 text-xs font-semibold bg-slate-200/50 text-slate-600 border border-slate-300/50 dark:bg-white/5 dark:text-slate-300 dark:border-white/10 hover:bg-white/20 transition-all">Meetings</a>
            <a href="<?php echo e(route('holidays.index')); ?>" class="rounded-full px-4 py-2 text-xs font-semibold bg-slate-200/50 text-slate-600 border border-slate-300/50 dark:bg-white/5 dark:text-slate-300 dark:border-white/10 hover:bg-white/20 transition-all">Holidays</a>
            <a href="<?php echo e(route('tasks.calendar', ['month' => $prevMonth, 'panel' => ($panel ?? 'all'), 'activity' => ($activity ?? 'all')])); ?>" class="rounded-full px-4 py-2 text-xs font-semibold bg-slate-200/50 text-slate-600 border border-slate-300/50 dark:bg-white/5 dark:text-slate-300 dark:border-white/10 hover:bg-white/20 transition-all">Previous</a>
            <span class="rounded-full bg-teal-500/10 border border-teal-400/30 px-4 py-2 text-xs font-bold text-teal-700 dark:text-teal-300"><?php echo e($month->format('F Y')); ?></span>
            <a href="<?php echo e(route('tasks.calendar', ['month' => $nextMonth, 'panel' => ($panel ?? 'all'), 'activity' => ($activity ?? 'all')])); ?>" class="rounded-full px-4 py-2 text-xs font-semibold bg-slate-200/50 text-slate-600 border border-slate-300/50 dark:bg-white/5 dark:text-slate-300 dark:border-white/10 hover:bg-white/20 transition-all">Next</a>
        </div>
        </div>
    </div>

    <?php if(($panel ?? 'all') !== 'tasks'): ?>
    <div class="bg-white/70 backdrop-blur-md border border-white/20 shadow-xl rounded-3xl p-5 dark:bg-slate-900/40 dark:border-white/10 dark:shadow-none">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-sm font-semibold uppercase tracking-widest text-violet-600 dark:text-violet-400">Event Calendar</h2>
            <p class="text-xs text-slate-400 dark:text-slate-500">Inputs are managed in Meetings and Holidays modules.</p>
        </div>
        <div class="mb-4 flex flex-wrap gap-2 text-xs">
            <span class="rounded-full bg-violet-100 dark:bg-violet-900/40 px-2.5 py-1 font-bold text-violet-700 dark:text-violet-300 border border-violet-200 dark:border-violet-700/40">Meeting</span>
            <span class="rounded-full bg-amber-100 dark:bg-amber-900/40 px-2.5 py-1 font-bold text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-700/40">Holiday</span>
        </div>
        <div class="space-y-2">
            <?php
                $eventDays = collect($meetingsByDate->keys())
                    ->merge($holidaysByDate->keys())
                    ->unique()
                    ->sort()
                    ->values();
            ?>
            <?php $__empty_1 = true; $__currentLoopData = $eventDays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dayKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $__currentLoopData = ($holidaysByDate->get($dayKey, collect())); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $holiday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="group relative flex items-center justify-between px-4 py-2.5 mb-2 transition-all duration-300
                            bg-white/80 border border-slate-200 shadow-sm rounded-xl
                            dark:bg-slate-800/40 dark:border-white/10 dark:shadow-none dark:backdrop-blur-md
                            hover:scale-[1.005] hover:bg-white dark:hover:bg-slate-800/60">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 h-6 w-0.5 rounded-full
                                bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.4)]"></div>
                    <div class="pl-6">
                        <div class="flex items-center gap-2">
                            <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-amber-600 dark:text-amber-400">Holiday</span>
                            <span class="text-[11px] text-slate-400 dark:text-slate-500"><?php echo e(\Carbon\Carbon::parse($dayKey)->format('M d, Y (D)')); ?></span>
                        </div>
                        <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 capitalize"><?php echo e($holiday->name); ?></h4>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = ($meetingsByDate->get($dayKey, collect())); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="group relative flex items-center justify-between px-4 py-2.5 mb-2 transition-all duration-300
                            bg-white/80 border border-slate-200 shadow-sm rounded-xl
                            dark:bg-slate-800/40 dark:border-white/10 dark:shadow-none dark:backdrop-blur-md
                            hover:scale-[1.005] hover:bg-white dark:hover:bg-slate-800/60">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 h-6 w-0.5 rounded-full
                                bg-purple-500 shadow-[0_0_8px_rgba(168,85,247,0.4)]"></div>
                    <div class="pl-6">
                        <div class="flex items-center gap-2">
                            <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-purple-600 dark:text-purple-400">Meeting</span>
                            <span class="text-[11px] text-slate-400 dark:text-slate-500"><?php echo e(\Carbon\Carbon::parse($dayKey)->format('M d, Y (D)')); ?></span>
                        </div>
                        <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-100 capitalize"><?php echo e($meeting->title); ?></h4>
                    </div>
                    <?php if(!empty($meeting->start_time)): ?>
                    <div class="pr-2 text-right shrink-0">
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-white/5 px-2.5 py-1 rounded-full">
                            <?php echo e(\Carbon\Carbon::parse($meeting->start_time)->format('h:i A')); ?>

                        </span>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="rounded-2xl border border-dashed border-slate-200 dark:border-white/10 bg-slate-50/50 dark:bg-white/5 px-3 py-6 text-center text-sm text-slate-400 dark:text-slate-500">No events scheduled for this month.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if(($panel ?? 'all') !== 'events'): ?>
    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/10 rounded-[3rem] shadow-2xl overflow-hidden">
        
        <div class="flex flex-wrap items-center justify-between gap-3 px-8 py-6 border-b border-white/5 bg-white/5">
            <h3 class="text-sm font-black tracking-[0.3em] text-teal-400 uppercase">
                Tasks Calendar —
                <span class="text-slate-100">
                    <?php if(($activity ?? 'all') === 'sales'): ?> Sales Activity
                    <?php elseif(($activity ?? 'all') === 'technical'): ?> Technical Activity
                    <?php else: ?> Active Tasks Only
                    <?php endif; ?>
                </span>
            </h3>
            <div class="flex flex-wrap gap-3">
                <span class="px-5 py-2 rounded-full bg-blue-600/20 border border-blue-500/30 text-xs text-blue-400 font-bold backdrop-blur-md">Active Projects</span>
                <span class="px-5 py-2 rounded-full bg-amber-500/20 border border-amber-500/30 text-xs text-amber-300 font-bold backdrop-blur-md">My Tasks</span>
                <span class="px-5 py-2 rounded-full bg-orange-500/20 border border-orange-500/30 text-xs text-orange-300 font-bold backdrop-blur-md">Pending Review</span>
                <span class="px-5 py-2 rounded-full bg-rose-600/20 border border-rose-500/30 text-xs text-rose-400 font-bold backdrop-blur-md">Overdue</span>
                <span class="px-5 py-2 rounded-full bg-teal-500 text-white text-xs font-bold shadow-lg shadow-teal-500/40">Done</span>
            </div>
        </div>

        
        <div class="grid grid-cols-7 text-center border-b border-white/5 bg-white/5">
            <?php $__currentLoopData = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="py-5 text-xs font-bold uppercase tracking-[0.2em] text-slate-500"><?php echo e($dow); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="grid grid-cols-7">
            <?php $__currentLoopData = \Carbon\CarbonPeriod::create($startOfGrid, '1 day', $endOfGrid); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $key = $day->format('Y-m-d');
                    $dayTasks = $tasksByDate->get($key, collect());
                    $hasHoliday = $holidaysByDate && $holidaysByDate->has($key);
                    $hasContent = $dayTasks->isNotEmpty() || $hasHoliday;
                    $isCurrentMonth = $day->month === $month->month;
                    $isToday = $day->isToday();
                ?>
                <div class="min-h-[140px] border-b border-r border-white/5 p-4 transition-all group hover:bg-white/5 relative <?php echo e($isCurrentMonth ? '' : 'opacity-40'); ?>">
                    <div class="mb-2 flex items-center justify-between">
                        <?php if($isToday): ?>
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-blue-600 text-sm font-black text-white shadow-[0_0_20px_rgba(37,99,235,0.6)]"><?php echo e($day->day); ?></span>
                        <?php elseif($hasContent): ?>
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-teal-500/20 border border-teal-400/40 text-sm font-black text-teal-300 shadow-[0_0_12px_rgba(20,184,166,0.3)] transition-colors"><?php echo e($day->day); ?></span>
                        <?php else: ?>
                            <span class="text-base font-bold text-slate-500 group-hover:text-white transition-colors"><?php echo e($day->day); ?></span>
                        <?php endif; ?>
                        <?php if($dayTasks->isNotEmpty()): ?>
                            <span class="rounded-full bg-white/10 px-2 py-0.5 text-[10px] font-bold text-slate-400"><?php echo e($dayTasks->count()); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-1.5 mt-3">
                        <?php $__currentLoopData = $dayTasks->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $badge = $task->isOverdue()
                                    ? 'bg-rose-500/10 border border-rose-500/20 text-rose-300'
                                    : 'bg-blue-600/10 border border-blue-500/20 text-blue-300';
                            ?>
                            <a href="<?php echo e(route('tasks.show', $task)); ?>"
                               class="flex items-center gap-2 rounded-xl px-2 py-1.5 text-xs font-medium <?php echo e($badge); ?> backdrop-blur-sm hover:opacity-80 transition-opacity"
                               title="<?php echo e($task->title); ?>">
                                <div class="w-1.5 h-3 rounded-full <?php echo e($task->isOverdue() ? 'bg-rose-400 shadow-[0_0_8px_rgba(251,113,133,0.6)]' : 'bg-blue-400 shadow-[0_0_8px_rgba(96,165,250,0.6)]'); ?> shrink-0"></div>
                                <?php echo e(\Illuminate\Support\Str::limit($task->title, 24)); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php $overflowCount = max(0, $dayTasks->count() - 4); ?>
                        <?php if($overflowCount > 0): ?>
                            <p class="px-1 text-xs text-slate-500">+<?php echo e($overflowCount); ?> more</p>
                        <?php endif; ?>

                        
                        <?php if($holidaysByDate && $holidaysByDate->has($key)): ?>
                            <?php $__currentLoopData = $holidaysByDate->get($key, collect()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $holiday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center gap-2 rounded-xl p-2 bg-orange-500/10 border border-orange-500/20 backdrop-blur-sm">
                                    <div class="w-1.5 h-4 bg-orange-400 rounded-full shadow-[0_0_10px_rgba(251,146,60,0.6)] shrink-0"></div>
                                    <span class="text-xs font-bold text-orange-200 truncate"><?php echo e($holiday->name); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/tasks/calendar.blade.php ENDPATH**/ ?>