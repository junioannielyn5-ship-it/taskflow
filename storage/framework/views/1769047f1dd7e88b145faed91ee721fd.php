

<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-3xl space-y-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Create Project</h1>
        <p class="text-slate-500 text-sm mt-1">Set up a new project space and align your team on scope and delivery.</p>
    </div>

    <form method="POST" action="<?php echo e(route('projects.store')); ?>" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 shadow-sm space-y-6">
        <?php echo csrf_field(); ?>
        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300" for="company_name">Company Name</label>
            <input type="text" name="company_name" id="company_name" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 outline-none transition-all" value="<?php echo e(old('company_name')); ?>" placeholder="e.g. Movaflex Designs Unlimited Inc.">
            <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300" for="name">Project Name</label>
            <input type="text" name="name" id="name" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 outline-none transition-all" value="<?php echo e(old('name')); ?>" required autocomplete="off">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300" for="project_owner">Project Owner</label>
            <select name="project_owner" id="project_owner" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none transition-all appearance-none cursor-pointer" required>
                <option value="LS" <?php echo e(old('project_owner') === 'LS' ? 'selected' : ''); ?>>LS - Lawrence Solee</option>
                <option value="NR" <?php echo e(old('project_owner') === 'NR' ? 'selected' : ''); ?>>NR - Norman Reyes</option>
                <option value="PB" <?php echo e(old('project_owner') === 'PB' ? 'selected' : ''); ?>>PB - Philip Borromeo</option>
                <option value="VA" <?php echo e(old('project_owner') === 'VA' ? 'selected' : ''); ?>>VA - Vera Andino</option>
                <option value="EC" <?php echo e(old('project_owner') === 'EC' ? 'selected' : ''); ?>>EC - Edcel Ching</option>
            </select>
            <p class="mt-1 text-xs text-slate-500">Sales owner mapping: LS = Lawrence Solee, NR = Norman Reyes.</p>
            <?php $__errorArgs = ['project_owner'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300" for="status">Project Status</label>
            <select name="status" id="status" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none transition-all appearance-none cursor-pointer" required>
                <option value="pending_request" <?php echo e(old('status', 'pending_request') === 'pending_request' ? 'selected' : ''); ?>>Pending Request (Sales)</option>
                <option value="ongoing" <?php echo e(old('status') === 'ongoing' ? 'selected' : ''); ?>>Implementation (Technical)</option>
            </select>
            <p class="mt-1 text-xs text-slate-500">Pending Request = Sales team, Ongoing = Technical team.</p>
            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300" for="description">Description</label>
            <textarea name="description" id="description" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 outline-none transition-all" rows="3"><?php echo e(old('description')); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-1 block"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-2">
            <a href="<?php echo e(route('projects.index')); ?>" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">Cancel</a>
            <button type="submit" class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-6 py-2.5 text-sm font-bold text-white transition-colors shadow-sm shadow-emerald-200">Create</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/projects/create.blade.php ENDPATH**/ ?>