@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Account Settings</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage your Movaflex profile and security preferences.</p>
    </div>

    {{-- Success / Error Messages --}}
    @if(session('status'))
        <div class="mb-6 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/30 px-4 py-3 text-sm text-emerald-700 dark:text-emerald-300">
            {{ session('status') }}
        </div>
    @endif

    <div class="space-y-6">

        {{-- ═══════ PROFILE INFORMATION ═══════ --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-lg font-bold text-slate-800 dark:text-white">Profile Information</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Update your account's profile information and email address.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('patch')

                    {{-- Profile Photo --}}
                    <div x-data="{ uploading: false }" class="flex items-center gap-4 mb-6">
                        <div class="relative group">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile" class="h-16 w-16 rounded-full object-cover ring-2 ring-indigo-500/30 shadow-md">
                            @else
                                <div class="h-16 w-16 rounded-full bg-indigo-600 text-white flex items-center justify-center text-2xl font-bold shadow-md ring-2 ring-indigo-500/30">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                            <label class="absolute inset-0 flex items-center justify-center rounded-full bg-black/40 opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <input type="file" accept="image/jpeg,image/png,image/webp" class="hidden"
                                       @change="uploading = true; let fd = new FormData(); fd.append('photo', $event.target.files[0]); fd.append('_token', '{{ csrf_token() }}'); fetch('{{ route('profile.photo.update') }}', { method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' } }).then(r => { if(r.ok) location.reload(); else { uploading = false; alert('Upload failed. Max 2MB, jpg/png/webp only.'); }}).catch(() => { uploading = false; alert('Upload failed.'); });">
                            </label>
                            <div x-show="uploading" class="absolute inset-0 flex items-center justify-center rounded-full bg-black/50">
                                <svg class="h-5 w-5 text-white animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            </div>
                            @if(auth()->user()->profile_photo_path)
                                <form action="{{ route('profile.photo.destroy') }}" method="POST" class="absolute -top-2 -right-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Remove profile photo"
                                            class="p-1.5 bg-white dark:bg-slate-700 rounded-full text-rose-500 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-500/10 shadow-md transition-all border border-slate-200 dark:border-slate-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-slate-700 dark:text-slate-200">Profile Photo</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">Hover the photo to change</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none transition-all">
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Company Role</label>
                            <input type="text" value="{{ auth()->user()->roleLabel() }}" disabled class="w-full bg-slate-100 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-500 dark:text-slate-400 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 mt-4">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none transition-all">
                        @error('email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-700 flex items-center justify-end gap-3">
                        @if(session('status') === 'profile-updated')
                            <span class="text-sm text-emerald-600 font-medium">Saved successfully.</span>
                        @endif

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-sm shadow-blue-200">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ═══════ UPDATE PASSWORD ═══════ --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-lg font-bold text-slate-800 dark:text-white">Update Password</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Ensure your account is using a long, random password to stay secure.</p>
            </div>

            <div class="p-6">
                <form action="{{ route('user-password.update') }}" method="POST" class="space-y-4 max-w-md w-full">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Current Password</label>
                        <input type="password" name="current_password" class="max-w-md w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none transition-all">
                        @error('current_password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">New Password</label>
                        <input type="password" name="password" class="max-w-md w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none transition-all">
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-200 mb-2">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="max-w-md w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-600 outline-none transition-all">
                    </div>

                    <div class="mt-6 pt-5 border-t border-slate-100 dark:border-slate-700 flex items-center justify-end gap-3">
                        @if(session('status') === 'password-updated')
                            <span class="text-sm text-emerald-600 font-medium">Saved successfully.</span>
                        @endif

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-sm shadow-blue-200">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
