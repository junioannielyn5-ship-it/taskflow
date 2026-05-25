<?php $__env->startSection('content'); ?>
<div class="mx-auto max-w-7xl">
    <div class="mb-4 flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">User <span class="text-blue-600 dark:text-blue-400">Management</span></h1>
            <p class="text-xs text-slate-550 dark:text-slate-400 mt-0.5">Manage system users, roles, and access.</p>
        </div>
        <div class="flex gap-1.5">
            <button type="button" onclick="openAddUserModal()" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3.5 py-1.5 text-xs font-bold text-white shadow-sm hover:bg-blue-700 transition-all duration-200 hover:-translate-y-0.5">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create New User
            </button>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-600 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/30">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
        <div class="mb-4 rounded-lg bg-rose-50 p-4 text-sm text-rose-600 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/30">
            <ul class="list-disc pl-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="rounded-xl border border-slate-200/40 bg-white/90 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                <thead class="border-b border-slate-200/40 bg-slate-50/70 text-[10px] font-bold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-900/50 dark:text-slate-400">
                    <tr>
                        <th class="px-3 py-2">Name</th>
                        <th class="px-3 py-2">Email</th>
                        <th class="px-3 py-2">Phone No.</th>
                        <th class="px-3 py-2">Role</th>
                        <th class="px-3 py-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-850">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-850/50 transition-colors">
                            <td class="whitespace-nowrap px-3 py-2.5 font-semibold text-slate-900 dark:text-white text-xs">
                                <div class="flex items-center gap-2">
                                    <?php if($user->profile_photo_path): ?>
                                        <img src="<?php echo e(Storage::url($user->profile_photo_path)); ?>" alt="Profile" class="h-7 w-7 rounded-full object-cover border border-slate-200 dark:border-slate-700">
                                    <?php else: ?>
                                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-100 text-blue-700 text-xs font-bold dark:bg-blue-900/30 dark:text-blue-400">
                                            <?php echo e(substr($user->name, 0, 1)); ?>

                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="font-semibold text-slate-900 dark:text-white text-xs"><?php echo e($user->name); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-2.5 text-xs"><?php echo e($user->email); ?></td>
                            <td class="px-3 py-2.5 text-xs"><?php echo e($user->phone_no ?? 'N/A'); ?></td>
                            <td class="px-3 py-2.5 text-xs">
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-800 dark:bg-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>

                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-right text-xs">
                                <div class="inline-flex gap-1">
                                    <button type="button" onclick="openEditUserModal(<?php echo e($user); ?>)" class="inline-flex items-center gap-1 rounded border border-blue-100 dark:border-blue-900/50 bg-blue-50/50 dark:bg-blue-950/40 px-2 py-1 text-[10px] font-bold text-blue-600 dark:text-blue-400 hover:bg-blue-100/80 dark:hover:bg-blue-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Edit</button>
                                    <button type="button" onclick="openDeleteUserModal(<?php echo e($user->id); ?>, '<?php echo e(addslashes($user->name)); ?>')" class="inline-flex items-center gap-1 rounded border border-red-100 dark:border-red-900/50 bg-red-50/50 dark:bg-red-950/40 px-2 py-1 text-[10px] font-bold text-red-650 dark:text-red-400 hover:bg-red-100/80 dark:hover:bg-red-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Deactivate</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-3 py-6 text-center text-xs text-slate-500">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 dark:border-slate-850 p-3 sm:p-4 flex flex-col items-center justify-between gap-3 sm:flex-row bg-slate-50/50 dark:bg-slate-900/50 rounded-b-xl backdrop-blur-md">
            <form method="GET" action="<?php echo e(url()->current()); ?>" class="flex items-center gap-1.5 text-xs text-slate-550 dark:text-slate-400">
                <?php $__currentLoopData = request()->except('per_page', 'page'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(is_array($value)): ?>
                        <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="<?php echo e($key); ?>[]" value="<?php echo e($v); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <span>Show</span>
                <input type="number" name="per_page" value="<?php echo e($users->perPage()); ?>" min="1" max="100" 
                       class="w-12 rounded-lg border border-slate-300 dark:border-slate-700 bg-white/70 dark:bg-slate-900/50 py-1 px-1.5 text-center text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-150"
                       onchange="this.form.submit()">
                <span>entries</span>
            </form>
            <?php if($users->hasPages()): ?>
                <div>
                    <?php echo e($users->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('modals'); ?>
<!-- Modal for Create/Edit -->
<div id="user-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
    <div class="flex min-h-full items-start justify-center p-4 py-10">
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
            <div class="mb-4 flex items-center justify-between">
                <h3 id="modal-title" class="text-lg font-bold text-slate-900 dark:text-white">Add / Edit User</h3>
                <button type="button" onclick="closeUserModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form id="user-form" method="POST" action="<?php echo e(route('users.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div id="method-override"></div>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">First Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="first_name" id="input_first_name" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Last Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="last_name" id="input_last_name" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Middle Name (Optional)</label>
                            <input type="text" name="middle_name" id="input_middle_name" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Suffix (Optional)</label>
                            <input type="text" name="suffix" id="input_suffix" placeholder="e.g. Jr., Sr." class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Phone Number <span class="text-rose-500">*</span></label>
                            <input type="text" name="phone_no" id="input_phone_no" placeholder="09xxxxxxxxx" maxlength="11" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Role <span class="text-rose-500">*</span></label>
                            <select name="role" id="input_role" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                <option value="">-- Select Role --</option>
                                <option value="admin">Admin</option>
                                <option value="admin_support">Admin Support</option>
                                <option value="lead">Lead</option>
                                <option value="manager">Manager</option>
                                <option value="project_manager">Project Manager</option>
                                <option value="member">Member</option>
                                <option value="pre-sale">Pre-Sale</option>
                                <option value="sales">Sales</option>
                                <option value="technical">Technical</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Email <span class="text-rose-500">*</span></label>
                        <input type="email" name="email" id="input_email" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Password <span class="text-rose-500" id="password-req">*</span></label>
                            <input type="password" name="password" id="input_password" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Confirm Password <span class="text-rose-500" id="password-conf-req">*</span></label>
                            <input type="password" name="password_confirmation" id="input_password_confirmation" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400" id="password-help">Leave blank if you don't want to change the password when editing.</p>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Profile Picture</label>
                        <input type="file" name="profile_picture" id="input_profile_picture" accept="image/*" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                </div>
                <div class="mt-6 flex justify-end gap-3 border-t border-slate-200 pt-4 dark:border-slate-700">
                    <button type="button" onclick="closeUserModal()" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Delete -->
<div id="delete-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/50 backdrop-blur-sm">
    <div class="flex min-h-full items-start justify-center p-4 py-10">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-bold text-rose-600 dark:text-rose-400" id="delete-modal-title">Deactivate User</h3>
                <button type="button" onclick="closeDeleteModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <p class="mb-6 text-sm text-slate-600 dark:text-slate-300">
                Are you sure you want to deactivate/delete this user? All of their data will be permanently removed. This action cannot be undone.
            </p>

            <form id="delete-form" method="POST" action="">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="flex justify-end gap-3 border-t border-slate-200 pt-4 dark:border-slate-700">
                    <button type="button" onclick="closeDeleteModal()" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-medium text-white hover:bg-rose-700">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopPush(); ?>

<script>
    function openAddUserModal() {
        const userForm = document.getElementById('user-form');
        const methodOverride = document.getElementById('method-override');
        const modalTitle = document.getElementById('modal-title');
        const userModal = document.getElementById('user-modal');

        userForm.reset();
        methodOverride.innerHTML = '';
        userForm.action = "<?php echo e(route('users.store')); ?>";
        modalTitle.innerText = 'Create New User';
        document.getElementById('input_password').required = true;
        document.getElementById('input_password_confirmation').required = true;
        document.getElementById('password-req').classList.remove('hidden');
        document.getElementById('password-conf-req').classList.remove('hidden');
        document.getElementById('password-help').classList.add('hidden');
        userModal.classList.remove('hidden');
    }

    function openEditUserModal(user) {
        const userForm = document.getElementById('user-form');
        const methodOverride = document.getElementById('method-override');
        const modalTitle = document.getElementById('modal-title');
        const userModal = document.getElementById('user-modal');

        userForm.reset();
        methodOverride.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        userForm.action = `/users/${user.id}`;
        modalTitle.innerText = 'Edit User';
        
        document.getElementById('input_first_name').value = user.first_name || '';
        document.getElementById('input_last_name').value = user.last_name || '';
        document.getElementById('input_middle_name').value = user.middle_name || '';
        document.getElementById('input_suffix').value = user.suffix || '';
        document.getElementById('input_phone_no').value = user.phone_no || '';
        document.getElementById('input_email').value = user.email || '';
        document.getElementById('input_role').value = user.role || '';
        
        document.getElementById('input_password').required = false;
        document.getElementById('input_password_confirmation').required = false;
        document.getElementById('password-req').classList.add('hidden');
        document.getElementById('password-conf-req').classList.add('hidden');
        document.getElementById('password-help').classList.remove('hidden');

        userModal.classList.remove('hidden');
    }

    function closeUserModal() {
        document.getElementById('user-modal').classList.add('hidden');
    }

    function openDeleteUserModal(id, name) {
        const deleteForm = document.getElementById('delete-form');
        const deleteModalTitle = document.getElementById('delete-modal-title');
        const deleteModal = document.getElementById('delete-modal');

        deleteForm.action = `/users/${id}`;
        deleteModalTitle.innerText = `Deactivate ${name}`;
        deleteModal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Local.Administrator\Herd\taskmanagement\resources\views/users/index.blade.php ENDPATH**/ ?>