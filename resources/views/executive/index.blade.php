@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="pointer-events-none absolute -top-20 right-8 h-48 w-48 rounded-full bg-indigo-200/40 blur-3xl"></div>
        <h1 class="text-2xl font-bold text-slate-900">Executive Insights Center</h1>
        <p class="mt-2 max-w-2xl text-sm text-slate-600">Track delivery confidence, portfolio performance, and strategic execution from a single command view.</p>
        <div class="mt-5 flex flex-wrap gap-2 text-xs font-semibold">
            <span class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-indigo-700">KPI Visibility</span>
            <span class="rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-cyan-700">Strategic Reports</span>
            <span class="rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-rose-700">Risk Signals</span>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-3">
        <a href="{{ route('dashboard') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Overview</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Executive Dashboard</div>
            <div class="mt-1 text-sm text-slate-600">Monitor organization-wide outcomes and current momentum.</div>
        </a>

        <a href="{{ route('reports.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Analytics</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Reports</div>
            <div class="mt-1 text-sm text-slate-600">Open strategic reporting for teams, projects, and delivery quality.</div>
        </a>

        <a href="{{ route('tasks.list') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Operations</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Task Snapshot</div>
            <div class="mt-1 text-sm text-slate-600">Inspect cross-team workload and outstanding commitments.</div>
        </a>
    </section>

    <section class="grid gap-4 md:grid-cols-2">
        <a href="{{ route('projects.index') }}" class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-indigo-50 p-5 shadow-sm transition hover:border-indigo-300">
            <div class="text-sm font-semibold text-slate-900">Project Portfolio</div>
            <div class="mt-1 text-sm text-slate-600">Review active initiatives and project completion health.</div>
        </a>
        <a href="{{ route('notifications.history') }}" class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-rose-50 p-5 shadow-sm transition hover:border-rose-300">
            <div class="text-sm font-semibold text-slate-900">Email Alerts</div>
            <div class="mt-1 text-sm text-slate-600">Stay informed on escalations, deadlines, and critical updates.</div>
        </a>
    </section>
</div>
@endsection
