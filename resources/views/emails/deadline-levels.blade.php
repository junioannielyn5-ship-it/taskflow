@extends('layouts.app')

@section('content')
    <div class="relative w-full">
        <div class="pointer-events-none absolute right-0 top-0 h-64 w-64 translate-x-1/3 -translate-y-1/3 rounded-full bg-blue-100/40 blur-3xl dark:hidden"></div>
        <div class="pointer-events-none absolute bottom-0 left-20 h-52 w-52 rounded-full bg-slate-200/30 blur-3xl dark:hidden"></div>
        <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
            <div>
                <div class="inline-flex rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-5 py-3 shadow-md" style="border-left: 4px solid #2563eb;">
                    <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Email Alerts Overview</h1>
                </div>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-300">Task deadline levels shown when clicking Email: Warning, Critical, Reminder, Overdue.</p>
                <p class="mt-1 text-xs text-slate-400 dark:text-slate-400">As of {{ $today->format('M d, Y') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('email.shortcut', ['send_test' => 1, 'to' => auth()->user()?->email]) }}" class="rounded-lg bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm">Send Test Email</a>
                <a href="#overdue-reminder-status" class="rounded-lg border border-emerald-300/50 dark:border-emerald-400/35 bg-white dark:bg-white/5 px-4 py-2 text-sm font-medium text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-500/10">Open Overdue Status</a>
                <a href="{{ route('dashboard') }}" class="rounded-lg border border-slate-300 dark:border-white/20 bg-white dark:bg-white/5 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-white/10">Back to Dashboard</a>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                {{ $errors->first() }}
            </div>
        @endif

        <details id="overdue-reminder-status" open class="mb-4 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-md">
            <summary class="cursor-pointer list-none text-sm font-semibold text-emerald-900 dark:text-emerald-300">
                <span class="inline-flex items-center gap-2">Overdue Reminder Status</span>
            </summary>
            <p class="mt-2 text-xs text-emerald-700 dark:text-emerald-300">Latest automatic overdue email reminder run details.</p>
            <div class="mt-2 grid grid-cols-1 gap-2 text-xs text-slate-600 dark:text-slate-300 md:grid-cols-2">
                <p><span class="font-semibold text-slate-800 dark:text-slate-100">Last Run:</span> {{ !empty($overdueReminderLastRunAt) ? \Carbon\Carbon::parse($overdueReminderLastRunAt)->format('M d, Y h:i A') : 'Not yet recorded' }}</p>
                <p><span class="font-semibold text-slate-800 dark:text-slate-100">Emails Sent:</span> {{ $overdueReminderLastSentCount ?? 0 }}</p>
            </div>
            <div class="mt-3 flex flex-wrap gap-2 text-xs">
                <a href="#mail-header-preview" class="rounded border border-emerald-300 dark:border-emerald-400/40 bg-emerald-50 dark:bg-emerald-500/10 px-3 py-1.5 font-medium text-emerald-700 dark:text-emerald-300 hover:bg-emerald-100 dark:hover:bg-emerald-500/20">View Email Details</a>
                @if(isset($toPreview) && $toPreview->isNotEmpty())
                    <a href="mailto:{{ $toPreview->first() }}" class="rounded border border-sky-300 dark:border-sky-400/40 bg-sky-50 dark:bg-sky-500/10 px-3 py-1.5 font-medium text-sky-700 dark:text-sky-300 hover:bg-sky-100 dark:hover:bg-sky-500/20">Open Email App</a>
                @endif
            </div>
        </details>

        <div id="email-overview-tabs" class="mb-4 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-3 shadow-md">
            <div class="flex flex-wrap gap-2" role="tablist" aria-label="Email Overview Tabs">
                <button
                    type="button"
                    class="overview-tab-btn rounded-full border border-blue-300 dark:border-blue-400/40 bg-blue-100 dark:bg-blue-500/20 px-3 py-1.5 text-xs font-semibold text-blue-700 dark:text-blue-200"
                    data-overview-target="overview-panel-recipients"
                    role="tab"
                    aria-selected="true"
                >
                    Recipients and Directory
                </button>
                <button
                    type="button"
                    class="overview-tab-btn rounded-full border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700 px-3 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600"
                    data-overview-target="overview-panel-deadlines"
                    role="tab"
                    aria-selected="false"
                >
                    Deadline Levels
                </button>
            </div>
        </div>

        <div id="overview-panel-recipients" class="overview-tab-panel" role="tabpanel">

        <div id="mail-header-preview" class="mb-4 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 scroll-mt-24 shadow-md">
            @php
                $senderName = null;
                $senderEmail = null;
                if (!empty($fromPreview) && preg_match('/^(.*?)\s*<([^>]+)>$/', $fromPreview, $senderMatch)) {
                    $senderName = trim($senderMatch[1], ' \"');
                    $senderEmail = trim($senderMatch[2]);
                } elseif (!empty($fromPreview) && filter_var($fromPreview, FILTER_VALIDATE_EMAIL)) {
                    $senderEmail = trim($fromPreview);
                }
            @endphp

            <h2 class="text-sm font-semibold text-sky-700 dark:text-sky-300">Mail Header Preview (Presentation View)</h2>
            <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">This shows the exact sender and recipients used by automatic deadline alert emails.</p>

            <div class="mt-3 space-y-2">
                <div class="rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-xs text-slate-600 dark:text-slate-300">
                    <p class="font-semibold text-slate-800 dark:text-slate-100">From (Sender)</p>
                    <p class="mt-0.5 text-slate-500 dark:text-slate-400">This is the email account that sends the alert.</p>
                    <div class="mt-1">
                        @if($senderEmail)
                            @if(!empty($senderName))
                                <span class="font-medium text-slate-800">{{ $senderName }}</span>
                                <span class="text-slate-500">&lt;</span><a href="mailto:{{ $senderEmail }}" class="text-blue-700 underline hover:text-blue-900">{{ $senderEmail }}</a><span class="text-slate-500">&gt;</span>
                            @else
                                <a href="mailto:{{ $senderEmail }}" class="text-blue-700 underline hover:text-blue-900">{{ $senderEmail }}</a>
                            @endif
                        @else
                            <span>N/A</span>
                        @endif
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-xs text-slate-600 dark:text-slate-300">
                    <p class="font-semibold text-slate-800 dark:text-slate-100">To (Primary Recipient)</p>
                    <p class="mt-0.5 text-slate-500 dark:text-slate-400">Main receiver(s) of the alert.</p>
                    @if(isset($toPreview) && $toPreview->isNotEmpty())
                        <div class="mt-1 inline-flex flex-wrap gap-1.5">
                            @foreach($toPreview as $toEmail)
                                <a href="mailto:{{ $toEmail }}" class="rounded-full border border-blue-200 bg-blue-50 px-2 py-0.5 text-blue-700 hover:bg-blue-100">{{ $toEmail }}</a>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-1">N/A</p>
                    @endif
                </div>

                <div class="rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-xs text-slate-600 dark:text-slate-300">
                    <p class="font-semibold text-slate-800 dark:text-slate-100">CC (Visible Copy)</p>
                    <p class="mt-0.5 text-slate-500 dark:text-slate-400">Additional recipient(s) visible to everyone in the email thread.</p>
                    @if(isset($ccPreview) && $ccPreview->isNotEmpty())
                        <div class="mt-1 inline-flex flex-wrap gap-1.5">
                            @foreach($ccPreview as $ccEmail)
                                <a href="mailto:{{ $ccEmail }}" class="rounded-full border border-violet-200 bg-violet-50 px-2 py-0.5 text-violet-700 hover:bg-violet-100">{{ $ccEmail }}</a>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-1">N/A</p>
                    @endif
                </div>

                <div class="rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-xs text-slate-600 dark:text-slate-300">
                    <p class="font-semibold text-slate-800 dark:text-slate-100">BCC (Hidden Copy)</p>
                    <p class="mt-0.5 text-slate-500 dark:text-slate-400">Recipient(s) that receive a copy but are hidden from other recipients.</p>
                    <div class="mt-1">
                        @if(!empty($bccPreview))
                            <a href="mailto:{{ $bccPreview }}" class="rounded-full border border-rose-200 bg-rose-50 px-2 py-0.5 text-rose-700 hover:bg-rose-100">{{ $bccPreview }}</a>
                        @else
                            <span>N/A</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-md">
            <h2 class="text-sm font-semibold text-teal-700 dark:text-teal-300">Department Email Directory</h2>
            <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">Official contacts per team: Pre-Sales, Sales, Technical, Admin Support.</p>

            @if(isset($departmentEmailDirectory) && collect($departmentEmailDirectory)->isNotEmpty())
                <div id="department-email-tabs" class="mt-3">
                    <div class="mb-3 flex flex-wrap gap-2" role="tablist" aria-label="Department Email Tabs">
                        @foreach($departmentEmailDirectory as $index => $group)
                            <button
                                type="button"
                                class="department-tab-btn rounded-full border px-3 py-1.5 text-xs font-semibold transition {{ $index === 0 ? 'border-blue-300 dark:border-blue-400/40 bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-200' : 'border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600' }}"
                                data-tab-target="department-panel-{{ $index }}"
                                role="tab"
                                aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                            >
                                {{ $group['department'] }}
                            </button>
                        @endforeach
                    </div>

                    @foreach($departmentEmailDirectory as $index => $group)
                        <div
                            id="department-panel-{{ $index }}"
                            class="department-tab-panel rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 p-3 text-xs text-slate-600 dark:text-slate-300 {{ $index === 0 ? '' : 'hidden' }}"
                            role="tabpanel"
                        >
                            <p class="font-semibold text-slate-900">{{ $group['department'] }}</p>
                            <div class="mt-2 space-y-1.5">
                                @foreach(($group['members'] ?? []) as $member)
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span class="font-medium text-slate-800">{{ $member['name'] }}</span>
                                        @if(!empty($member['email']))
                                            <span class="text-slate-500">-</span>
                                            <a href="mailto:{{ $member['email'] }}" class="rounded-full border border-teal-200 bg-teal-100 px-2 py-0.5 text-teal-800 hover:bg-teal-200">{{ $member['email'] }}</a>
                                        @else
                                            <span class="text-slate-400">- No email set</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-2 text-xs text-slate-500">No department email directory available yet.</p>
            @endif
        </div>

        </div>

        <div id="overview-panel-deadlines" class="overview-tab-panel hidden" role="tabpanel">

        <div class="mb-4 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-md">
            <h2 class="text-sm font-semibold text-indigo-700 dark:text-indigo-300">Example Email Alerts (Preview)</h2>
            <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">This is the sample format of automatic email alerts so you can see what to expect per level.</p>
            <div class="mt-3 grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="rounded-lg border border-amber-200 bg-white px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-amber-700">WARNING</p>
                    <p>Task "Prepare Monthly Report" is due in 7 days.</p>
                </div>
                <div class="rounded-lg border border-orange-200 bg-white px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-orange-700">CRITICAL</p>
                    <p>Task "Client Proposal Final" is due in 3 days.</p>
                </div>
                <div class="rounded-lg border border-blue-200 bg-white px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-blue-700">REMINDER</p>
                    <p>Task "Submit Q1 KPIs" is due today.</p>
                </div>
                <div class="rounded-lg border border-rose-200 bg-white px-3 py-2 text-xs text-slate-700">
                    <p class="font-semibold text-rose-700">OVERDUE</p>
                    <p>Task "Vendor Contract Review" has passed its deadline.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
            <a href="#warning-section" class="rounded-xl border border-amber-300 dark:border-amber-500/35 bg-white dark:bg-slate-800 p-4 transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">Warning</p>
                <p class="mt-2 text-2xl font-bold text-amber-800">{{ $warningTasks->count() }}</p>
                <p class="mt-1 text-xs text-amber-700">Due in 7 days</p>
            </a>
            <a href="#critical-section" class="rounded-xl border border-orange-300 dark:border-orange-500/35 bg-white dark:bg-slate-800 p-4 transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-wide text-orange-700">Critical</p>
                <p class="mt-2 text-2xl font-bold text-orange-800">{{ $criticalTasks->count() }}</p>
                <p class="mt-1 text-xs text-orange-700">Due in 3 days</p>
            </a>
            <a href="#reminder-section" class="rounded-xl border border-blue-300 dark:border-blue-500/35 bg-white dark:bg-slate-800 p-4 transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-wide text-blue-700">Reminder</p>
                <p class="mt-2 text-2xl font-bold text-blue-800">{{ $reminderTasks->count() }}</p>
                <p class="mt-1 text-xs text-blue-700">Due today</p>
            </a>
            <a href="#overdue-section" class="rounded-xl border border-rose-300 dark:border-rose-500/35 bg-white dark:bg-slate-800 p-4 transition hover:-translate-y-0.5 hover:shadow-md">
                <p class="text-xs font-semibold uppercase tracking-wide text-rose-700">Overdue</p>
                <p class="mt-2 text-2xl font-bold text-rose-800">{{ $overdueTasks->count() }}</p>
                <p class="mt-1 text-xs text-rose-700">Past deadline</p>
            </a>
        </div>

        @php
            $sections = [
                'warning' => ['label' => 'Warning (7 Days)', 'tasks' => $warningTasks, 'badge' => 'bg-amber-100 text-amber-700', 'row' => 'bg-amber-50/50'],
                'critical' => ['label' => 'Critical (3 Days)', 'tasks' => $criticalTasks, 'badge' => 'bg-orange-100 text-orange-700', 'row' => 'bg-orange-50/50'],
                'reminder' => ['label' => 'Reminder (Today)', 'tasks' => $reminderTasks, 'badge' => 'bg-blue-100 text-blue-700', 'row' => 'bg-blue-50/50'],
                'overdue' => ['label' => 'Overdue', 'tasks' => $overdueTasks, 'badge' => 'bg-rose-100 text-rose-700', 'row' => 'bg-rose-50/50'],
            ];
        @endphp

        <div class="mt-6 grid grid-cols-1 gap-4 xl:grid-cols-2">
            @foreach($sections as $key => $config)
                <div id="{{ $key }}-section" class="rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-md scroll-mt-24">
                    <div class="mb-3 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $config['label'] }}</h2>
                        <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $config['badge'] }}">{{ $config['tasks']->count() }} task(s)</span>
                    </div>

                    @if($config['tasks']->isEmpty())
                        <p class="rounded-lg border border-dashed border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-5 text-center text-sm text-slate-500 dark:text-slate-300">No tasks in this level.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($config['tasks']->take(8) as $task)
                                <a href="{{ route('tasks.show', $task) }}" class="block rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-600 {{ $config['row'] }}">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-medium text-slate-800 dark:text-slate-100">{{ $task->title }}</p>
                                        <span class="text-xs text-slate-500 dark:text-slate-400">{{ optional($task->due_date)->format('M d, Y') }}</span>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Project: {{ $task->project->name ?? 'N/A' }}</p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const overviewTabs = document.getElementById('email-overview-tabs');
            if (overviewTabs) {
                const overviewButtons = overviewTabs.querySelectorAll('.overview-tab-btn');
                const overviewPanels = document.querySelectorAll('.overview-tab-panel');

                overviewButtons.forEach((button) => {
                    button.addEventListener('click', function () {
                        const targetId = button.getAttribute('data-overview-target');

                        overviewButtons.forEach((btn) => {
                            btn.classList.remove('border-blue-300', 'dark:border-blue-400/40', 'bg-blue-100', 'dark:bg-blue-500/20', 'text-blue-700', 'dark:text-blue-200');
                            btn.classList.add('border-slate-300', 'dark:border-slate-600', 'bg-slate-100', 'dark:bg-slate-700', 'text-slate-600', 'dark:text-slate-300');
                            btn.setAttribute('aria-selected', 'false');
                        });

                        overviewPanels.forEach((panel) => {
                            panel.classList.add('hidden');
                        });

                        button.classList.remove('border-slate-300', 'dark:border-slate-600', 'bg-slate-100', 'dark:bg-slate-700', 'text-slate-600', 'dark:text-slate-300');
                        button.classList.add('border-blue-300', 'dark:border-blue-400/40', 'bg-blue-100', 'dark:bg-blue-500/20', 'text-blue-700', 'dark:text-blue-200');
                        button.setAttribute('aria-selected', 'true');

                        const targetPanel = document.getElementById(targetId);
                        if (targetPanel) {
                            targetPanel.classList.remove('hidden');
                        }
                    });
                });
            }

            const departmentTabs = document.getElementById('department-email-tabs');
            if (departmentTabs) {
                const buttons = departmentTabs.querySelectorAll('.department-tab-btn');
                const panels = departmentTabs.querySelectorAll('.department-tab-panel');

                buttons.forEach((button) => {
                    button.addEventListener('click', function () {
                        const targetId = button.getAttribute('data-tab-target');

                        buttons.forEach((btn) => {
                            btn.classList.remove('border-blue-300', 'dark:border-blue-400/40', 'bg-blue-100', 'dark:bg-blue-500/20', 'text-blue-700', 'dark:text-blue-200');
                            btn.classList.add('border-slate-300', 'dark:border-slate-600', 'bg-slate-100', 'dark:bg-slate-700', 'text-slate-600', 'dark:text-slate-300');
                            btn.setAttribute('aria-selected', 'false');
                        });

                        panels.forEach((panel) => {
                            panel.classList.add('hidden');
                        });

                        button.classList.remove('border-slate-300', 'dark:border-slate-600', 'bg-slate-100', 'dark:bg-slate-700', 'text-slate-600', 'dark:text-slate-300');
                        button.classList.add('border-blue-300', 'dark:border-blue-400/40', 'bg-blue-100', 'dark:bg-blue-500/20', 'text-blue-700', 'dark:text-blue-200');
                        button.setAttribute('aria-selected', 'true');

                        const targetPanel = departmentTabs.querySelector('#' + targetId);
                        if (targetPanel) {
                            targetPanel.classList.remove('hidden');
                        }
                    });
                });
            }
        });
    </script>
@endsection
