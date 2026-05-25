<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-slate-800 rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4">Edit Task</h2>

    <?php if($errors->any()): ?>
        <div class="mb-4 rounded border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('tasks.update', $task->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-3">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" value="<?php echo e($task->title); ?>" class="w-full border rounded px-3 py-2 bg-white dark:bg-slate-800 text-gray-900 dark:bg-slate-800 dark:text-white" required>
        </div>
        <div class="mb-3">
            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
            <select name="priority" id="priority" class="w-full border rounded px-3 py-2 bg-white dark:bg-slate-800 text-gray-900 dark:bg-slate-800 dark:text-white">
                <option value="urgent" <?php echo e($task->priority == 'urgent' ? 'selected' : ''); ?>>Urgent</option>
                <option value="high" <?php echo e($task->priority == 'high' ? 'selected' : ''); ?>>High</option>
                <option value="medium" <?php echo e($task->priority == 'medium' ? 'selected' : ''); ?>>Medium</option>
                <option value="low" <?php echo e($task->priority == 'low' ? 'selected' : ''); ?>>Low</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
            <input type="date" name="due_date" id="due_date" value="<?php echo e($task->due_date ? $task->due_date->format('Y-m-d') : ''); ?>" class="w-full border rounded px-3 py-2 bg-white dark:bg-slate-800 text-gray-900 dark:bg-slate-800 dark:text-white">
        </div>
        <div class="mb-3">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2 bg-white dark:bg-slate-800 text-gray-900 dark:bg-slate-800 dark:text-white">
                <?php $__currentLoopData = ($statusOptions ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($statusValue); ?>" <?php echo e(old('status', $task->status) == $statusValue ? 'selected' : ''); ?>>
                        <?php echo e(($statusLabels[$statusValue] ?? str_replace('_', ' ', ucwords($statusValue, '_')))); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Only the current and next valid workflow statuses are selectable.</p>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Changes</button>
        <a href="<?php echo e(route('tasks.list')); ?>" class="ml-3 text-blue-600">Cancel</a>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\tasks\edit.blade.php ENDPATH**/ ?>