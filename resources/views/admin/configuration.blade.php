@extends('layouts.app')

@section('content')
<div class="relative min-h-screen p-6 overflow-hidden">
    <!-- Glassmorphism Background Orbs -->
    <div class="pointer-events-none absolute -top-40 -left-40 h-96 w-96 rounded-full bg-blue-400/20 dark:bg-blue-600/10 blur-[100px]"></div>
    <div class="pointer-events-none absolute top-40 -right-20 h-80 w-80 rounded-full bg-purple-400/20 dark:bg-purple-600/10 blur-[80px]"></div>
    <div class="pointer-events-none absolute bottom-0 left-1/3 h-72 w-72 rounded-full bg-emerald-400/20 dark:bg-emerald-600/10 blur-[90px]"></div>

    <div class="relative z-10 mx-auto max-w-7xl space-y-6">
        
        <!-- Header Section -->
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between rounded-3xl border border-white/40 dark:border-slate-700/40 bg-white/60 dark:bg-slate-800/40 p-8 shadow-xl shadow-slate-200/50 dark:shadow-none backdrop-blur-xl">
            <div>
                <p class="text-sm font-bold uppercase tracking-widest text-blue-600 dark:text-blue-400">Configuration Center</p>
                <h1 class="mt-2 text-4xl font-extrabold text-slate-900 dark:text-white sm:text-5xl">Admin Configuration</h1>
                <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    Manage operational dropdowns, branding content, and broadcast communication settings.
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-700/50 px-5 py-2.5 text-sm font-semibold text-slate-700 dark:text-slate-200 shadow-sm backdrop-blur-md transition-all hover:-translate-y-0.5 hover:bg-white/80 dark:hover:bg-slate-600/80">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Dependency Type & Modal (Hidden logic kept intact) -->
        <div class="rounded-3xl border border-white/40 dark:border-slate-700/40 bg-white/60 dark:bg-slate-800/40 p-6 shadow-xl shadow-slate-200/50 dark:shadow-none backdrop-blur-xl">
            <h2 class="mb-4 text-lg font-bold text-slate-800 dark:text-white">Dependency Type</h2>
            <div class="max-w-xs">
                <select id="dependencyTypeDropdown" class="w-full rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 shadow-sm backdrop-blur-md focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                    <option value="N/A">N/A</option>
                    <option value="CREATE REFERENCE">CREATE REFERENCE</option>
                </select>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-3xl border border-cyan-200/50 dark:border-cyan-700/30 bg-gradient-to-br from-cyan-50/80 to-white/60 dark:from-cyan-900/20 dark:to-slate-800/40 p-6 shadow-lg shadow-cyan-100/50 dark:shadow-none backdrop-blur-xl">
                <p class="text-xs font-bold tracking-widest text-cyan-600 dark:text-cyan-400 uppercase">Company Clients</p>
                <p class="mt-2 text-4xl font-extrabold text-slate-800 dark:text-white">{{ $companies->count() }}</p>
            </div>
            <div class="rounded-3xl border border-emerald-200/50 dark:border-emerald-700/30 bg-gradient-to-br from-emerald-50/80 to-white/60 dark:from-emerald-900/20 dark:to-slate-800/40 p-6 shadow-lg shadow-emerald-100/50 dark:shadow-none backdrop-blur-xl">
                <p class="text-xs font-bold tracking-widest text-emerald-600 dark:text-emerald-400 uppercase">Task Processes</p>
                <p class="mt-2 text-4xl font-extrabold text-slate-800 dark:text-white">{{ $processes->count() }}</p>
            </div>
            <div class="rounded-3xl border border-indigo-200/50 dark:border-indigo-700/30 bg-gradient-to-br from-indigo-50/80 to-white/60 dark:from-indigo-900/20 dark:to-slate-800/40 p-6 shadow-lg shadow-indigo-100/50 dark:shadow-none backdrop-blur-xl">
                <p class="text-xs font-bold tracking-widest text-indigo-600 dark:text-indigo-400 uppercase">Team Labels</p>
                <p class="mt-2 text-4xl font-extrabold text-slate-800 dark:text-white">{{ $teams->count() }}</p>
            </div>
            <div class="rounded-3xl border border-amber-200/50 dark:border-amber-700/30 bg-gradient-to-br from-amber-50/80 to-white/60 dark:from-amber-900/20 dark:to-slate-800/40 p-6 shadow-lg shadow-amber-100/50 dark:shadow-none backdrop-blur-xl">
                <p class="text-xs font-bold tracking-widest text-amber-600 dark:text-amber-400 uppercase">Broadcast</p>
                <p class="mt-2 text-3xl font-extrabold text-slate-800 dark:text-white">Ready</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <!-- Management Lists -->
            <div class="space-y-6 xl:col-span-2">
                <!-- Companies -->
                <div class="rounded-3xl border border-white/40 dark:border-slate-700/40 bg-white/60 dark:bg-slate-800/40 p-6 shadow-xl shadow-slate-200/50 dark:shadow-none backdrop-blur-xl">
                    <h2 class="mb-4 text-lg font-bold text-slate-800 dark:text-white">Company Client Management</h2>
                    <form method="POST" action="{{ route('admin.config.companies.store') }}" class="mb-6 flex gap-3">
                        @csrf
                        <input type="text" name="name" required placeholder="Add new company client..." class="flex-1 rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 shadow-sm backdrop-blur-md focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 placeholder:text-slate-400">
                        <button class="inline-flex items-center justify-center rounded-xl border border-transparent bg-slate-900 dark:bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-slate-800 dark:hover:bg-blue-500" type="submit">Add</button>
                    </form>
                    <ul class="space-y-3">
                        @forelse ($companies as $company)
                            <li class="rounded-2xl border border-white/50 dark:border-slate-600/40 bg-white/40 dark:bg-slate-700/30 p-3 shadow-sm backdrop-blur-md">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                    <form method="POST" action="{{ route('admin.config.companies.update', $company) }}" class="flex flex-1 gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $company->name }}" class="flex-1 rounded-lg border border-white/60 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-3 py-1.5 text-sm text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                        <button class="rounded-lg border border-cyan-300/50 dark:border-cyan-500/30 bg-cyan-50/50 dark:bg-cyan-500/10 px-3 py-1.5 text-xs font-semibold text-cyan-700 dark:text-cyan-300 transition-colors hover:bg-cyan-100 dark:hover:bg-cyan-500/20" type="submit">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.config.companies.delete', $company) }}" onsubmit="return confirm('Delete this client?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-rose-300/50 dark:border-rose-500/30 bg-rose-50/50 dark:bg-rose-500/10 px-3 py-1.5 text-xs font-semibold text-rose-600 dark:text-rose-300 transition-colors hover:bg-rose-100 dark:hover:bg-rose-500/20 w-full sm:w-auto" type="submit">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-sm text-slate-500 dark:text-slate-400">No clients yet.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Task Processes -->
                <div class="rounded-3xl border border-white/40 dark:border-slate-700/40 bg-white/60 dark:bg-slate-800/40 p-6 shadow-xl shadow-slate-200/50 dark:shadow-none backdrop-blur-xl">
                    <h2 class="mb-4 text-lg font-bold text-slate-800 dark:text-white">Task Process Labels</h2>
                    <form method="POST" action="{{ route('admin.config.processes.store') }}" class="mb-6 flex gap-3">
                        @csrf
                        <input type="text" name="name" required placeholder="Add new task process..." class="flex-1 rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 shadow-sm backdrop-blur-md focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 placeholder:text-slate-400">
                        <button class="inline-flex items-center justify-center rounded-xl border border-transparent bg-slate-900 dark:bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-slate-800 dark:hover:bg-blue-500" type="submit">Add</button>
                    </form>
                    <ul class="space-y-3">
                        @forelse ($processes as $process)
                            <li class="rounded-2xl border border-white/50 dark:border-slate-600/40 bg-white/40 dark:bg-slate-700/30 p-3 shadow-sm backdrop-blur-md">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                    <form method="POST" action="{{ route('admin.config.processes.update', $process) }}" class="flex flex-1 gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $process->name }}" class="flex-1 rounded-lg border border-white/60 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-3 py-1.5 text-sm text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                        <button class="rounded-lg border border-cyan-300/50 dark:border-cyan-500/30 bg-cyan-50/50 dark:bg-cyan-500/10 px-3 py-1.5 text-xs font-semibold text-cyan-700 dark:text-cyan-300 transition-colors hover:bg-cyan-100 dark:hover:bg-cyan-500/20" type="submit">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.config.processes.delete', $process) }}" onsubmit="return confirm('Delete this process label?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-rose-300/50 dark:border-rose-500/30 bg-rose-50/50 dark:bg-rose-500/10 px-3 py-1.5 text-xs font-semibold text-rose-600 dark:text-rose-300 transition-colors hover:bg-rose-100 dark:hover:bg-rose-500/20 w-full sm:w-auto" type="submit">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-sm text-slate-500 dark:text-slate-400">No process labels yet.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Team In Charge -->
                <div class="rounded-3xl border border-white/40 dark:border-slate-700/40 bg-white/60 dark:bg-slate-800/40 p-6 shadow-xl shadow-slate-200/50 dark:shadow-none backdrop-blur-xl">
                    <h2 class="mb-4 text-lg font-bold text-slate-800 dark:text-white">Team In Charge Labels</h2>
                    <form method="POST" action="{{ route('admin.config.teams.store') }}" class="mb-6 flex gap-3">
                        @csrf
                        <input type="text" name="name" required placeholder="Add new team label..." class="flex-1 rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 shadow-sm backdrop-blur-md focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 placeholder:text-slate-400">
                        <button class="inline-flex items-center justify-center rounded-xl border border-transparent bg-slate-900 dark:bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-slate-800 dark:hover:bg-blue-500" type="submit">Add</button>
                    </form>
                    <ul class="space-y-3">
                        @forelse ($teams as $team)
                            <li class="rounded-2xl border border-white/50 dark:border-slate-600/40 bg-white/40 dark:bg-slate-700/30 p-3 shadow-sm backdrop-blur-md">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                                    <form method="POST" action="{{ route('admin.config.teams.update', $team) }}" class="flex flex-1 gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="name" value="{{ $team->name }}" class="flex-1 rounded-lg border border-white/60 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-3 py-1.5 text-sm text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                        <button class="rounded-lg border border-cyan-300/50 dark:border-cyan-500/30 bg-cyan-50/50 dark:bg-cyan-500/10 px-3 py-1.5 text-xs font-semibold text-cyan-700 dark:text-cyan-300 transition-colors hover:bg-cyan-100 dark:hover:bg-cyan-500/20" type="submit">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.config.teams.delete', $team) }}" onsubmit="return confirm('Delete this team label?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-rose-300/50 dark:border-rose-500/30 bg-rose-50/50 dark:bg-rose-500/10 px-3 py-1.5 text-xs font-semibold text-rose-600 dark:text-rose-300 transition-colors hover:bg-rose-100 dark:hover:bg-rose-500/20 w-full sm:w-auto" type="submit">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-center text-sm text-slate-500 dark:text-slate-400">No team labels yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Side Forms -->
            <div class="space-y-6">
                <!-- Branding & Logo -->
                <div class="rounded-3xl border border-white/40 dark:border-slate-700/40 bg-white/60 dark:bg-slate-800/40 p-6 shadow-xl shadow-slate-200/50 dark:shadow-none backdrop-blur-xl">
                    <h2 class="mb-4 text-lg font-bold text-slate-800 dark:text-white">Company Logo</h2>
                    <div class="flex flex-col items-center gap-4">
                        @php
                            $logoPath = \App\Modules\Admin\Models\SystemSetting::valueOf('branding_logo_path', null);
                        @endphp
                        <div class="flex h-40 w-full items-center justify-center rounded-2xl border-2 border-dashed border-slate-300/50 dark:border-slate-600/50 bg-white/30 dark:bg-slate-800/30 p-2 overflow-hidden">
                            @if($logoPath)
                                <img src="{{ asset('storage/' . $logoPath) }}" alt="Company Logo" class="max-h-full object-contain drop-shadow-md">
                            @else
                                <span class="text-sm font-medium text-slate-400 dark:text-slate-500">No logo uploaded yet</span>
                            @endif
                        </div>
                        <form action="{{ route('admin.config.logo.update') }}" method="POST" enctype="multipart/form-data" class="w-full">
                            @csrf
                            <label class="mb-2 block text-xs font-medium text-slate-500 dark:text-slate-400">Upload New Logo</label>
                            <input type="file" name="logo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-500/20 dark:file:text-blue-300 dark:hover:file:bg-blue-500/30">
                            <button type="submit" class="mt-4 w-full rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-blue-700">Save Logo</button>
                        </form>
                    </div>
                </div>

                <!-- Branding Settings Form -->
                <div class="rounded-3xl border border-white/40 dark:border-slate-700/40 bg-white/60 dark:bg-slate-800/40 p-6 shadow-xl shadow-slate-200/50 dark:shadow-none backdrop-blur-xl">
                    <h2 class="mb-4 text-lg font-bold text-slate-800 dark:text-white">Branding Settings</h2>
                    <form method="POST" action="{{ route('admin.config.announcement.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Daily Report Recipients</label>
                            <input type="text" name="daily_report_recipients" value="{{ old('daily_report_recipients', $dailyReportRecipients ?? '') }}" placeholder="manager@company.com" class="w-full rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 shadow-sm backdrop-blur-md focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 placeholder:text-slate-400">
                            <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">Receives the 8:00 AM Daily Summary.</p>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Personal Alert Email</label>
                            <input type="email" name="personal_alert_email" value="{{ old('personal_alert_email', $personalAlertEmail ?? '') }}" placeholder="you@email.com" class="w-full rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 shadow-sm backdrop-blur-md focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 placeholder:text-slate-400">
                            <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">Destination for auto deadline alerts.</p>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Alert BCC Email</label>
                            <input type="email" name="deadline_alert_bcc" value="{{ old('deadline_alert_bcc', $deadlineAlertBcc ?? '') }}" placeholder="audit@email.com" class="w-full rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 shadow-sm backdrop-blur-md focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 placeholder:text-slate-400">
                            <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">Archive/audit for system emails.</p>
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">System Announcement</label>
                            <textarea name="announcement" rows="4" class="w-full rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 shadow-sm backdrop-blur-md focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 placeholder:text-slate-400">{{ old('announcement', $announcement) }}</textarea>
                        </div>
                        
                        <button class="w-full rounded-xl bg-slate-900 dark:bg-slate-700 px-4 py-2.5 text-sm font-medium text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-slate-800 dark:hover:bg-slate-600" type="submit">Update Branding & Alerts</button>
                    </form>
                </div>

                <!-- Broadcast -->
                <div class="rounded-3xl border border-amber-200/50 dark:border-amber-700/30 bg-gradient-to-br from-amber-50/80 to-white/60 dark:from-amber-900/20 dark:to-slate-800/40 p-6 shadow-xl shadow-amber-100/50 dark:shadow-none backdrop-blur-xl">
                    <h2 class="mb-2 text-lg font-bold text-amber-900 dark:text-amber-400">Broadcast Email</h2>
                    <p class="mb-4 text-sm text-amber-700 dark:text-amber-300/80">Send announcement email to all users.</p>

                    <form method="POST" action="{{ route('admin.email.broadcast') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="mb-1 block text-sm font-medium text-amber-900 dark:text-amber-400">Subject</label>
                            <input type="text" name="subject" required value="{{ old('subject', 'Task Management Broadcast') }}" class="w-full rounded-xl border border-amber-300/50 dark:border-amber-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 shadow-sm backdrop-blur-md focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50">
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-amber-900 dark:text-amber-400">Message</label>
                            <textarea name="message" rows="4" required class="w-full rounded-xl border border-amber-300/50 dark:border-amber-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 shadow-sm backdrop-blur-md focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/50">{{ old('message', 'This is a broadcast email from Movaflex Task Manager.') }}</textarea>
                        </div>

                        <button class="w-full rounded-xl bg-amber-600 px-4 py-2.5 text-sm font-medium text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-amber-700 dark:bg-amber-600/80 dark:hover:bg-amber-500" type="submit">Send Broadcast Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for CREATE REFERENCE (Moved outside main flex to avoid z-index issues) -->
