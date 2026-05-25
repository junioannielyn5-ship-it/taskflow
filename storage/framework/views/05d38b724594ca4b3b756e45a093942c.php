<?php $__env->startSection('content'); ?>
<div class="max-w-xl mx-auto mt-8 bg-white dark:bg-slate-800 p-6 rounded shadow">
    <h2 class="text-lg font-bold mb-4 text-slate-800 dark:text-slate-100">Edit Project</h2>
    <form method="POST" action="<?php echo e(route('projects.update', $project)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-4">
            <label class="block text-slate-700 dark:text-slate-300">Project Name</label>
            <input type="text" name="name" class="mt-1 block w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" value="<?php echo e(old('name', $project->name)); ?>" required>
        </div>
        <div class="mb-4">
            <label class="block text-slate-700 dark:text-slate-300">Company Name</label>
            <input type="text" name="company_name" class="mt-1 block w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" value="<?php echo e(old('company_name', $project->company_name)); ?>">
        </div>
        <div class="mb-4">
            <label class="block text-slate-700 dark:text-slate-300">Project Owner</label>
            <input type="text" name="project_owner" class="mt-1 block w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" value="<?php echo e(old('project_owner', $project->project_owner)); ?>">
        </div>
        <div class="mb-4">
            <label class="block text-slate-700 dark:text-slate-300">Description</label>
            <textarea name="description" class="mt-1 block w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"><?php echo e(old('description', $project->description)); ?></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-slate-700 dark:text-slate-300">Status</label>
            <input type="text" name="status" class="mt-1 block w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-3 py-2 text-sm text-slate-900 dark:text-slate-100 placeholder:text-slate-400 dark:placeholder:text-slate-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500" value="<?php echo e(old('status', $project->status)); ?>">
        </div>
        <div class="flex justify-between">
            <a href="<?php echo e(route('projects.index')); ?>" class="rounded border border-slate-300 dark:border-slate-600 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50">Cancel</a>
            <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white font-semibold hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views\projects\edit.blade.php ENDPATH**/ ?>