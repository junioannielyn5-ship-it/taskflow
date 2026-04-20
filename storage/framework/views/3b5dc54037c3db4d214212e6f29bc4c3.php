

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <?php if(session('success')): ?>
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-slate-800 dark:text-white">Projects</h2>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-project')): ?>
            <a href="<?php echo e(route('projects.create')); ?>" class="rounded-lg bg-emerald-600 px-4 py-2 text-white font-semibold shadow hover:bg-emerald-700 transition">Create Project</a>
        <?php endif; ?>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
        <?php $__empty_1 = true; $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="project-card flex flex-col h-full rounded-3xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm hover:shadow-md hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300">

                <div class="mb-4">
                    <h4 class="text-xs uppercase font-semibold text-slate-500 dark:text-slate-400 tracking-wider">
                        <?php echo e($project->company_name ?: '-'); ?>

                    </h4>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-1">
                        <?php echo e($project->name); ?>

                    </h3>
                </div>

                <div class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm">

                    <div class="col-span-2">
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Project Owner:</span>
                        <span class="font-medium text-slate-900 dark:text-slate-100 ml-1"><?php echo e($project->project_owner ?: '-'); ?></span>
                    </div>

                    <div class="col-span-2">
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Description:</span>
                        <span class="font-medium text-slate-600 dark:text-slate-400 ml-1"><?php echo e(Str::limit($project->description, 80)); ?></span>
                    </div>

                    <div class="col-span-1">
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Status:</span>
                        <?php
                            $statusLabel = ucwords(str_replace('_', ' ', $project->status ?? 'pending_request'));
                            $statusClass = match($project->status) {
                                'ongoing' => 'bg-blue-100 text-blue-700',
                                'pending_request' => 'bg-amber-100 text-amber-700',
                                default => 'bg-slate-100 text-slate-700',
                            };
                        ?>
                        <span class="px-3 py-1 text-xs font-bold rounded-full <?php echo e($statusClass); ?> ml-1">
                            <?php echo e($statusLabel); ?>

                        </span>
                    </div>

                    <div class="col-span-1">
                        <span class="font-semibold text-slate-700 dark:text-slate-300">Your Role:</span>
                        <?php
                            $roleLabel = $project->member_role ?? 'N/A';
                            $roleClass = match($roleLabel) {
                                'admin' => 'bg-purple-100 text-purple-700',
                                'lead' => 'bg-green-100 text-green-700',
                                'member' => 'bg-blue-100 text-blue-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        ?>
                        <span class="px-3 py-1 text-xs font-bold rounded-full <?php echo e($roleClass); ?> ml-1">
                            <?php echo e(ucwords(str_replace('_', ' ', $roleLabel))); ?>

                        </span>
                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-700 flex flex-wrap gap-2">
                    <a href="<?php echo e(route('projects.show', $project)); ?>" class="rounded-md border border-cyan-200 px-3 py-1.5 text-xs font-semibold text-cyan-700 hover:bg-cyan-50 transition">View</a>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-task')): ?>
                        <a href="<?php echo e(route('tasks.create', ['project_id' => $project->id])); ?>" class="rounded-md border border-emerald-200 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50 transition">Create Task</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $project)): ?>
                        <a href="<?php echo e(route('projects.edit', $project)); ?>" class="rounded-md border border-yellow-200 px-3 py-1.5 text-xs font-semibold text-yellow-700 hover:bg-yellow-50 transition">Edit</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $project)): ?>
                        <form action="<?php echo e(route('projects.destroy', $project)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this project?')" class="rounded-md border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50 transition">Delete</button>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full rounded-2xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-6 py-12 text-center">
                <p class="text-sm text-slate-500 dark:text-slate-400">No projects found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/projects/index.blade.php ENDPATH**/ ?>