<div id="createReferenceModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-0">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeReferenceModal()"></div>
    <div class="relative z-10 w-full max-w-lg transform overflow-hidden rounded-3xl border border-white/20 bg-white/80 dark:border-slate-700/50 dark:bg-slate-800/80 p-6 text-left shadow-2xl backdrop-blur-xl transition-all">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">Create Reference Task</h2>
            <button onclick="closeReferenceModal()" class="rounded-full p-2 text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-slate-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
            </button>
        </div>
        <form method="POST" action="#">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Task No.</label>
                    <input type="text" class="mt-1 block w-full rounded-xl border border-slate-300/50 bg-slate-100/50 dark:border-slate-600/50 dark:bg-slate-900/50 px-4 py-2.5 text-sm text-slate-500" value="Auto-generated on save" disabled>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Auto format: PRJ-&lt;Project No&gt;-&lt;Task No&gt; (example: PRJ-009-0123).</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Description</label>
                    <textarea name="description" rows="3" class="mt-1 block w-full rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Project</label>
                        <select name="project_id" class="mt-1 block w-full rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            <option value="">Select project</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Task Process</label>
                        <select name="task_process" class="mt-1 block w-full rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            <option value="">Select task process</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Status (Specific Process)</label>
                    <select name="specific_process" class="mt-1 block w-full rounded-xl border border-white/50 dark:border-slate-600/50 bg-white/50 dark:bg-slate-800/50 px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                        <option value="">Select specific process</option>
                    </select>
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="closeReferenceModal()" class="rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700/50 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 transition-colors hover:bg-slate-50 dark:hover:bg-slate-700">Cancel</button>
                <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2 text-sm font-medium text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-blue-700">Submit Reference</button>
            </div>
        </form>
    </div>
</div>

<script>
function openReferenceModal() {
    const modal = document.getElementById('createReferenceModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeReferenceModal() {
    const modal = document.getElementById('createReferenceModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.getElementById('dependencyTypeDropdown').addEventListener('change', function() {
    if (this.value === 'CREATE REFERENCE') {
        openReferenceModal();
    } else {
        closeReferenceModal();
    }
});
</script>
@endsection
