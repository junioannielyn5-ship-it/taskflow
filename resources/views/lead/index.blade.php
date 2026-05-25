@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <section class="relative overflow-hidden rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="pointer-events-none absolute -top-16 -right-16 h-44 w-44 rounded-full bg-amber-200/40 dark:bg-amber-500/10 blur-3xl"></div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Team Lead Operations</h1>
        <p class="mt-1 text-xs text-slate-550 dark:text-slate-405">Guide daily execution, approve quality gates, and keep delivery flow healthy for your squad.</p>
        <div class="mt-3 flex flex-wrap gap-2 text-[10px] font-bold">
            <span class="rounded-full border border-amber-200 dark:border-amber-800/80 bg-amber-50/50 dark:bg-amber-955/40 px-2 py-0.5 text-amber-750 dark:text-amber-400">Review Queue</span>
            <span class="rounded-full border border-cyan-200 dark:border-cyan-800/80 bg-cyan-50/50 dark:bg-cyan-950/40 px-2 py-0.5 text-cyan-750 dark:text-cyan-400">Daily Visibility</span>
            <span class="rounded-full border border-emerald-200 dark:border-emerald-800/80 bg-emerald-50/50 dark:bg-emerald-950/40 px-2 py-0.5 text-emerald-750 dark:text-emerald-400">Team Output</span>
        </div>
    </section>

    <section class="grid gap-3 sm:gap-4 md:grid-cols-3">
        <a href="{{ route('tasks.list') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-amber-300 dark:hover:border-amber-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-amber-750 dark:text-amber-400">Quality Gate</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Review Queue</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Approve work items waiting for lead review and release.</div>
        </a>

        <a href="{{ route('dashboard') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-amber-300 dark:hover:border-amber-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-amber-750 dark:text-amber-400">Visibility</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Dashboard</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Track blockers, due dates, and progress at a glance.</div>
        </a>

        <a href="{{ route('reports.index') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-amber-300 dark:hover:border-amber-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-amber-750 dark:text-amber-400">Insights</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Reports</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Assess cycle time, completion rates, and workload trends.</div>
        </a>
    </section>

    <section class="grid gap-3 sm:gap-4 md:grid-cols-2">
        <a href="{{ route('meetings.index') }}" class="group rounded-xl border border-slate-200/40 bg-gradient-to-br from-white to-amber-50/50 dark:from-slate-900 dark:to-amber-955/10 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-amber-300 dark:hover:border-amber-750 hover:shadow-md">
            <div class="text-xs font-bold text-slate-900 dark:text-white">Meetings</div>
            <div class="mt-0.5 text-xs text-slate-500 dark:text-slate-405">Run focused standups and weekly sync with clear outcomes.</div>
        </a>
        <a href="{{ route('notifications.history') }}" class="group rounded-xl border border-slate-200/40 bg-gradient-to-br from-white to-cyan-50/50 dark:from-slate-900 dark:to-cyan-950/10 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-cyan-300 dark:hover:border-cyan-750 hover:shadow-md">
            <div class="text-xs font-bold text-slate-900 dark:text-white">Email Alerts</div>
            <div class="mt-0.5 text-xs text-slate-500 dark:text-slate-405">Watch escalation updates and timeline-sensitive changes.</div>
        </a>
    </section>
</div>
@endsection
