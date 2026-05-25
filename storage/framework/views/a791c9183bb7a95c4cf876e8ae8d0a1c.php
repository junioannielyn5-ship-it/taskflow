<div class="container mx-auto py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2">Quick Actions</h3>
            <a href="<?php echo e(route('tasks.create')); ?>" class="bg-blue-500 text-white px-4 py-2 rounded mb-2">Create Task</a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-project')): ?>
                <a href="<?php echo e(route('projects.create') ?? '#'); ?>" class="bg-green-500 text-white px-4 py-2 rounded mb-2">Create Project</a>
            <?php endif; ?>
            <a href="<?php echo e(route('reports.index') ?? '#'); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded">View Reports</a>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2">Upcoming Deadlines</h3>
            <ul class="w-full">
                <?php ($upcomingList = collect($upcomingTasks ?? [])); ?>
                <?php $__currentLoopData = $upcomingList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="mb-2 flex justify-between items-center">
                        <span><?php echo e($task->title); ?></span>
                        <span class="text-xs <?php echo e($task->due_date && $task->due_date->isPast() ? 'text-red-600 font-semibold' : 'text-gray-500'); ?>">
                            <?php echo e($task->due_date ? $task->due_date->format('m-d-Y') : '-'); ?>

                            <?php if(isset($task->status) && $task->status === 'for_review'): ?>
                                <span class="ml-2 px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 text-[10px] font-semibold">For Review</span>
                            <?php endif; ?>
                        </span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <?php if($upcomingList->isEmpty()): ?>
                    <li class="mb-2 flex justify-between items-center">
                        <span>Sample Task for Review</span>
                        <span class="text-xs text-orange-700">
                            <?php echo e(now()->addDays(2)->format('m-d-Y')); ?>

                            <span class="ml-2 px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 text-[10px] font-semibold">For Review</span>
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2">Recent Activity</h3>
            <ul class="w-full">
                <?php ($recentList = collect($recentActivity ?? [])); ?>
                <?php $__currentLoopData = $recentList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="mb-2 text-sm"><?php echo e($log->getDescription()); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($recentList->isEmpty()): ?>
                    <li class="text-gray-400">No recent activity</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\widgets.blade.php ENDPATH**/ ?>