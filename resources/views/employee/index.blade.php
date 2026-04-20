@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="pointer-events-none absolute -right-16 -top-14 h-48 w-48 rounded-full bg-cyan-200/35 blur-3xl"></div>
        <h1 class="text-2xl font-bold text-slate-900">Employee Workspace</h1>
        <p class="mt-2 max-w-2xl text-sm text-slate-600">Manage daily execution, update progress, and collaborate smoothly across your assigned tasks.</p>
        <div class="mt-5 flex flex-wrap gap-2 text-xs font-semibold">
            <span class="rounded-full border border-cyan-200 bg-cyan-50 px-3 py-1 text-cyan-700">Daily Focus</span>
            <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-emerald-700">Team Collaboration</span>
            <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-amber-700">Delivery Tracking</span>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-3">
        <a href="{{ route('tasks.list') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-cyan-700">Execution</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">My Tasks</div>
            <div class="mt-1 text-sm text-slate-600">View assigned items, update status, and track due dates.</div>
        </a>

        <a href="{{ route('tasks.create') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-cyan-700">Planning</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Create Task</div>
            <div class="mt-1 text-sm text-slate-600">Add a new work item with assignees, scope, and deadline.</div>
        </a>

        <a href="{{ route('dashboard') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300 hover:shadow-md">
            <div class="text-xs font-semibold uppercase tracking-wide text-cyan-700">Insights</div>
            <div class="mt-2 text-lg font-semibold text-slate-900">Dashboard</div>
            <div class="mt-1 text-sm text-slate-600">Monitor status, activity updates, and overall task health.</div>
        </a>
    </section>

    <section class="grid gap-4 md:grid-cols-2">
        <a href="{{ route('tasks.kanban') }}" class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-cyan-50 p-5 shadow-sm transition hover:border-cyan-300">
            <div class="text-sm font-semibold text-slate-900">Kanban Board</div>
            <div class="mt-1 text-sm text-slate-600">Visualize your workflow by stage and clear blockers faster.</div>
        </a>
        <a href="{{ route('tasks.calendar') }}" class="rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-emerald-50 p-5 shadow-sm transition hover:border-emerald-300">
            <div class="text-sm font-semibold text-slate-900">Task Calendar</div>
            <div class="mt-1 text-sm text-slate-600">Plan your week around deadlines, meetings, and holidays.</div>
        </a>
    </section>
</div>
@endsection
