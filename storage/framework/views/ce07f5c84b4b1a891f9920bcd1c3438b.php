

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="pointer-events-none absolute -left-16 -top-16 h-52 w-52 rounded-full bg-emerald-200/35 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <?php
                    $statusLabel = ucwords(str_replace('_', ' ', $project->status ?? 'pending_request'));
                    $teamLabel = ($project->status ?? 'pending_request') === 'ongoing' ? 'Technical' : 'Sales';
                ?>
                <h1 class="text-2xl font-bold text-slate-800"><?php echo e($project->name); ?></h1>
                <p class="text-sm text-slate-500">Created by <?php echo e($project->creator?->name ?? 'Unknown'); ?> · <?php echo e($statusLabel); ?> (<?php echo e($teamLabel); ?>)</p>
                <p class="text-sm text-slate-500">Company Name: <?php echo e($project->company_name ?: '-'); ?></p>
                <p class="text-sm text-slate-500">Project Owner: <?php echo e($project->project_owner ?: '-'); ?></p>
            </div>
            <a href="<?php echo e(route('projects.index')); ?>" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Back to Projects</a>
        </div>
    </div>

    <?php if($project->description): ?>
        <div class="rounded-2xl border border-slate-200 bg-white p-4 text-sm text-slate-700 shadow-sm">
            <?php echo e($project->description); ?>

        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">Project Members</h2>
            <?php if($project->members->isEmpty()): ?>
                <p class="text-sm text-slate-500">No members assigned.</p>
            <?php else: ?>
                <ul class="divide-y divide-slate-100">
                    <?php $__currentLoopData = $project->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="flex items-center justify-between py-2 text-sm">
                            <span class="text-slate-700"><?php echo e($member->user?->name ?? 'Unknown User'); ?></span>
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600"><?php echo e(ucfirst($member->role ?? 'member')); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="mb-3 text-lg font-semibold text-slate-800">Recent Tasks</h2>
            <?php if($project->tasks->isEmpty()): ?>
                <p class="text-sm text-slate-500">No tasks yet for this project.</p>
            <?php else: ?>
                <ul class="divide-y divide-slate-100">
                    <?php $__currentLoopData = $project->tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="py-2 text-sm">
                            <a href="<?php echo e(route('tasks.show', $task)); ?>" class="font-medium text-blue-600 hover:underline"><?php echo e($task->title); ?></a>
                            <p class="text-xs text-slate-500"><?php echo e(ucfirst(str_replace('_', ' ', $task->status ?? 'todo'))); ?> · <?php echo e(strtoupper($task->priority ?? 'medium')); ?></p>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/projects/show.blade.php ENDPATH**/ ?>