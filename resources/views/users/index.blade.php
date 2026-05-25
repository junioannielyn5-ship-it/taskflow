@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl">
    <div class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">User Management</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage system users, roles, and access.</p>
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="openAddUserModal()" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create New User
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-600 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/30">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 rounded-lg bg-rose-50 p-4 text-sm text-rose-600 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/30">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600 dark:text-slate-300">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase text-slate-500 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Phone No.</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($user->profile_photo_path)
                                        <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Profile" class="h-10 w-10 rounded-full object-cover border border-slate-200">
                                    @else
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-700 font-bold dark:bg-blue-900/30 dark:text-blue-400">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-slate-900 dark:text-white">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->phone_no ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800 dark:bg-slate-700 dark:text-slate-300">
                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button type="button" onclick="openEditUserModal({{ $user }})" class="inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-medium text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                    Edit
                                </button>
                                <button type="button" onclick="openDeleteUserModal({{ $user->id }}, '{{ addslashes($user->name) }}')" class="inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-medium text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-900/30">
                                    Deactivate
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('modals')
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
            
            <form id="user-form" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
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
                @csrf
                @method('DELETE')
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
@endpush

<script>
    function openAddUserModal() {
        const userForm = document.getElementById('user-form');
        const methodOverride = document.getElementById('method-override');
        const modalTitle = document.getElementById('modal-title');
        const userModal = document.getElementById('user-modal');

        userForm.reset();
        methodOverride.innerHTML = '';
        userForm.action = "{{ route('users.store') }}";
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
@endsection
