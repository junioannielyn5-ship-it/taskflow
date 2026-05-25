@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <section class="relative overflow-hidden rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="pointer-events-none absolute -right-16 -top-14 h-48 w-48 rounded-full bg-cyan-200/35 dark:bg-cyan-500/10 blur-3xl"></div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Employee Workspace</h1>
        <p class="mt-1 text-xs text-slate-550 dark:text-slate-400">Manage daily execution, update progress, and collaborate smoothly across your assigned tasks.</p>
        <div class="mt-3 flex flex-wrap gap-2 text-[10px] font-bold">
            <span class="rounded-full border border-cyan-200 dark:border-cyan-800/80 bg-cyan-50/50 dark:bg-cyan-950/40 px-2 py-0.5 text-cyan-750 dark:text-cyan-400">Daily Focus</span>
            <span class="rounded-full border border-emerald-200 dark:border-emerald-800/80 bg-emerald-50/50 dark:bg-emerald-950/40 px-2 py-0.5 text-emerald-750 dark:text-emerald-400">Team Collaboration</span>
            <span class="rounded-full border border-amber-200 dark:border-amber-800/80 bg-amber-50/50 dark:bg-amber-955/40 px-2 py-0.5 text-amber-750 dark:text-amber-400">Delivery Tracking</span>
        </div>
    </section>

    <section class="grid gap-3 sm:gap-4 md:grid-cols-3">
        <a href="{{ route('tasks.list') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-cyan-300 dark:hover:border-cyan-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-cyan-750 dark:text-cyan-400">Execution</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">My Tasks</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">View assigned items, update status, and track due dates.</div>
        </a>

        <a href="{{ route('tasks.create') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-cyan-300 dark:hover:border-cyan-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-cyan-750 dark:text-cyan-400">Planning</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Create Task</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Add a new work item with assignees, scope, and deadline.</div>
        </a>

        <a href="{{ route('dashboard') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-cyan-300 dark:hover:border-cyan-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-cyan-750 dark:text-cyan-400">Insights</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Dashboard</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Monitor status, activity updates, and overall task health.</div>
        </a>
    </section>

    <section class="grid gap-3 sm:gap-4 md:grid-cols-2">
        <a href="{{ route('tasks.kanban') }}" class="group rounded-xl border border-slate-200/40 bg-gradient-to-br from-white to-cyan-50/50 dark:from-slate-900 dark:to-cyan-950/10 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-cyan-300 dark:hover:border-cyan-750 hover:shadow-md">
            <div class="text-xs font-bold text-slate-900 dark:text-white">Kanban Board</div>
            <div class="mt-0.5 text-xs text-slate-500 dark:text-slate-405">Visualize your workflow by stage and clear blockers faster.</div>
        </a>
        <a href="{{ route('tasks.calendar') }}" class="group rounded-xl border border-slate-200/40 bg-gradient-to-br from-white to-emerald-50/50 dark:from-slate-900 dark:to-emerald-950/10 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-emerald-300 dark:hover:border-emerald-750 hover:shadow-md">
            <div class="text-xs font-bold text-slate-900 dark:text-white">Task Calendar</div>
            <div class="mt-0.5 text-xs text-slate-500 dark:text-slate-405">Plan your week around deadlines, meetings, and holidays.</div>
        </a>
    </section>
</div>
@endsection
