

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto mt-8">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Create New User</h2>
        <p class="text-slate-500 text-sm mt-1">Register a new company employee and assign their role.</p>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 p-4 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-200 text-sm font-semibold dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-700">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="mb-4 p-4 bg-rose-50 text-rose-600 rounded-xl border border-rose-200 text-sm font-semibold dark:bg-rose-900/20 dark:text-rose-400 dark:border-rose-700">
            Please review the highlighted fields and try again.
            <ul class="mt-2 list-disc pl-5 text-sm">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 shadow-sm">
        <form action="<?php echo e(route('users.store')); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>


            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Full Name</label>
                <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required placeholder="e.g. Juan Dela Cruz"
                    autocomplete="name"
                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 outline-none transition-all">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-500 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>


            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="name@company.com"
                    autocomplete="email"
                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 outline-none transition-all">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-500 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="role" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Company Role</label>
                <select id="role" name="role" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none transition-all appearance-none cursor-pointer">
                    <option value="" disabled <?php echo e(old('role') ? '' : 'selected'); ?>>Select user role...</option>
                    <option value="admin" <?php echo e(old('role') === 'admin' ? 'selected' : ''); ?>>Admin</option>
                    <option value="manager" <?php echo e(old('role') === 'manager' ? 'selected' : ''); ?>>Manager</option>
                    <option value="project_manager" <?php echo e(old('role') === 'project_manager' ? 'selected' : ''); ?>>Project Manager</option>
                    <option value="lead" <?php echo e(old('role') === 'lead' ? 'selected' : ''); ?>>Lead</option>
                    <option value="pre-sale" <?php echo e(old('role') === 'pre-sale' ? 'selected' : ''); ?>>Pre-Sale</option>
                    <option value="sales" <?php echo e(old('role') === 'sales' ? 'selected' : ''); ?>>Sales</option>
                    <option value="technical" <?php echo e(old('role') === 'technical' ? 'selected' : ''); ?>>Technical</option>
                    <option value="admin_support" <?php echo e(old('role') === 'admin_support' ? 'selected' : ''); ?>>Admin Support</option>
                    <option value="member" <?php echo e(old('role') === 'member' ? 'selected' : ''); ?>>Member</option>
                </select>
                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-500 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Password</label>
                    <input id="password" type="password" name="password" required placeholder="Minimum 8 characters"
                        autocomplete="new-password"
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 outline-none transition-all">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-rose-500 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Re-type password"
                        autocomplete="new-password"
                        class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-sm text-gray-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-600 outline-none transition-all">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-colors shadow-sm shadow-blue-200">
                    Create User Account
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/users/create.blade.php ENDPATH**/ ?>