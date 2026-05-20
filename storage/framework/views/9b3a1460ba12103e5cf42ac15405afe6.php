

<?php $__env->startSection('content'); ?>
<div class="relative space-y-6">
    <div class="pointer-events-none absolute right-0 top-0 h-64 w-64 translate-x-1/3 -translate-y-1/3 rounded-full bg-blue-100/40 blur-3xl dark:hidden"></div>
    <div class="pointer-events-none absolute bottom-0 left-20 h-52 w-52 rounded-full bg-slate-200/30 blur-3xl dark:hidden"></div>

    <div class="relative overflow-hidden rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-md dark:shadow-none" style="border-left: 4px solid #2563eb;">
        <div class="pointer-events-none absolute -right-14 -top-12 h-44 w-44 rounded-full bg-blue-100/40 dark:bg-blue-500/15 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Email Alerts</h1>
                <p class="text-sm text-slate-600 dark:text-slate-300">View and manage your read and unread notification feed.</p>
            </div>
            <form method="POST" action="<?php echo e(route('notifications.read-all')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600">Mark all as read</button>
            </form>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 rounded border border-emerald-300/35 bg-emerald-500/10 px-4 py-3 text-emerald-200">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-md dark:shadow-none">
        <?php if($notifications->isEmpty()): ?>
            <p class="py-6 text-center text-sm text-slate-500 dark:text-slate-400">No notifications yet.</p>
        <?php else: ?>
            <ul class="space-y-2">
                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $message = $notification->data['message'] ?? $notification->data['body'] ?? '-';
                        $link = $notification->data['link'] ?? route('dashboard');
                        $isUnread = is_null($notification->read_at);
                        $isLatest = $i === 0;
                    ?>
                    <li class="flex items-start justify-between gap-4 rounded-xl border px-3 py-4
                        <?php echo e($isLatest
                            ? 'border-blue-400 dark:border-blue-500 bg-blue-50 dark:bg-blue-500/15 ring-2 ring-blue-300/50 dark:ring-blue-500/30'
                            : ($isUnread ? 'border-slate-200 dark:border-slate-700 bg-blue-50 dark:bg-blue-500/10' : 'border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/50')); ?>">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <?php if($isLatest): ?>
                                    <span class="inline-flex items-center rounded-full bg-blue-500 px-2 py-0.5 text-[10px] font-bold text-white uppercase tracking-wide">Latest</span>
                                <?php endif; ?>
                                <a href="<?php echo e($link); ?>" class="text-sm <?php echo e($isUnread || $isLatest ? 'font-semibold text-slate-800 dark:text-slate-100' : 'text-slate-600 dark:text-slate-300'); ?> hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                                    <?php echo e($message); ?>

                                </a>
                            </div>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400"><?php echo e($notification->created_at?->diffForHumans()); ?></p>
                        </div>

                        <?php if($isUnread): ?>
                            <form method="POST" action="<?php echo e(route('notifications.read', $notification->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="rounded-md border border-blue-300 dark:border-blue-400/40 bg-blue-50 dark:bg-blue-500/10 px-2.5 py-1 text-xs font-medium text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-500/20">Mark read</button>
                            </form>
                        <?php else: ?>
                            <span class="rounded-md bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-medium text-slate-500 dark:text-slate-400">Read</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

            <div class="mt-4">
                <?php echo e($notifications->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/notifications/index.blade.php ENDPATH**/ ?>