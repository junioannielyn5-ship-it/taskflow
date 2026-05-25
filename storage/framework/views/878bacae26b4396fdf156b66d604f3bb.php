

<?php $__env->startSection('content'); ?>
<div class="space-y-4">
    
    <div class="relative overflow-hidden rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full bg-cyan-200/35 blur-3xl dark:bg-cyan-500/10"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Meetings</h1>
                <p class="text-xs text-slate-550 dark:text-slate-400 mt-0.5">Centralized meeting schedule for project coordination and decision tracking.</p>
            </div>
            <a href="<?php echo e(route('tasks.calendar')); ?>" class="inline-flex items-center gap-1.5 rounded-lg border border-cyan-300 dark:border-cyan-800/80 bg-cyan-50/50 dark:bg-cyan-950/40 px-3 py-1.5 text-xs font-bold text-cyan-750 dark:text-cyan-400 shadow-sm hover:bg-cyan-100/80 dark:hover:bg-cyan-900/50 transition-all duration-200 hover:-translate-y-0.5">Open Calendar</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="rounded-lg bg-emerald-50 p-4 text-sm text-emerald-600 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/30">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <?php if(auth()->user() && in_array((string) data_get(auth()->user(), 'role', ''), ['manager', 'admin'], true)): ?>
        <div class="rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
            <h2 class="mb-3 text-sm font-bold text-slate-900 dark:text-white">Add Meeting</h2>
            <form method="POST" action="<?php echo e(route('meetings.store')); ?>" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                <?php echo csrf_field(); ?>
                <input type="text" name="title" required placeholder="Meeting title"
                    class="rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white placeholder:text-slate-400">
                <input type="date" name="meeting_date" required
                    class="rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white">
                <input type="text" name="location" placeholder="Location / Platform"
                    class="rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white placeholder:text-slate-400">
                <input type="time" name="start_time"
                    class="rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white">
                <input type="time" name="end_time"
                    class="rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white">
                <button type="submit" class="rounded-lg bg-cyan-650 hover:bg-cyan-700 py-1.5 px-3.5 text-xs font-bold text-white shadow-sm transition-all duration-200 hover:-translate-y-0.5">Save Meeting</button>
                <textarea name="description" rows="2" placeholder="Description / Agenda"
                    class="md:col-span-3 rounded-lg border border-slate-300 bg-slate-50/70 py-1.5 px-3 text-xs focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 dark:border-slate-700 dark:bg-slate-900/50 dark:text-white placeholder:text-slate-400"></textarea>
            </form>
        </div>
    <?php endif; ?>

    
    <div class="rounded-xl border border-slate-200/40 bg-white/90 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 overflow-hidden">
        <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
            <thead class="border-b border-slate-200/40 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-400">
                <tr>
                    <th class="px-3 py-2">Date</th>
                    <th class="px-3 py-2">Title</th>
                    <th class="px-3 py-2">Time</th>
                    <th class="px-3 py-2">Location</th>
                    <th class="px-3 py-2">Created By</th>
                    <th class="px-3 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-850">
                <?php $__empty_1 = true; $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $isPast = $meeting->meeting_date && $meeting->meeting_date->isPast();
                        $isToday = $meeting->meeting_date && $meeting->meeting_date->isToday();
                        $rowClass = $isToday
                            ? 'bg-cyan-50/60 dark:bg-cyan-950/20'
                            : ($idx === 0 ? 'bg-blue-50/20 dark:bg-blue-950/10' : 'hover:bg-slate-50 dark:hover:bg-slate-850/50 transition-colors');
                        $dateClass = $isToday
                            ? 'inline-flex rounded-full bg-cyan-500 text-white px-2 py-0.5 text-[10px] font-bold'
                            : ($isPast
                                ? 'inline-flex rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2 py-0.5 text-[10px] font-semibold border border-slate-300 dark:border-slate-800'
                                : 'inline-flex rounded-full bg-emerald-105 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-400 px-2 py-0.5 text-[10px] font-bold border border-emerald-200 dark:border-emerald-800/30');
                    ?>
                    <tr class="transition-colors <?php echo e($rowClass); ?>">
                        <td class="px-3 py-2.5 text-xs">
                            <span class="<?php echo e($dateClass); ?>"><?php echo e($meeting->meeting_date?->format('M d, Y')); ?></span>
                            <?php if($isToday): ?><span class="ml-1 text-[10px] font-bold text-cyan-600 dark:text-cyan-400">TODAY</span><?php endif; ?>
                        </td>
                        <td class="px-3 py-2.5 text-xs font-bold text-slate-900 dark:text-white"><?php echo e($meeting->title); ?></td>
                        <td class="px-3 py-2.5 text-xs">
                            <span class="rounded-md bg-slate-100 dark:bg-slate-800 px-2 py-0.5 text-xs font-semibold text-slate-750 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                <?php echo e($meeting->start_time ?: '-'); ?><?php echo e($meeting->end_time ? ' - '.$meeting->end_time : ''); ?>

                            </span>
                        </td>
                        <td class="px-3 py-2.5 text-xs font-medium text-slate-700 dark:text-slate-300"><?php echo e($meeting->location ?: '-'); ?></td>
                        <td class="px-3 py-2.5 text-xs">
                            <span class="inline-flex items-center gap-1 rounded-full bg-purple-100 dark:bg-purple-950/40 px-2 py-0.5 text-[10px] font-bold text-purple-800 dark:text-purple-400 border border-purple-200 dark:border-purple-800/30">
                                <?php echo e($meeting->creator?->name ?: '-'); ?>

                            </span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-2.5 text-right text-xs">
                            <?php if(auth()->user() && in_array((string) data_get(auth()->user(), 'role', ''), ['manager', 'admin'], true)): ?>
                                <form method="POST" action="<?php echo e(route('meetings.destroy', $meeting)); ?>" class="inline" onsubmit="return confirm('Delete this meeting?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center gap-1 rounded border border-red-100 dark:border-red-900/50 bg-red-50/50 dark:bg-red-950/40 px-2 py-1 text-[10px] font-bold text-red-650 dark:text-red-400 hover:bg-red-100/80 dark:hover:bg-red-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Delete</button>
                                </form>
                            <?php else: ?>
                                <span class="text-slate-400">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="px-3 py-6 text-center text-xs text-slate-500 dark:text-slate-400">No meetings scheduled.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="border-t border-slate-200 dark:border-slate-850 p-3 sm:p-4 flex flex-col items-center justify-between gap-3 sm:flex-row bg-slate-50/50 dark:bg-slate-900/50 rounded-b-xl backdrop-blur-md">
            <form method="GET" action="<?php echo e(url()->current()); ?>" class="flex items-center gap-1.5 text-xs text-slate-550 dark:text-slate-400">
                <?php $__currentLoopData = request()->except('per_page', 'page'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_array($value)): ?>
                        <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="<?php echo e($key); ?>[]" value="<?php echo e($v); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <span>Show</span>
                <input type="number" name="per_page" value="<?php echo e($meetings->perPage()); ?>" min="1" max="100" 
                       class="w-12 rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1 px-1.5 text-center text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all duration-150"
                       onchange="this.form.submit()">
                <span>entries</span>
            </form>
            <?php if($meetings->hasPages()): ?>
                <div>
                    <?php echo e($meetings->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/meetings/index.blade.php ENDPATH**/ ?>