@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="pointer-events-none absolute -top-20 -right-16 h-48 w-48 rounded-full bg-cyan-200/40 blur-3xl"></div>
        <h1 class="text-2xl font-bold text-slate-900">Manager Control Center</h1>
        <p class="mt-2 max-w-2xl text-sm text-slate-600">Oversee delivery, unblock teams, and balance workload across active projects.</p>
        <div class="mt-5 flex flex-wrap gap-2 text-xs font-semibold">
            <span class="rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-cyan-700">Portfolio Visibility</span>
            <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-emerald-700">Team Health</span>
            <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-amber-700">Risk Monitoring</span>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-3">
        @can('create-project')
            <a href="{{ route('projects.create') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300 hover:shadow-md">
                <div class="text-xs font-semibold uppercase tracking-wide text-cyan-700">Project</div>
                <div class="mt-2 text-lg font-semibold text-slate-900">Create Project</div>
                <div class="mt-1 text-sm text-slate-600">Set scope, owners, and timelines for a new initiative.</div>
            </a>
        @endcan

        <a href="{{ route('tasks.list') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-cyan-700">Tasks</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Task Oversight</div>
            <div class="mt-1 text-sm text-slate-600">Track assignments, due dates, and blockers across teams.</div>
        </a>

        <a href="{{ route('reports.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-cyan-700">Analytics</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Reports</div>
            <div class="mt-1 text-sm text-slate-600">Review throughput, SLA status, and team performance trends.</div>
        </a>
    </section>

    <section class="grid gap-4 md:grid-cols-2">
        <a href="{{ route('tasks.kanban') }}" class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-cyan-50 p-5 shadow-sm transition hover:border-cyan-300">
            <div class="text-sm font-semibold text-slate-900">Kanban Board</div>
            <div class="mt-1 text-sm text-slate-600">Visualize bottlenecks by stage and rebalance work quickly.</div>
        </a>
        <a href="{{ route('tasks.calendar') }}" class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-emerald-50 p-5 shadow-sm transition hover:border-emerald-300">
            <div class="text-sm font-semibold text-slate-900">Calendar View</div>
            <div class="mt-1 text-sm text-slate-600">See deadlines and capacity windows for proactive planning.</div>
        </a>
    </section>
</div>
@endsection
