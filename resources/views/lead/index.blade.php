@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="pointer-events-none absolute -top-16 -right-16 h-44 w-44 rounded-full bg-amber-200/40 blur-3xl"></div>
        <h1 class="text-2xl font-bold text-slate-900">Team Lead Operations</h1>
        <p class="mt-2 max-w-2xl text-sm text-slate-600">Guide daily execution, approve quality gates, and keep delivery flow healthy for your squad.</p>
        <div class="mt-5 flex flex-wrap gap-2 text-xs font-semibold">
            <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-amber-700">Review Queue</span>
            <span class="rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-cyan-700">Daily Visibility</span>
            <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-emerald-700">Team Output</span>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-3">
        <a href="{{ route('tasks.list') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-amber-700">Quality Gate</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Review Queue</div>
            <div class="mt-1 text-sm text-slate-600">Approve work items waiting for lead review and release.</div>
        </a>

        <a href="{{ route('dashboard') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-amber-700">Visibility</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Dashboard</div>
            <div class="mt-1 text-sm text-slate-600">Track blockers, due dates, and progress at a glance.</div>
        </a>

        <a href="{{ route('reports.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-amber-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-amber-700">Insights</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Reports</div>
            <div class="mt-1 text-sm text-slate-600">Assess cycle time, completion rates, and workload trends.</div>
        </a>
    </section>

    <section class="grid gap-4 md:grid-cols-2">
        <a href="{{ route('meetings.index') }}" class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-amber-50 p-5 shadow-sm transition hover:border-amber-300">
            <div class="text-sm font-semibold text-slate-900">Meetings</div>
            <div class="mt-1 text-sm text-slate-600">Run focused standups and weekly sync with clear outcomes.</div>
        </a>
        <a href="{{ route('notifications.history') }}" class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-cyan-50 p-5 shadow-sm transition hover:border-cyan-300">
            <div class="text-sm font-semibold text-slate-900">Email Alerts</div>
            <div class="mt-1 text-sm text-slate-600">Watch escalation updates and timeline-sensitive changes.</div>
        </a>
    </section>
</div>
@endsection
