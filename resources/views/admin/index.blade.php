@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-br from-violet-50 via-white to-fuchsia-50 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 py-4 min-h-screen">
    <div class="pointer-events-none absolute -top-24 -left-24 h-56 w-56 rounded-full bg-violet-300/30 dark:bg-violet-900/20 blur-3xl"></div>
    <div class="pointer-events-none absolute top-0 right-1/4 h-44 w-44 rounded-full bg-fuchsia-300/25 dark:bg-fuchsia-900/20 blur-3xl"></div>
    <div class="pointer-events-none absolute right-0 bottom-0 h-72 w-72 rounded-full bg-indigo-300/25 dark:bg-indigo-900/20 blur-3xl"></div>

    <div class="container relative mx-auto space-y-4 px-4 sm:px-6">
        <div class="rounded-xl border border-violet-100/50 dark:border-slate-800 bg-white/90 dark:bg-slate-900/90 p-4 shadow-sm backdrop-blur md:p-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-[10px] font-bold tracking-[0.2em] text-violet-700 dark:text-violet-400 uppercase">Administration</p>
                    <h1 class="mt-1 text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Movaflex Control Center</h1>
                    <p class="mt-1 max-w-2xl text-xs text-slate-550 dark:text-slate-400">
                        Manage governance, reporting access, and configuration from one secure admin workspace.
                    </p>
                </div>
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 py-1.5 px-3 text-xs font-bold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200 hover:-translate-y-0.5"
                >
                    Return to Dashboard
                </a>
            </div>
        </div>

        <div class="grid gap-3 sm:gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-violet-250 dark:border-violet-800 bg-gradient-to-br from-violet-50/50 to-indigo-100/50 dark:from-violet-900/10 dark:to-indigo-900/10 p-3.5 shadow-sm">
                <p class="text-[9px] font-bold tracking-wide text-violet-700 dark:text-violet-400 uppercase">Scope</p>
                <p class="mt-0.5 text-base font-bold text-violet-900 dark:text-violet-100">System Admin</p>
                <p class="mt-0.5 text-xs text-violet-800/80 dark:text-violet-200/70">Platform-wide access and policy enforcement.</p>
            </div>
            <div class="rounded-xl border border-fuchsia-250 dark:border-fuchsia-800 bg-gradient-to-br from-fuchsia-50/50 to-violet-100/50 dark:from-fuchsia-900/10 dark:to-violet-900/10 p-3.5 shadow-sm">
                <p class="text-[9px] font-bold tracking-wide text-fuchsia-700 dark:text-fuchsia-400 uppercase">Data</p>
                <p class="mt-0.5 text-base font-bold text-fuchsia-900 dark:text-fuchsia-100">Live Operations</p>
                <p class="mt-0.5 text-xs text-fuchsia-800/80 dark:text-fuchsia-200/70">Configuration and task/reporting modules are active.</p>
            </div>
            <div class="rounded-xl border border-indigo-250 dark:border-indigo-800 bg-gradient-to-br from-indigo-50/50 to-violet-100/50 dark:from-indigo-900/10 dark:to-violet-900/10 p-3.5 shadow-sm">
                <p class="text-[9px] font-bold tracking-wide text-indigo-700 dark:text-indigo-400 uppercase">Broadcast</p>
                <p class="mt-0.5 text-base font-bold text-indigo-900 dark:text-indigo-100">Comms Enabled</p>
                <p class="mt-0.5 text-xs text-indigo-800/80 dark:text-indigo-200/70">Announcement email tools are available in configuration.</p>
            </div>
        </div>

        <div class="grid gap-3 sm:gap-4 lg:grid-cols-4">
            <a
                href="{{ route('admin.config.index') }}"
                class="group rounded-xl border border-violet-100 dark:border-slate-800 bg-gradient-to-br from-white to-violet-50/50 dark:from-slate-900 dark:to-slate-950 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-violet-300 dark:hover:border-violet-750"
            >
                <p class="text-[9px] font-bold tracking-wide text-violet-700 dark:text-violet-400 uppercase">Primary</p>
                <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">Configuration Hub</h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-405">
                    Manage company clients, task labels, team labels, announcement text, and broadcast email settings.
                </p>
                <p class="mt-3 text-xs font-bold text-violet-700 dark:text-violet-400 group-hover:underline">Open configuration</p>
            </a>

            <a
                href="{{ route('reports.index') }}"
                class="group rounded-xl border border-fuchsia-100 dark:border-slate-800 bg-gradient-to-br from-white to-fuchsia-50/50 dark:from-slate-900 dark:to-slate-950 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-fuchsia-300 dark:hover:border-fuchsia-750"
            >
                <p class="text-[9px] font-bold tracking-wide text-fuchsia-700 dark:text-fuchsia-400 uppercase">Analytics</p>
                <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">Reports Center</h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-405">
                    Review overdue workloads, completion trends, and cycle-time metrics for leadership decisions.
                </p>
                <p class="mt-3 text-xs font-bold text-fuchsia-700 dark:text-fuchsia-400 group-hover:underline">View reports</p>
            </a>

            <a
                href="{{ route('tasks.list') }}"
                class="group rounded-xl border border-indigo-100 dark:border-slate-800 bg-gradient-to-br from-white to-indigo-50/50 dark:from-slate-900 dark:to-slate-950 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-indigo-300 dark:hover:border-indigo-750"
            >
                <p class="text-[9px] font-bold tracking-wide text-indigo-700 dark:text-indigo-400 uppercase">Operations</p>
                <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">Task Board</h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-405">
                    Jump directly to active tasks, pending review queue, and overdue execution follow-ups.
                </p>
                <p class="mt-3 text-xs font-bold text-indigo-700 dark:text-indigo-400 group-hover:underline">Open task board</p>
            </a>

            <a
                href="{{ route('admin.chatbot.index') }}"
                class="group rounded-xl border border-emerald-100 dark:border-slate-800 bg-gradient-to-br from-white to-emerald-50/50 dark:from-slate-900 dark:to-slate-950 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md hover:border-emerald-300 dark:hover:border-emerald-750"
            >
                <p class="text-[9px] font-bold tracking-wide text-emerald-700 dark:text-emerald-400 uppercase">Assistant</p>
                <h2 class="mt-1 text-sm font-bold text-slate-900 dark:text-white">Chatbot Knowledge</h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-405">
                    Add or update English and Filipino chatbot answers, steps, and quick links from the admin panel.
                </p>
                <p class="mt-3 text-xs font-bold text-emerald-700 dark:text-emerald-400 group-hover:underline">Manage knowledge base</p>
            </a>
        </div>

        <div class="rounded-xl border border-slate-200/40 bg-white/90 dark:bg-slate-900/90 p-4 shadow-sm dark:border-slate-800">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Admin Notes</h3>
            <ul class="mt-2 space-y-1.5 text-xs text-slate-500 dark:text-slate-405">
                <li>- Use Configuration Hub for dropdown and announcement updates.</li>
                <li>- Use Reports Center before sending executive updates.</li>
                <li>- Use Task Board for urgent intervention and overdue follow-up.</li>
                <li>- Use Chatbot Knowledge to keep assistant guidance accurate.</li>
            </ul>
        </div>
    </div>
</div>
</div>
@endsection
