@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <section class="relative overflow-hidden rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="pointer-events-none absolute -bottom-16 -right-14 h-48 w-48 rounded-full bg-emerald-200/35 dark:bg-emerald-500/10 blur-3xl"></div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Project Manager</h1>
        <p class="mt-1 text-xs text-slate-550 dark:text-slate-400">Coordinate execution from kickoff to release with visibility into scope, timeline, and delivery confidence.</p>
        <div class="mt-3 flex flex-wrap gap-2 text-[10px] font-bold">
            <span class="rounded-full border border-emerald-200 dark:border-emerald-800/80 bg-emerald-50/50 dark:bg-emerald-950/40 px-2 py-0.5 text-emerald-750 dark:text-emerald-400">Milestones</span>
            <span class="rounded-full border border-cyan-200 dark:border-cyan-800/80 bg-cyan-50/50 dark:bg-cyan-950/40 px-2 py-0.5 text-cyan-750 dark:text-cyan-400">Workload</span>
            <span class="rounded-full border border-indigo-200 dark:border-indigo-800/80 bg-indigo-50/50 dark:bg-indigo-950/40 px-2 py-0.5 text-indigo-750 dark:text-indigo-400">Delivery Signals</span>
        </div>
    </section>

    <section class="grid gap-3 sm:gap-4 md:grid-cols-3">
        @can('create-project')
            <a href="{{ route('projects.create') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-emerald-300 dark:hover:border-emerald-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
                <div class="text-[9px] font-bold tracking-wide uppercase text-emerald-750 dark:text-emerald-400">Project Setup</div>
                <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Create Project</div>
                <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Configure goals, dates, members, and governance.</div>
            </a>
        @endcan

        <a href="{{ route('tasks.list') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-emerald-300 dark:hover:border-emerald-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-emerald-750 dark:text-emerald-400">Execution</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Team Tasks</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Monitor priorities, dependencies, and progress in real time.</div>
        </a>

        <a href="{{ route('reports.index') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-emerald-300 dark:hover:border-emerald-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-emerald-750 dark:text-emerald-400">Insights</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Reporting</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Review completion, lead time, and delivery consistency.</div>
        </a>
    </section>

    <section class="grid gap-3 sm:gap-4 md:grid-cols-2">
        <a href="{{ route('meetings.index') }}" class="group rounded-xl border border-slate-200/40 bg-gradient-to-br from-white to-emerald-50/50 dark:from-slate-900 dark:to-emerald-955/10 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-emerald-300 dark:hover:border-emerald-750 hover:shadow-md">
            <div class="text-xs font-bold text-slate-900 dark:text-white">Meetings</div>
            <div class="mt-0.5 text-xs text-slate-500 dark:text-slate-405">Run standups and checkpoint meetings with clear agendas.</div>
        </a>
        <a href="{{ route('holidays.index') }}" class="group rounded-xl border border-slate-200/40 bg-gradient-to-br from-white to-cyan-50/50 dark:from-slate-900 dark:to-cyan-950/10 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-cyan-300 dark:hover:border-cyan-750 hover:shadow-md">
            <div class="text-xs font-bold text-slate-900 dark:text-white">Holidays</div>
            <div class="mt-0.5 text-xs text-slate-500 dark:text-slate-405">Adjust timelines around non-working days and leave windows.</div>
        </a>
    </section>
</div>
@endsection
