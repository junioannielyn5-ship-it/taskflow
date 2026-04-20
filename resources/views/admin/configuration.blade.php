@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden py-4">
    <div class="pointer-events-none absolute -top-24 -left-24 h-56 w-56 rounded-full bg-cyan-300/25 blur-3xl"></div>
    <div class="pointer-events-none absolute right-0 bottom-0 h-72 w-72 rounded-full bg-emerald-300/20 blur-3xl"></div>

    <div class="mv-shell relative space-y-6 px-0">
            <div class="mv-card p-6 md:p-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="mv-badge">Configuration Center</p>
                        <h1 class="mv-heading mt-6 text-7xl font-extrabold text-slate-900">Admin Configuration</h1>
                        <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600">
                            Manage operational dropdowns, branding content, and broadcast communication settings.
                        </p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Back to Dashboard</a>
                </div>
            </div>

            <!-- Dependency Type Section -->
            <div class="mv-card p-6 md:p-8 mt-4">
                <h2 class="mb-3 text-lg font-semibold text-slate-900">Dependency Type</h2>
                <div class="mb-4">
                    <label class="block text-gray-700">Dependency Type</label>
                    <select id="dependencyTypeDropdown" class="form-input mt-1 block w-full">
                        <option value="N/A">N/A</option>
                        <option value="CREATE REFERENCE">CREATE REFERENCE</option>
                    </select>
                </div>
            </div>

            <!-- Modal for CREATE REFERENCE -->
            <div id="createReferenceModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative">
                    <button onclick="closeReferenceModal()" class="absolute top-2 right-2 text-slate-500 hover:text-slate-900">&times;</button>
                    <h2 class="text-xl font-bold mb-4">Create Reference Task</h2>
                    <form method="POST" action="#">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700">Task No.</label>
                            <input type="text" class="form-input mt-1 block w-full bg-gray-100" value="Auto-generated on save" disabled>
                            <p class="mt-1 text-xs text-gray-500">Auto format: PRJ-&lt;Project No&gt;-&lt;Task No&gt; (example: PRJ-009-0123).</p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Description</label>
                            <textarea name="description" class="form-input mt-1 block w-full" rows="3"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Project</label>
                            <select name="project_id" class="form-input mt-1 block w-full">
                                <option value="">Select project</option>
                                <!-- Dynamic options here -->
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Task Process (Main Category)</label>
                            <select name="task_process" class="form-input mt-1 block w-full">
                                <option value="">Select task process</option>
                                <!-- Dynamic options here -->
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Status (Specific Process)</label>
                            <select name="specific_process" class="form-input mt-1 block w-full">
                                <option value="">Select specific process</option>
                            </select>
                        </div>
                        <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Submit</button>
                    </form>
                </div>
            </div>

            <script>
            function openReferenceModal() {
                document.getElementById('createReferenceModal').classList.remove('hidden');
            }
            function closeReferenceModal() {
                document.getElementById('createReferenceModal').classList.add('hidden');
            }
            document.getElementById('dependencyTypeDropdown').addEventListener('change', function() {
                if (this.value === 'CREATE REFERENCE') {
                    openReferenceModal();
                } else {
                    closeReferenceModal();
                }
            });
            </script>

        <div class="grid gap-4 md:grid-cols-4">
            <div class="mv-card p-4">
                <p class="text-xs font-semibold tracking-wide text-cyan-700 uppercase">Company Clients</p>
                <p class="mt-1 text-2xl font-bold text-cyan-900">{{ $companies->count() }}</p>
            </div>
            <div class="mv-card p-4">
                <p class="text-xs font-semibold tracking-wide text-emerald-700 uppercase">Task Processes</p>
                <p class="mt-1 text-2xl font-bold text-emerald-900">{{ $processes->count() }}</p>
            </div>
            <div class="mv-card p-4">
                <p class="text-xs font-semibold tracking-wide text-indigo-700 uppercase">Team Labels</p>
                <p class="mt-1 text-2xl font-bold text-indigo-900">{{ $teams->count() }}</p>
            </div>
            <div class="mv-card p-4">
                <p class="text-xs font-semibold tracking-wide text-amber-700 uppercase">Broadcast</p>
                <p class="mt-1 text-2xl font-bold text-amber-900">Ready</p>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                Please review the form input and try again.
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="mv-card p-6">
                <h2 class="mb-3 text-lg font-semibold text-slate-900">Company Client Management</h2>
                <form method="POST" action="{{ route('admin.config.companies.store') }}" class="mb-4 flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Add company client" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800" type="submit">Add</button>
                </form>
                <ul class="space-y-2">
                    @forelse ($companies as $company)
                        <li class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                <form method="POST" action="{{ route('admin.config.companies.update', $company) }}" class="flex w-full gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $company->name }}" class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm">
                                    <button class="rounded-lg border border-cyan-200 px-2 py-1 text-xs text-cyan-700 hover:bg-cyan-50" type="submit">Save</button>
                                </form>
                                <form method="POST" action="{{ route('admin.config.companies.delete', $company) }}" onsubmit="return confirm('Delete this client?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-rose-200 px-2 py-1 text-xs text-rose-600 hover:bg-rose-50" type="submit">Delete</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">No clients yet.</li>
                    @endforelse
                </ul>
            </div>

            <div class="mv-card p-6">
                <h2 class="mb-3 text-lg font-semibold text-slate-900">Task Process Labels</h2>
                <form method="POST" action="{{ route('admin.config.processes.store') }}" class="mb-4 flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Add task process" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800" type="submit">Add</button>
                </form>
                <ul class="space-y-2">
                    @forelse ($processes as $process)
                        <li class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                <form method="POST" action="{{ route('admin.config.processes.update', $process) }}" class="flex w-full gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $process->name }}" class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm">
                                    <button class="rounded-lg border border-cyan-200 px-2 py-1 text-xs text-cyan-700 hover:bg-cyan-50" type="submit">Save</button>
                                </form>
                                <form method="POST" action="{{ route('admin.config.processes.delete', $process) }}" onsubmit="return confirm('Delete this process label?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-rose-200 px-2 py-1 text-xs text-rose-600 hover:bg-rose-50" type="submit">Delete</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">No process labels yet.</li>
                    @endforelse
                </ul>
            </div>

            <div class="mv-card p-6">
                <h2 class="mb-3 text-lg font-semibold text-slate-900">Team In Charge Labels</h2>
                <form method="POST" action="{{ route('admin.config.teams.store') }}" class="mb-4 flex gap-2">
                    @csrf
                    <input type="text" name="name" required placeholder="Add team label" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800" type="submit">Add</button>
                </form>
                <ul class="space-y-2">
                    @forelse ($teams as $team)
                        <li class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm">
                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                                <form method="POST" action="{{ route('admin.config.teams.update', $team) }}" class="flex w-full gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $team->name }}" class="w-full rounded-lg border border-slate-300 px-2 py-1 text-sm">
                                    <button class="rounded-lg border border-cyan-200 px-2 py-1 text-xs text-cyan-700 hover:bg-cyan-50" type="submit">Save</button>
                                </form>
                                <form method="POST" action="{{ route('admin.config.teams.delete', $team) }}" onsubmit="return confirm('Delete this team label?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-rose-200 px-2 py-1 text-xs text-rose-600 hover:bg-rose-50" type="submit">Delete</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">No team labels yet.</li>
                    @endforelse
                </ul>
            </div>

            <div class="mv-card p-6">
                <h2 class="mb-3 text-lg font-semibold text-slate-900">Branding & Alert Settings</h2>
                <form method="POST" action="{{ route('admin.config.announcement.update') }}">
                    @csrf
                    @method('PUT')

                    <label class="mb-1 block text-sm font-medium text-slate-700">Daily Report Recipients</label>
                    <input
                        type="text"
                        name="daily_report_recipients"
                        value="{{ old('daily_report_recipients', $dailyReportRecipients ?? '') }}"
                        placeholder="manager@company.com, teamlead@company.com"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm"
                    >
                    <p class="mt-1 text-xs text-slate-500">Comma-separated emails that receive the 8:00 AM Daily Execution Summary.</p>

                    <label class="mt-3 mb-1 block text-sm font-medium text-slate-700">Personal Alert Email (Auto Deadline Alerts)</label>
                    <input
                        type="email"
                        name="personal_alert_email"
                        value="{{ old('personal_alert_email', $personalAlertEmail ?? '') }}"
                        placeholder="yourpersonal@email.com"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm"
                    >
                    <p class="mt-1 text-xs text-slate-500">Auto-send destination for warning, critical, reminder, and overdue alerts.</p>

                    <label class="mt-3 mb-1 block text-sm font-medium text-slate-700">Deadline Alert BCC (Archive Mailbox)</label>
                    <input
                        type="email"
                        name="deadline_alert_bcc"
                        value="{{ old('deadline_alert_bcc', $deadlineAlertBcc ?? '') }}"
                        placeholder="audit@email.com"
                        class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm"
                    >
                    <p class="mt-1 text-xs text-slate-500">Optional BCC for all deadline alert emails (for audit/archive).</p>

                    <label class="mt-3 mb-1 block text-sm font-medium text-slate-700">System Announcement</label>
                    <textarea name="announcement" rows="6" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">{{ old('announcement', $announcement) }}</textarea>
                    <button class="mt-3 rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800" type="submit">Update Announcement</button>
                </form>
            </div>

            <div id="broadcast-email" class="rounded-2xl border border-amber-200 bg-amber-50 p-6 shadow-sm xl:col-span-2">
                <h2 class="mb-2 text-lg font-semibold text-amber-900">Broadcast Email</h2>
                <p class="mb-3 text-sm text-amber-700">Send announcement email to all users.</p>

                @if (session('status'))
                    <p class="mb-2 rounded border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm text-emerald-700">{{ session('status') }}</p>
                @endif

                @error('broadcast_email')
                    <p class="mb-2 rounded border border-rose-200 bg-rose-50 px-3 py-2 text-sm text-rose-700">{{ $message }}</p>
                @enderror

                <form method="POST" action="{{ route('admin.email.broadcast') }}">
                    @csrf
                    <label for="broadcast-email-subject" class="mb-1 block text-sm font-medium text-amber-900">Email Subject</label>
                    <input
                        id="broadcast-email-subject"
                        type="text"
                        name="subject"
                        required
                        value="{{ old('subject', 'Task Management Broadcast') }}"
                        class="w-full rounded-xl border border-amber-300 px-3 py-2 text-sm"
                    >

                    <label for="broadcast-email-message" class="mt-3 mb-1 block text-sm font-medium text-amber-900">Email Message</label>
                    <textarea
                        id="broadcast-email-message"
                        name="message"
                        rows="6"
                        required
                        class="w-full rounded-xl border border-amber-300 px-3 py-2 text-sm"
                    >{{ old('message', 'This is a broadcast email from Movaflex Task Manager.') }}</textarea>

                    <button class="mt-3 rounded-xl bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700" type="submit">Send Announcement Email</button>
                 </form>
             </div>
         </div>
     </div>

    <div class="mt-8 mb-6">
                        <p class="text-lg font-semibold text-slate-700 mb-2">Company Logo</p>
                        @php
    $logoPath = \App\Modules\Admin\Models\SystemSetting::valueOf('branding_logo_path', null);
@endphp
                        @if($logoPath)
                            <img src="{{ asset('storage/' . $logoPath) }}" alt="Company Logo" class="h-64 mb-4 rounded shadow-md">
                        @else
                            <p class="text-sm text-slate-500 mb-4">No logo uploaded yet.</p>
                        @endif
                        <form action="{{ route('admin.config.logo.update') }}" method="POST" enctype="multipart/form-data" class="space-y-2">
                            @csrf
                            <input type="file" name="logo" accept="image/*" class="block w-full border border-slate-300 rounded px-3 py-2">
                            <button type="submit" class="mt-2 rounded bg-blue-700 px-4 py-2 text-white font-semibold hover:bg-blue-800">Upload Logo</button>
                        </form>
                    </div>
 </div>
 @endsection
