@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <section class="relative overflow-hidden rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="pointer-events-none absolute -top-20 right-8 h-48 w-48 rounded-full bg-indigo-200/40 dark:bg-indigo-500/10 blur-3xl"></div>
        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Executive Insights Center</h1>
        <p class="mt-1 text-xs text-slate-550 dark:text-slate-400">Track delivery confidence, portfolio performance, and strategic execution from a single command view.</p>
        <div class="mt-3 flex flex-wrap gap-2 text-[10px] font-bold">
            <span class="rounded-full border border-indigo-200 dark:border-indigo-800/80 bg-indigo-50/50 dark:bg-indigo-950/40 px-2 py-0.5 text-indigo-750 dark:text-indigo-400">KPI Visibility</span>
            <span class="rounded-full border border-cyan-200 dark:border-cyan-800/80 bg-cyan-50/50 dark:bg-cyan-950/40 px-2 py-0.5 text-cyan-750 dark:text-cyan-400">Strategic Reports</span>
            <span class="rounded-full border border-rose-200 dark:border-rose-800/80 bg-rose-50/50 dark:bg-rose-955/40 px-2 py-0.5 text-rose-750 dark:text-rose-455">Risk Signals</span>
        </div>
    </section>

    <section class="grid gap-3 sm:gap-4 md:grid-cols-3">
        <a href="{{ route('dashboard') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-indigo-300 dark:hover:border-indigo-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-indigo-755 dark:text-indigo-400">Overview</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Executive Dashboard</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Monitor organization-wide outcomes and current momentum.</div>
        </a>

        <a href="{{ route('reports.index') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-indigo-300 dark:hover:border-indigo-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-indigo-755 dark:text-indigo-400">Analytics</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Reports</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Open strategic reporting for teams, projects, and delivery quality.</div>
        </a>

        <a href="{{ route('tasks.list') }}" class="group rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-indigo-300 dark:hover:border-indigo-750 hover:shadow-md dark:border-slate-800 dark:bg-slate-900/90">
            <div class="text-[9px] font-bold tracking-wide uppercase text-indigo-755 dark:text-indigo-400">Operations</div>
            <div class="mt-1.5 text-sm font-bold text-slate-900 dark:text-white">Task Snapshot</div>
            <div class="mt-1 text-xs text-slate-500 dark:text-slate-405">Inspect cross-team workload and outstanding commitments.</div>
        </a>
    </section>

    <section class="grid gap-3 sm:gap-4 md:grid-cols-2">
        <a href="{{ route('projects.index') }}" class="group rounded-xl border border-slate-200/40 bg-gradient-to-br from-white to-indigo-50/50 dark:from-slate-900 dark:to-indigo-955/10 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-indigo-300 dark:hover:border-indigo-750 hover:shadow-md">
            <div class="text-xs font-bold text-slate-900 dark:text-white">Project Portfolio</div>
            <div class="mt-0.5 text-xs text-slate-500 dark:text-slate-405">Review active initiatives and project completion health.</div>
        </a>
        <a href="{{ route('notifications.history') }}" class="group rounded-xl border border-slate-200/40 bg-gradient-to-br from-white to-rose-50/50 dark:from-slate-900 dark:to-rose-955/10 p-4 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-rose-300 dark:hover:border-rose-750 hover:shadow-md">
            <div class="text-xs font-bold text-slate-900 dark:text-white">Email Alerts</div>
            <div class="mt-0.5 text-xs text-slate-500 dark:text-slate-405">Stay informed on escalations, deadlines, and critical updates.</div>
        </a>
    </section>
</div>
@endsection
