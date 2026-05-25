@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
        <div class="pointer-events-none absolute -top-20 -right-16 h-48 w-48 rounded-full bg-cyan-200/40 dark:bg-cyan-500/10 blur-3xl"></div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Manager Control Center</h1>
        <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-400">Oversee delivery, unblock teams, and balance workload across active projects.</p>
        <div class="mt-5 flex flex-wrap gap-2 text-xs font-semibold">
            <span class="rounded-full border border-cyan-200 dark:border-cyan-700 bg-cyan-50 dark:bg-cyan-900/30 px-3 py-1 text-cyan-700 dark:text-cyan-400">Portfolio Visibility</span>
            <span class="rounded-full border border-emerald-200 dark:border-emerald-700 bg-emerald-50 dark:bg-emerald-900/30 px-3 py-1 text-emerald-700 dark:text-emerald-400">Team Health</span>
            <span class="rounded-full border border-amber-200 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/30 px-3 py-1 text-amber-700 dark:text-amber-400">Risk Monitoring</span>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-3">
        @can('create-project')
            <a href="{{ route('projects.create') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300 dark:hover:border-cyan-500 hover:shadow-md dark:hover:shadow-[0_4px_20px_rgba(6,182,212,0.15)]">
                <div class="text-xs font-semibold uppercase tracking-wide text-cyan-700 dark:text-cyan-400">Project</div>
                <div class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">Create Project</div>
                <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Set scope, owners, and timelines for a new initiative.</div>
            </a>
        @endcan

        <a href="{{ route('tasks.list') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300 dark:hover:border-cyan-500 hover:shadow-md dark:hover:shadow-[0_4px_20px_rgba(6,182,212,0.15)]">
            <div class="text-xs font-semibold uppercase tracking-wide text-cyan-700 dark:text-cyan-400">Tasks</div>
            <div class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">Task Oversight</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Track assignments, due dates, and blockers across teams.</div>
        </a>

        <a href="{{ route('reports.index') }}" class="group rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300 dark:hover:border-cyan-500 hover:shadow-md dark:hover:shadow-[0_4px_20px_rgba(6,182,212,0.15)]">
            <div class="text-xs font-semibold uppercase tracking-wide text-cyan-700 dark:text-cyan-400">Analytics</div>
            <div class="mt-2 text-lg font-semibold text-slate-900 dark:text-slate-100">Reports</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Review throughput, SLA status, and team performance trends.</div>
        </a>
    </section>

    <section class="grid gap-4 md:grid-cols-2">
        <a href="{{ route('tasks.kanban') }}" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-white to-cyan-50 dark:from-slate-800 dark:to-cyan-900/20 p-5 shadow-sm transition hover:border-cyan-300 dark:hover:border-cyan-500 hover:shadow-md dark:hover:shadow-[0_4px_20px_rgba(6,182,212,0.1)]">
            <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">Kanban Board</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">Visualize bottlenecks by stage and rebalance work quickly.</div>
        </a>
        <a href="{{ route('tasks.calendar') }}" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-white to-emerald-50 dark:from-slate-800 dark:to-emerald-900/20 p-5 shadow-sm transition hover:border-emerald-300 dark:hover:border-emerald-500 hover:shadow-md dark:hover:shadow-[0_4px_20px_rgba(16,185,129,0.1)]">
            <div class="text-sm font-semibold text-slate-900 dark:text-slate-100">Calendar View</div>
            <div class="mt-1 text-sm text-slate-600 dark:text-slate-400">See deadlines and capacity windows for proactive planning.</div>
        </a>
    </section>
</div>
@endsection
