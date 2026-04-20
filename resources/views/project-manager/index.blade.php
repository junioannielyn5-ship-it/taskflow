@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="pointer-events-none absolute -bottom-16 -right-14 h-48 w-48 rounded-full bg-emerald-200/40 blur-3xl"></div>
        <h1 class="text-2xl font-bold text-slate-900">Project Manager</h1>
        <p class="mt-2 max-w-2xl text-sm text-slate-600">Coordinate execution from kickoff to release with visibility into scope, timeline, and delivery confidence.</p>
        <div class="mt-5 flex flex-wrap gap-2 text-xs font-semibold">
            <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-emerald-700">Milestones</span>
            <span class="rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-cyan-700">Workload</span>
            <span class="rounded-full border border-indigo-200 bg-indigo-50 px-3 py-1 text-indigo-700">Delivery Signals</span>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-3">
        @can('create-project')
            <a href="{{ route('projects.create') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
                <div class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Project Setup</div>
                <div class="mt-2 text-lg font-semibold text-slate-900">Create Project</div>
                <div class="mt-1 text-sm text-slate-600">Configure goals, dates, members, and governance.</div>
            </a>
        @endcan

        <a href="{{ route('tasks.list') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Execution</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Team Tasks</div>
            <div class="mt-1 text-sm text-slate-600">Monitor priorities, dependencies, and progress in real time.</div>
        </a>

        <a href="{{ route('reports.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Insights</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Reporting</div>
            <div class="mt-1 text-sm text-slate-600">Review completion, lead time, and delivery consistency.</div>
        </a>
    </section>

    <section class="grid gap-4 md:grid-cols-2">
        <a href="{{ route('meetings.index') }}" class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-emerald-50 p-5 shadow-sm transition hover:border-emerald-300">
            <div class="text-sm font-semibold text-slate-900">Meetings</div>
            <div class="mt-1 text-sm text-slate-600">Run standups and checkpoint meetings with clear agendas.</div>
        </a>
        <a href="{{ route('holidays.index') }}" class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-cyan-50 p-5 shadow-sm transition hover:border-cyan-300">
            <div class="text-sm font-semibold text-slate-900">Holidays</div>
            <div class="mt-1 text-sm text-slate-600">Adjust timelines around non-working days and leave windows.</div>
        </a>
    </section>
</div>
@endsection
