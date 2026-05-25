

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
        <div class="pointer-events-none absolute -right-12 -top-16 h-48 w-48 rounded-full bg-cyan-200/35 blur-3xl dark:bg-cyan-500/10"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Meetings</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Centralized meeting schedule for project coordination and decision tracking.</p>
            </div>
            <a href="<?php echo e(route('tasks.calendar')); ?>" class="rounded-full border border-cyan-300 dark:border-cyan-500/50 bg-cyan-50 dark:bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-700 dark:text-cyan-400 hover:bg-cyan-100 dark:hover:bg-cyan-500/20 transition">Open Calendar</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="rounded-xl border border-green-200 dark:border-green-500/40 bg-green-50 dark:bg-green-500/10 px-4 py-3 text-green-700 dark:text-green-400 font-medium">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <?php if(auth()->user() && in_array((string) data_get(auth()->user(), 'role', ''), ['manager', 'admin'], true)): ?>
        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm">
            <h2 class="mb-4 text-lg font-bold text-slate-800 dark:text-white">Add Meeting</h2>
            <form method="POST" action="<?php echo e(route('meetings.store')); ?>" class="grid grid-cols-1 gap-3 md:grid-cols-3">
                <?php echo csrf_field(); ?>
                <input type="text" name="title" required placeholder="Meeting title"
                    class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <input type="date" name="meeting_date" required
                    class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <input type="text" name="location" placeholder="Location / Platform"
                    class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <input type="time" name="start_time"
                    class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <input type="time" name="end_time"
                    class="rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                <button type="submit" class="rounded-lg bg-cyan-600 hover:bg-cyan-700 px-4 py-2 text-sm font-bold text-white shadow transition hover:scale-105">Save Meeting</button>
                <textarea name="description" rows="2" placeholder="Description / Agenda"
                    class="md:col-span-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-800 dark:text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400"></textarea>
            </form>
        </div>
    <?php endif; ?>

    
    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
            <thead class="bg-slate-100 dark:bg-slate-700/60 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Time</th>
                    <th class="px-4 py-3">Location</th>
                    <th class="px-4 py-3">Created By</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                <?php $__empty_1 = true; $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $isPast = $meeting->meeting_date && $meeting->meeting_date->isPast();
                        $isToday = $meeting->meeting_date && $meeting->meeting_date->isToday();
                        $rowClass = $isToday
                            ? 'bg-cyan-50 dark:bg-cyan-500/10'
                            : ($idx === 0 ? 'bg-blue-50/40 dark:bg-blue-500/5' : 'hover:bg-slate-50 dark:hover:bg-slate-700/40');
                        $dateClass = $isToday
                            ? 'inline-flex rounded-full bg-cyan-500 text-white px-2 py-0.5 text-xs font-bold'
                            : ($isPast
                                ? 'inline-flex rounded-full bg-slate-200 dark:bg-slate-700 text-slate-500 dark:text-slate-400 px-2 py-0.5 text-xs font-semibold'
                                : 'inline-flex rounded-full bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 text-xs font-bold');
                    ?>
                    <tr class="transition-colors <?php echo e($rowClass); ?>">
                        <td class="px-4 py-3">
                            <span class="<?php echo e($dateClass); ?>"><?php echo e($meeting->meeting_date?->format('M d, Y')); ?></span>
                            <?php if($isToday): ?><span class="ml-1 text-[10px] font-bold text-cyan-600 dark:text-cyan-400">TODAY</span><?php endif; ?>
                        </td>
                        <td class="px-4 py-3 font-bold text-slate-800 dark:text-white"><?php echo e($meeting->title); ?></td>
                        <td class="px-4 py-3">
                            <span class="rounded-md bg-slate-100 dark:bg-slate-700 px-2 py-0.5 text-xs font-semibold text-slate-700 dark:text-slate-200">
                                <?php echo e($meeting->start_time ?: '-'); ?><?php echo e($meeting->end_time ? ' - '.$meeting->end_time : ''); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 font-medium text-slate-700 dark:text-slate-300"><?php echo e($meeting->location ?: '-'); ?></td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded-full bg-purple-100 dark:bg-purple-500/20 px-2 py-0.5 text-xs font-semibold text-purple-700 dark:text-purple-300">
                                <?php echo e($meeting->creator?->name ?: '-'); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <?php if(auth()->user() && in_array((string) data_get(auth()->user(), 'role', ''), ['manager', 'admin'], true)): ?>
                                <form method="POST" action="<?php echo e(route('meetings.destroy', $meeting)); ?>" class="inline" onsubmit="return confirm('Delete this meeting?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="rounded-lg border border-red-300 dark:border-red-500/40 bg-red-50 dark:bg-red-500/10 px-3 py-1 text-xs font-bold text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-500/20 transition">Delete</button>
                                </form>
                            <?php else: ?>
                                <span class="text-slate-400">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">No meetings scheduled.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\meetings\index.blade.php ENDPATH**/ ?>