@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-br from-violet-50 via-white to-fuchsia-50 py-8">
    <div class="pointer-events-none absolute -top-24 -left-24 h-56 w-56 rounded-full bg-violet-300/30 blur-3xl"></div>
    <div class="pointer-events-none absolute top-0 right-1/4 h-44 w-44 rounded-full bg-fuchsia-300/25 blur-3xl"></div>
    <div class="pointer-events-none absolute right-0 bottom-0 h-72 w-72 rounded-full bg-indigo-300/25 blur-3xl"></div>

    <div class="container relative mx-auto space-y-6 px-6">
        <div class="rounded-3xl border border-violet-100 bg-white/90 p-6 shadow-xl ring-1 ring-violet-100/70 backdrop-blur md:p-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-xs font-semibold tracking-[0.2em] text-violet-700 uppercase">Administration</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">Movaflex Control Center</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-relaxed text-slate-600">
                        Manage governance, reporting access, and configuration from one secure admin workspace.
                    </p>
                </div>
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Return to Dashboard
                </a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-violet-200 bg-gradient-to-br from-violet-50 to-indigo-100 p-4 shadow-sm">
                <p class="text-xs font-semibold tracking-wide text-violet-700 uppercase">Scope</p>
                <p class="mt-1 text-xl font-bold text-violet-900">System Admin</p>
                <p class="mt-1 text-sm text-violet-800/80">Platform-wide access and policy enforcement.</p>
            </div>
            <div class="rounded-2xl border border-fuchsia-200 bg-gradient-to-br from-fuchsia-50 to-violet-100 p-4 shadow-sm">
                <p class="text-xs font-semibold tracking-wide text-fuchsia-700 uppercase">Data</p>
                <p class="mt-1 text-xl font-bold text-fuchsia-900">Live Operations</p>
                <p class="mt-1 text-sm text-fuchsia-800/80">Configuration and task/reporting modules are active.</p>
            </div>
            <div class="rounded-2xl border border-indigo-200 bg-gradient-to-br from-indigo-50 to-violet-100 p-4 shadow-sm">
                <p class="text-xs font-semibold tracking-wide text-indigo-700 uppercase">Broadcast</p>
                <p class="mt-1 text-xl font-bold text-indigo-900">Comms Enabled</p>
                <p class="mt-1 text-sm text-indigo-800/80">Announcement email tools are available in configuration.</p>
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-4">
            <a
                href="{{ route('admin.config.index') }}"
                class="group rounded-2xl border border-violet-100 bg-gradient-to-br from-white to-violet-50 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg"
            >
                <p class="text-xs font-semibold tracking-wide text-violet-700 uppercase">Primary</p>
                <h2 class="mt-2 text-lg font-bold text-slate-900">Configuration Hub</h2>
                <p class="mt-2 text-sm text-slate-600">
                    Manage company clients, task labels, team labels, announcement text, and broadcast email settings.
                </p>
                <p class="mt-4 text-sm font-semibold text-violet-700 group-hover:underline">Open configuration</p>
            </a>

            <a
                href="{{ route('reports.index') }}"
                class="group rounded-2xl border border-fuchsia-100 bg-gradient-to-br from-white to-fuchsia-50 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg"
            >
                <p class="text-xs font-semibold tracking-wide text-fuchsia-700 uppercase">Analytics</p>
                <h2 class="mt-2 text-lg font-bold text-slate-900">Reports Center</h2>
                <p class="mt-2 text-sm text-slate-600">
                    Review overdue workloads, completion trends, and cycle-time metrics for leadership decisions.
                </p>
                <p class="mt-4 text-sm font-semibold text-fuchsia-700 group-hover:underline">View reports</p>
            </a>

            <a
                href="{{ route('tasks.list') }}"
                class="group rounded-2xl border border-indigo-100 bg-gradient-to-br from-white to-indigo-50 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg"
            >
                <p class="text-xs font-semibold tracking-wide text-indigo-700 uppercase">Operations</p>
                <h2 class="mt-2 text-lg font-bold text-slate-900">Task Board</h2>
                <p class="mt-2 text-sm text-slate-600">
                    Jump directly to active tasks, pending review queue, and overdue execution follow-ups.
                </p>
                <p class="mt-4 text-sm font-semibold text-indigo-700 group-hover:underline">Open task board</p>
            </a>

            <a
                href="{{ route('admin.chatbot.index') }}"
                class="group rounded-2xl border border-emerald-100 bg-gradient-to-br from-white to-emerald-50 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg"
            >
                <p class="text-xs font-semibold tracking-wide text-emerald-700 uppercase">Assistant</p>
                <h2 class="mt-2 text-lg font-bold text-slate-900">Chatbot Knowledge</h2>
                <p class="mt-2 text-sm text-slate-600">
                    Add or update English and Filipino chatbot answers, steps, and quick links from the admin panel.
                </p>
                <p class="mt-4 text-sm font-semibold text-emerald-700 group-hover:underline">Manage knowledge base</p>
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900">Admin Notes</h3>
            <ul class="mt-3 space-y-2 text-sm text-slate-600">
                <li>- Use Configuration Hub for dropdown and announcement updates.</li>
                <li>- Use Reports Center before sending executive updates.</li>
                <li>- Use Task Board for urgent intervention and overdue follow-up.</li>
                <li>- Use Chatbot Knowledge to keep assistant guidance accurate.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
