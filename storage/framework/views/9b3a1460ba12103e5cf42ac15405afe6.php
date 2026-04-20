

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm">
        <div class="pointer-events-none absolute -right-14 -top-12 h-44 w-44 rounded-full bg-rose-200/35 dark:bg-rose-500/10 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Email Alerts</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">View and manage your read and unread notification feed.</p>
            </div>
            <form method="POST" action="<?php echo e(route('notifications.read-all')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="rounded-lg border border-slate-200 dark:border-slate-600 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700">Mark all as read</button>
            </form>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 rounded border border-green-200 dark:border-green-700 bg-green-50 dark:bg-green-900/30 px-4 py-3 text-green-700 dark:text-green-300">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-4 shadow-sm">
        <?php if($notifications->isEmpty()): ?>
            <p class="py-6 text-center text-sm text-slate-500 dark:text-slate-400">No notifications yet.</p>
        <?php else: ?>
            <ul class="space-y-2">
                <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $message = $notification->data['message'] ?? $notification->data['body'] ?? '-';
                        $link = $notification->data['link'] ?? route('dashboard');
                        $isUnread = is_null($notification->read_at);
                    ?>
                    <li class="flex items-start justify-between gap-4 rounded-xl border border-slate-100 dark:border-slate-700 px-3 py-4 <?php echo e($isUnread ? 'bg-cyan-50/60 dark:bg-cyan-900/20' : 'bg-white dark:bg-slate-800/50'); ?>">
                        <div class="min-w-0 flex-1">
                            <a href="<?php echo e($link); ?>" class="text-sm <?php echo e($isUnread ? 'font-semibold text-slate-800 dark:text-slate-100' : 'text-slate-700 dark:text-slate-300'); ?> hover:text-blue-600 dark:hover:text-blue-400 hover:underline">
                                <?php echo e($message); ?>

                            </a>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400"><?php echo e($notification->created_at?->diffForHumans()); ?></p>
                        </div>

                        <?php if($isUnread): ?>
                            <form method="POST" action="<?php echo e(route('notifications.read', $notification->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="rounded-md border border-cyan-200 dark:border-cyan-700 px-2.5 py-1 text-xs font-medium text-cyan-700 dark:text-cyan-300 hover:bg-cyan-50 dark:hover:bg-cyan-900/30">Mark read</button>
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