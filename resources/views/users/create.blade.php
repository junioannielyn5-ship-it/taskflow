@extends('layouts.app')

@section('content')
<div class="relative max-w-3xl mx-auto mt-8">
    <div class="pointer-events-none absolute right-0 top-0 h-56 w-56 translate-x-1/3 -translate-y-1/3 rounded-full bg-blue-100/40 blur-3xl dark:hidden"></div>
    <div class="pointer-events-none absolute bottom-0 left-10 h-44 w-44 rounded-full bg-slate-200/30 blur-3xl dark:hidden"></div>

    <div class="mb-6 rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-5 py-4 shadow-md dark:shadow-none" style="border-left: 4px solid #2563eb;">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Create New User</h2>
        <p class="text-slate-600 dark:text-slate-300 text-sm mt-1">Register a new company employee and assign their role.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-200 text-sm font-semibold dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 p-4 bg-rose-50 text-rose-600 rounded-xl border border-rose-200 text-sm font-semibold dark:bg-rose-900/20 dark:text-rose-400 dark:border-rose-700">
            Please review the highlighted fields and try again.
            <ul class="mt-2 list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="relative overflow-hidden border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-md dark:shadow-none">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
            @csrf


            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Juan Dela Cruz"
                    autocomplete="name"
                    class="w-full bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>


            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="name@company.com"
                    autocomplete="email"
                    class="w-full bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                @error('email') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Company Role</label>
                <select id="role" name="role" required class="w-full bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 outline-none transition-all appearance-none cursor-pointer">
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select user role...</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="project_manager" {{ old('role') === 'project_manager' ? 'selected' : '' }}>Project Manager</option>
                    <option value="lead" {{ old('role') === 'lead' ? 'selected' : '' }}>Lead</option>
                    <option value="pre-sale" {{ old('role') === 'pre-sale' ? 'selected' : '' }}>Pre-Sale</option>
                    <option value="sales" {{ old('role') === 'sales' ? 'selected' : '' }}>Sales</option>
                    <option value="technical" {{ old('role') === 'technical' ? 'selected' : '' }}>Technical</option>
                    <option value="admin_support" {{ old('role') === 'admin_support' ? 'selected' : '' }}>Admin Support</option>
                    <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                </select>
                @error('role') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Password</label>
                    <input id="password" type="password" name="password" required placeholder="Minimum 8 characters"
                        autocomplete="new-password"
                        class="w-full bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    @error('password') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Re-type password"
                        autocomplete="new-password"
                        class="w-full bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-3 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 dark:border-slate-700 flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-sm hover:-translate-y-0.5">
                    Create User Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
