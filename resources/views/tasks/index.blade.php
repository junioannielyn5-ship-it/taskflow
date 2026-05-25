@extends('layouts.app')

@section('content')
<style>
    .tasks-table th:last-child,
    .tasks-table td:last-child {
        position: sticky;
        right: 0;
        z-index: 5;
        background-color: #ffffff;
        box-shadow: -6px 0 15px -3px rgba(0, 0, 0, 0.05);
        border-left: 1px solid #e2e8f0;
        transition: background-color 0.2s;
    }
    html.dark .tasks-table th:last-child,
    html.dark .tasks-table td:last-child {
        background-color: #1e293b; /* slate-800 */
        box-shadow: -6px 0 15px -3px rgba(0, 0, 0, 0.4);
        border-left: 1px solid #334155;
    }
    /* Match row hover */
    .tasks-table tr:hover td:last-child {
        background-color: #f8fafc; /* slate-50 */
    }
    html.dark .tasks-table tr:hover td:last-child {
        background-color: #334155; /* slate-700 */
    }
    .tasks-table thead th:last-child {
        z-index: 15;
        background-color: #ffffff;
    }
    html.dark .tasks-table thead th:last-child {
        background-color: #1e293b;
    }
    /* Priority pin badges */
    .priority-pin {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.85rem;
        border-radius: 9999px;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.12);
        border: 1px solid transparent;
    }
    .pin-dot {
        box-shadow: 0 0 0 3px rgba(255,255,255,0.45);
    }
    .dark .pin-dot {
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.5);
    }
    .priority-pin.pin-urgent {
        background: #fef2f2 !important;
        color: #dc2626 !important;
        border-color: #fca5a5 !important;
    }
    .priority-pin.pin-high {
        background: #fff7ed !important;
        color: #ea580c !important;
        border-color: #fdba74 !important;
    }
    .priority-pin.pin-medium {
        background: #fefce8 !important;
        color: #ca8a04 !important;
        border-color: #fde047 !important;
    }
    .priority-pin.pin-low {
        background: #f0fdf4 !important;
        color: #16a34a !important;
        border-color: #86efac !important;
    }
    .dark .priority-pin.pin-urgent {
        background: rgba(220, 38, 38, 0.15) !important;
        color: #fca5a5 !important;
        border-color: rgba(220, 38, 38, 0.3) !important;
    }
    .dark .priority-pin.pin-high {
        background: rgba(234, 88, 12, 0.15) !important;
        color: #fdba74 !important;
        border-color: rgba(234, 88, 12, 0.3) !important;
    }
    .dark .priority-pin.pin-medium {
        background: rgba(202, 138, 4, 0.15) !important;
        color: #fde047 !important;
        border-color: rgba(202, 138, 4, 0.3) !important;
    }
    .dark .priority-pin.pin-low {
        background: rgba(22, 163, 74, 0.15) !important;
        color: #86efac !important;
        border-color: rgba(22, 163, 74, 0.3) !important;
    }
    .dark .pin-dot {
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.5);
    }
    .filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: flex-end;
    }
    .filter-group > div {
        flex: 1 1 160px;
        min-width: 120px;
    }
    .filter-advanced-toggle {
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        font-size: 1.2em;
        margin-left: 0.5rem;
        padding: 0.25em;
        transition: color 0.2s;
    }
    .filter-advanced-toggle:hover {
        color: #0ea5e9;
    }
    .action-btn {
        background: none;
        border: none;
        padding: 0.4em 0.6em;
        border-radius: 0.5em;
        color: #64748b;
        transition: background 0.2s, color 0.2s;
        font-size: 1.1em;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .action-btn:hover {
        background: #e0e7ef;
        color: #0ea5e9;
    }
    .dark .action-btn:hover {
        background: #334155;
        color: #38bdf8;
    }
    .tasks-table th.w-20, .tasks-table td.w-20 { width: 80px !important; min-width: 60px; }
    .tasks-table th.w-40, .tasks-table td.w-40 { width: 180px !important; min-width: 120px; }
    .tasks-table th.w-44, .tasks-table td.w-44 { width: 220px !important; min-width: 140px; }
    .tasks-table th.w-48, .tasks-table td.w-48 { width: 260px !important; min-width: 160px; }
    .tasks-table th.w-52, .tasks-table td.w-52 { width: 280px !important; min-width: 180px; }
    .tasks-table th.w-36, .tasks-table td.w-36 { width: 140px !important; min-width: 100px; }
    .tasks-table th.w-28, .tasks-table td.w-28 { width: 110px !important; min-width: 80px; }
    .tasks-table th.w-24, .tasks-table td.w-24 { width: 90px !important; min-width: 70px; }
    .tasks-table th.w-32, .tasks-table td.w-32 { width: 120px !important; min-width: 90px; }
</style>
<div class="relative space-y-8 tasks-page">
    <!-- Dynamic Background Effects -->
    <div class="pointer-events-none absolute right-0 top-0 h-[500px] w-[500px] -translate-y-1/3 translate-x-1/3 rounded-full bg-gradient-to-br from-blue-500/20 to-purple-500/20 blur-[80px] dark:from-blue-600/20 dark:to-purple-600/20"></div>
    <div class="pointer-events-none absolute bottom-0 left-0 h-[400px] w-[400px] -translate-x-1/3 translate-y-1/3 rounded-full bg-gradient-to-tr from-emerald-500/20 to-cyan-500/20 blur-[80px] dark:from-emerald-600/20 dark:to-cyan-600/20"></div>

    @php
        $currentTab = request('tab') === 'done' ? 'done' : 'active';
    @endphp

    <!-- Header Section -->
    <div class="relative flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <div class="mb-2 inline-flex items-center rounded-full border border-blue-200/50 bg-blue-50/50 px-3 py-1 text-xs font-semibold tracking-wide text-blue-700 shadow-sm backdrop-blur-md dark:border-blue-700/50 dark:bg-blue-900/50 dark:text-blue-300">
                <span class="mr-1.5 flex h-2 w-2 rounded-full bg-blue-500"></span>
                Workspace Overview
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                Task <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent dark:from-blue-400 dark:to-indigo-400">Manager</span>
            </h1>
        </div>
    </div>

    {{-- Stat Cards Grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-5">
        <!-- Active Projects -->
        <a href="{{ route('tasks.list') }}" class="group relative overflow-hidden rounded-2xl border border-white/40 bg-white/60 p-5 shadow-lg backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-slate-700/50 dark:bg-slate-800/60 dark:shadow-slate-900/50">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">Active Projects</p>
                    <p class="mt-2 text-3xl font-black text-slate-800 dark:text-white">{{ $activeProjectsCount ?? 0 }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 shadow-inner dark:bg-blue-900/50 dark:text-blue-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6"/></svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-blue-500 to-blue-400"></div>
        </a>

        <!-- My Tasks -->
        <a href="{{ route('tasks.list', ['assignee' => auth()->id()]) }}" class="group relative overflow-hidden rounded-2xl border border-white/40 bg-white/60 p-5 shadow-lg backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-slate-700/50 dark:bg-slate-800/60 dark:shadow-slate-900/50">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400">My Tasks</p>
                    <p class="mt-2 text-3xl font-black text-slate-800 dark:text-white">{{ $myTasksCount ?? 0 }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-purple-600 shadow-inner dark:bg-purple-900/50 dark:text-purple-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-purple-500 to-purple-400"></div>
        </a>

        <!-- Pending Review -->
        <a href="{{ route('tasks.list', ['status' => 'for_review']) }}" class="group relative overflow-hidden rounded-2xl border border-white/40 bg-white/60 p-5 shadow-lg backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-slate-700/50 dark:bg-slate-800/60 dark:shadow-slate-900/50">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Pending Review</p>
                    <p class="mt-2 text-3xl font-black text-slate-800 dark:text-white">{{ $pendingReviewCount ?? 0 }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 shadow-inner dark:bg-amber-900/50 dark:text-amber-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-amber-500 to-amber-400"></div>
        </a>

        <!-- Overdue -->
        <a href="{{ route('tasks.list', ['overdue' => 1]) }}" class="group relative overflow-hidden rounded-2xl border border-white/40 bg-white/60 p-5 shadow-lg backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-slate-700/50 dark:bg-slate-800/60 dark:shadow-slate-900/50">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400">Overdue</p>
                    <p class="mt-2 text-3xl font-black text-slate-800 dark:text-white">{{ $overdueCount ?? 0 }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-rose-100 text-rose-600 shadow-inner dark:bg-rose-900/50 dark:text-rose-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-rose-500 to-rose-400"></div>
        </a>

        <!-- Done -->
        <a href="{{ route('tasks.list', ['tab' => 'done']) }}" class="group relative overflow-hidden rounded-2xl border border-white/40 bg-white/60 p-5 shadow-lg backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-slate-700/50 dark:bg-slate-800/60 dark:shadow-slate-900/50">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Done</p>
                    <p class="mt-2 text-3xl font-black text-slate-800 dark:text-white">{{ $doneTasksCount ?? 0 }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600 shadow-inner dark:bg-emerald-900/50 dark:text-emerald-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-full bg-gradient-to-r from-emerald-500 to-emerald-400"></div>
        </a>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="relative inline-flex items-center overflow-hidden rounded-xl border border-white/20 bg-white/40 p-1 shadow-sm backdrop-blur-md dark:border-slate-700/50 dark:bg-slate-800/40">
            <a href="{{ route('tasks.list', array_merge(request()->except(['tab', 'done_page', 'page']), ['tab' => 'active'])) }}"
               class="relative flex items-center justify-center rounded-lg px-5 py-2 text-sm font-bold transition-all duration-200 {{ $currentTab === 'active' ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-md' : 'text-slate-600 hover:bg-white/50 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                Active Tasks
            </a>
            <a href="{{ route('tasks.list', array_merge(request()->except(['tab', 'page']), ['tab' => 'done'])) }}"
               class="relative flex items-center justify-center rounded-lg px-5 py-2 text-sm font-bold transition-all duration-200 {{ $currentTab === 'done' ? 'bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-md' : 'text-slate-600 hover:bg-white/50 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-700/50 dark:hover:text-white' }}">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Checklist / Completed
            </a>
        </div>

        <div class="flex items-center gap-2 rounded-xl border border-white/20 bg-white/40 px-4 py-2 shadow-sm backdrop-blur-md dark:border-slate-700/50 dark:bg-slate-800/40">
            <span class="mr-2 text-xs font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Legend:</span>
            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.8)]" title="TO-DO"></span>
            <span class="inline-flex items-center text-xs font-semibold text-slate-600 dark:text-slate-300">To-Do</span>
            <div class="mx-2 h-4 w-px bg-slate-300 dark:bg-slate-600"></div>
            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.8)]" title="IN-PROGRESS"></span>
            <span class="inline-flex items-center text-xs font-semibold text-slate-600 dark:text-slate-300">In-Progress</span>
            <div class="mx-2 h-4 w-px bg-slate-300 dark:bg-slate-600"></div>
            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-orange-500 shadow-[0_0_8px_rgba(249,115,22,0.8)]" title="FOR REVIEW"></span>
            <span class="inline-flex items-center text-xs font-semibold text-slate-600 dark:text-slate-300">Review</span>
            <div class="mx-2 h-4 w-px bg-slate-300 dark:bg-slate-600"></div>
            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]" title="DONE"></span>
            <span class="inline-flex items-center text-xs font-semibold text-slate-600 dark:text-slate-300">Done</span>
        </div>
    </div>

    <form method="GET" action="{{ route('tasks.list') }}" class="relative overflow-hidden rounded-2xl border border-white/40 bg-white/40 p-5 shadow-lg backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/40">
        <input type="hidden" name="tab" value="{{ request('tab', 'active') }}">
        
        <div class="mb-4 flex items-center justify-between border-b border-slate-200/50 pb-3 dark:border-slate-700/50">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">
                <svg class="mr-2 inline h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                Filter & Search
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8 items-end">
            <div class="xl:col-span-2">
                <label for="search" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">Search Keywords</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input id="search" type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search tasks..." class="block w-full rounded-xl border-0 bg-white/70 py-2.5 pl-10 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500 placeholder:text-slate-400">
                </div>
            </div>

            <div>
                <label for="company" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">Company</label>
                <input id="company" type="text" name="company" value="{{ $filters['company'] ?? '' }}" placeholder="Client..." class="block w-full rounded-xl border-0 bg-white/70 py-2.5 px-3 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500 placeholder:text-slate-400">
            </div>

            <div>
                <label for="status" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">Status</label>
                <select id="status" name="status" class="block w-full rounded-xl border-0 bg-white/70 py-2.5 px-3 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500">
                    <option value="">All Statuses</option>
                    <option value="blocked" @selected(($filters['status'] ?? '') === 'blocked')>BACKLOG</option>
                    <option value="todo" @selected(($filters['status'] ?? '') === 'todo')>TO-DO</option>
                    <option value="in_progress" @selected(($filters['status'] ?? '') === 'in_progress')>IN-PROGRESS</option>
                    <option value="for_review" @selected(($filters['status'] ?? '') === 'for_review')>FOR REVIEW</option>
                    <option value="done" @selected(($filters['status'] ?? '') === 'done')>DONE</option>
                    <option value="cancelled" @selected(($filters['status'] ?? '') === 'cancelled')>Cancelled</option>
                </select>
            </div>

            @if ($currentTab === 'active')
                <div>
                    <label for="priority" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">Priority</label>
                    <select id="priority" name="priority" class="block w-full rounded-xl border-0 bg-white/70 py-2.5 px-3 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500">
                        <option value="">All Priorities</option>
                        <option value="low" @selected(($filters['priority'] ?? '') === 'low')>Low</option>
                        <option value="medium" @selected(($filters['priority'] ?? '') === 'medium')>Medium</option>
                        <option value="high" @selected(($filters['priority'] ?? '') === 'high')>High</option>
                        <option value="urgent" @selected(($filters['priority'] ?? '') === 'urgent')>Urgent</option>
                    </select>
                </div>
            @endif

            <div>
                <label for="assignee" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">Assignee</label>
                <select id="assignee" name="assignee" class="block w-full rounded-xl border-0 bg-white/70 py-2.5 px-3 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500">
                    <option value="">Anyone</option>
                    @foreach ($assignees as $assignee)
                        <option value="{{ $assignee->id }}" @selected((string) ($filters['assignee'] ?? '') === (string) $assignee->id)>
                            {{ $assignee->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date_received" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">Date Received</label>
                <input id="date_received" type="date" name="date_received" value="{{ $filters['date_received'] ?? '' }}" class="block w-full rounded-xl border-0 bg-white/70 py-2.5 px-3 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500">
            </div>

            @if ($currentTab === 'active')
                <div class="xl:col-span-2">
                    <label for="blocked_by_task_id" class="mb-1.5 block text-xs font-bold uppercase tracking-wide text-slate-600 dark:text-slate-400">Blocked By</label>
                    <select id="blocked_by_task_id" name="blocked_by_task_id" class="block w-full rounded-xl border-0 bg-white/70 py-2.5 px-3 text-sm font-medium text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300/50 backdrop-blur-sm transition-all focus:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/50 dark:text-white dark:ring-slate-700/50 dark:focus:bg-slate-800 dark:focus:ring-blue-500">
                        <option value="">No Blockers</option>
                        @foreach ($dependencyOptions as $dependencyOption)
                            <option value="{{ $dependencyOption->id }}" @selected((string) ($filters['blocked_by_task_id'] ?? '') === (string) $dependencyOption->id)>
                                {{ $dependencyOption->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
        
        <div class="mt-5 flex items-center justify-end gap-3 border-t border-slate-200/50 pt-4 dark:border-slate-700/50">
            <a href="{{ route('tasks.list') }}" class="inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold text-slate-600 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-700/50 dark:hover:text-white">
                Clear Filters
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-blue-500/20 transition-all hover:scale-105 hover:from-blue-500 hover:to-indigo-500 hover:shadow-lg hover:shadow-blue-500/40">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                Apply Filters
            </button>
        </div>
    </form>

    @if (session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($currentTab === 'active')
        @if ($tasks->isEmpty())
            <div class="flex flex-col items-center justify-center rounded-2xl border border-white/40 bg-white/40 px-6 py-16 text-center shadow-lg backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/40">
                <div class="mb-4 rounded-full bg-blue-100/50 p-4 dark:bg-blue-900/30">
                    <svg class="h-10 w-10 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">No active tasks found</h3>
                <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">You're all caught up! There are no tasks matching your current filters.</p>
            </div>
        @else
            <div class="mb-3 flex items-center justify-between">
                <h2 class="flex items-center text-sm font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                    <svg class="mr-2 h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" /></svg>
                    Active Project Tasks
                </h2>
                <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">{{ $tasks->total() }} task(s)</span>
            </div>
            <div class="overflow-x-auto rounded-2xl border border-white/40 bg-white/60 shadow-xl backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/60 dark:shadow-slate-900/50">
                <table class="tasks-table min-w-[1700px] divide-y divide-slate-200/60 dark:divide-slate-700/60">
                <thead class="sticky top-0 z-10 bg-white/80 backdrop-blur-md shadow-sm border-b-2 border-slate-200/50 dark:bg-slate-800/80 dark:border-slate-700/50">
                    <tr>
                        <th class="w-20 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Task No</th>
                        <th class="w-24 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Priority</th>
                        <th class="w-44 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Project Owner</th>
                        <th class="w-40 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Person-in-Charge</th>
                        <th class="w-36 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Task Process</th>
                        <th class="w-36 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Specific Process</th>
                        <th class="w-36 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Blocked By</th>
                        <th class="w-36 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Company Client</th>
                        <th class="w-28 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Project</th>
                        <th class="w-44 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Deliverables</th>
                        <th class="w-44 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Document Link</th>
                        <th class="w-52 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Remarks / Latest Comment</th>
                        <th class="w-28 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                        <th class="w-24 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Your Role</th>
                        <th class="w-32 whitespace-nowrap px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date Received</th>
                        <th class="w-32 whitespace-nowrap px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date Started</th>
                        <th class="w-32 whitespace-nowrap px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date Finish</th>
                        <th class="w-36 whitespace-nowrap px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Target Deadline</th>
                        <th class="w-32 whitespace-nowrap px-4 py-3.5 text-center text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/30 bg-transparent">
                    @foreach ($tasks as $index => $task)
                        @php
                            $isDelayed = $task->isOverdue();
                            $rowAccentClass = match($task->priority) {
                                'urgent', 'high' => 'border-l-4 border-red-500',
                                'medium' => 'border-l-4 border-yellow-400',
                                default => 'border-l-4 border-emerald-400',
                            };
                            $priorityBadgeClass = match($task->priority) {
                                'urgent' => 'priority-pin pin-urgent',
                                'high' => 'priority-pin pin-high',
                                'medium' => 'priority-pin pin-medium',
                                default => 'priority-pin pin-low',
                            };
                            $workflowStatusLabel = $isDelayed
                                ? 'DELAYED'
                                : match($task->status) {
                                    'blocked' => 'BACKLOG',
                                    'in_progress' => 'IN-PROGRESS',
                                    'for_review' => 'FOR REVIEW',
                                    'done' => 'DONE',
                                    default => 'TO-DO',
                                };
                            $statusBadgeClass = $isDelayed
                                ? 'border border-red-300 bg-red-100 text-red-900 dark:bg-red-900/30 dark:text-red-300 dark:border-red-700 shadow-sm'
                                : match($task->status) {
                                    'in_progress' => 'border border-blue-300 bg-blue-100 text-blue-900 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-700 shadow-sm',
                                    'for_review' => 'border border-orange-300 bg-orange-100 text-orange-900 dark:bg-orange-900/30 dark:text-orange-300 dark:border-orange-700 shadow-sm',
                                    'done' => 'border border-emerald-300 bg-emerald-100 text-emerald-900 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-700 shadow-sm',
                                    default => 'border border-amber-300 bg-amber-100 text-amber-900 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-700 shadow-sm',
                                };
                            $priorityLabel = strtoupper($task->priority ?? 'low');
                            $projectOwner = $task->project?->project_owner ?: 'Sales (Sales Project)';
                            $dateFinish = $task->status === 'done' ? $task->done_at : null;
                            $taskNumber = $task->task_no ?: sprintf('TSK-%05d', $task->id);
                            $overdueDays = $isDelayed && $task->due_date ? (int) $task->due_date->diffInDays(now()) : 0;
                        @endphp
                        <tr class="{{ $rowAccentClass }} {{ $isDelayed ? 'is-overdue-row bg-red-50/20 dark:bg-red-950/20' : 'bg-transparent' }} hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors duration-200">
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <a href="{{ route('tasks.show', $task) }}" class="font-medium text-blue-600 hover:underline">{{ $taskNumber }}</a>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <span class="{{ $priorityBadgeClass }}">
                                    @if(($task->priority ?? '') === 'urgent')
                                        <span class="pin-dot inline-block h-2 w-2 rounded-full bg-current animate-pulse"></span>
                                    @endif
                                    {{ $priorityLabel }}
                                </span>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $projectOwner }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->team_in_charge ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @if($task->task_process)
                                    <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold text-slate-700 dark:text-slate-200">{{ $task->task_process }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->specific_process ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @if($task->blockedByTask)
                                    <a href="{{ route('tasks.show', $task->blockedByTask) }}" class="text-blue-600 hover:underline">{{ $task->blockedByTask->title }}</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->company ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->project?->name ?? 'N/A' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->deliverables ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @if($task->document_link)
                                    <a href="{{ $task->document_link }}" target="_blank" class="text-blue-600 hover:underline">Open Link</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <p>{{ $task->remarks ?: '-' }}</p>
                                @if(($task->comments_count ?? 0) > 0 && $task->latestComment)
                                    <div class="mt-2 rounded border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 p-2">
                                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-100">Latest comment ({{ $task->comments_count }})</p>
                                        <p class="mt-1 line-clamp-2 text-xs text-slate-600 dark:text-slate-400">"{{ \Illuminate\Support\Str::limit($task->latestComment->body, 90) }}"</p>
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">{{ $task->latestComment->user?->name ?? 'Unknown' }} • {{ $task->latestComment->created_at?->diffForHumans() }}</p>
                                    </div>
                                @endif
                            </td>
                            <td class="py-5 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <span class="inline-flex items-center rounded-full border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold tracking-wide text-slate-800 dark:text-slate-200">
                                    {{ $task->specific_process ?: 'General' }}
                                </span>
                                <div class="mt-2">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide {{ $statusBadgeClass }}">
                                        {{ $workflowStatusLabel }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @php
                                    $roleLabel = $task->project?->member_role ?? 'member';
                                    $roleClass = match($roleLabel) {
                                        'admin' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-700',
                                        'lead' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-700',
                                        'member' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-700',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-900/30 dark:text-gray-300 dark:border-gray-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $roleClass }}">{{ ucwords(str_replace('_', ' ', $roleLabel)) }}</span>
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->date_received ? \Carbon\Carbon::parse($task->date_received)->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->date_started ? $task->date_started->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $dateFinish ? $dateFinish->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium leading-relaxed {{ $isDelayed ? 'font-semibold text-amber-700 dark:text-amber-400' : 'text-slate-800 dark:text-slate-100' }}">
                                {{ $task->due_date ? $task->due_date->format('m-d-Y') : '-' }}
                                @if($isDelayed)
                                    <span class="ml-2 inline-flex items-center rounded-full bg-amber-100 dark:bg-amber-900/30 px-2 py-0.5 text-xs font-semibold text-amber-800 dark:text-amber-300">Overdue {{ $overdueDays }} day(s)</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-right text-xs">
                                <a href="{{ route('tasks.show', $task) }}" class="mr-2 rounded-lg border border-blue-200/50 bg-blue-50/50 px-3 py-1.5 font-bold text-blue-600 transition-colors hover:bg-blue-100 dark:border-blue-700/50 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-800/50">Open</a>
                                @if(auth()->user()?->isAdmin())
                                    <a href="{{ route('tasks.edit', $task) }}" class="mr-2 rounded-lg border border-yellow-200/50 bg-yellow-50/50 px-3 py-1.5 font-bold text-yellow-600 transition-colors hover:bg-yellow-100 dark:border-yellow-700/50 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-800/50">Edit</a>
                                @else
                                    @can('update-task', $task)
                                        <a href="{{ route('tasks.edit', $task) }}" class="mr-2 rounded-lg border border-yellow-200/50 bg-yellow-50/50 px-3 py-1.5 font-bold text-yellow-600 transition-colors hover:bg-yellow-100 dark:border-yellow-700/50 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-800/50">Edit</a>
                                    @endcan
                                @endif
                                @can('delete-task', $task)
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-200/50 bg-red-50/50 px-3 py-1.5 font-bold text-red-600 transition-colors hover:bg-red-100 dark:border-red-700/50 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-800/50" onclick="return confirm('Delete this task?')">Delete</button>
                                    </form>
                                @else
                                    <span class="text-gray-300">-</span>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

            @if(method_exists($tasks, 'hasPages') && $tasks->hasPages())
                <div class="mt-4">
                    {{ $tasks->links() }}
                </div>
            @endif
        @endif
    @endif

    @if ($currentTab === 'done')
        <div id="done-tasks" class="mt-2 mb-3 flex items-center justify-between">
            <h2 class="flex items-center text-sm font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                <svg class="mr-2 h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Checklist / Completed Tasks
            </h2>
            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">{{ $doneTasksCount ?? 0 }} completed</span>
        </div>

        @if (($doneTasksCount ?? 0) === 0)
            <div class="flex flex-col items-center justify-center rounded-2xl border border-white/40 bg-white/40 px-6 py-16 text-center shadow-lg backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/40">
                <div class="mb-4 rounded-full bg-emerald-100/50 p-4 dark:bg-emerald-900/30">
                    <svg class="h-10 w-10 text-emerald-500 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">No completed tasks yet</h3>
                <p class="mt-1 max-w-sm text-sm text-slate-500 dark:text-slate-400">Tasks that you complete will appear here.</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-2xl border border-white/40 bg-white/60 shadow-xl backdrop-blur-xl dark:border-slate-700/50 dark:bg-slate-800/60 dark:shadow-slate-900/50">
                <table class="tasks-table min-w-[1450px] divide-y divide-slate-200/60 dark:divide-slate-700/60">
                <thead class="sticky top-0 z-10 bg-white/80 backdrop-blur-md shadow-sm border-b-2 border-slate-200/50 dark:bg-slate-800/80 dark:border-slate-700/50">
                    <tr>
                        <th class="w-20 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Task No</th>
                        <th class="w-44 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Project Owner</th>
                        <th class="w-40 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Person-in-Charge</th>
                        <th class="w-36 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Task Process</th>
                        <th class="w-36 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Specific Process</th>
                        <th class="w-36 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Company Client</th>
                        <th class="w-28 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Project</th>
                        <th class="w-44 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Deliverables</th>
                        <th class="w-44 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Document Link</th>
                        <th class="w-52 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Remarks / Latest Comment</th>
                        <th class="w-28 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                        <th class="w-24 px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Your Role</th>
                        <th class="w-32 whitespace-nowrap px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date Received</th>
                        <th class="w-32 whitespace-nowrap px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date Started</th>
                        <th class="w-32 whitespace-nowrap px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date Finish</th>
                        <th class="w-36 whitespace-nowrap px-4 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Target Deadline</th>
                        <th class="w-32 whitespace-nowrap px-4 py-3.5 text-right text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/30 bg-transparent">
                    @foreach ($doneTasks as $index => $task)
                        @php
                            $projectOwner = $task->project?->project_owner ?: 'Sales (Sales Project)';
                            $dateFinish = $task->done_at;
                            $taskNumber = $task->task_no ?: sprintf('TSK-%05d', $task->id);
                            $statusBadgeClass = 'border border-emerald-300 bg-emerald-100 text-emerald-900 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-700 shadow-sm';
                        @endphp
                        <tr class="border-l-4 border-emerald-500 bg-transparent hover:bg-slate-50/50 transition-colors duration-200 dark:hover:bg-slate-700/30">
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <a href="{{ route('tasks.show', $task) }}" class="font-medium text-blue-600 hover:underline">{{ $taskNumber }}</a>
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $projectOwner }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->team_in_charge ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @if($task->task_process)
                                    <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold text-slate-700 dark:text-slate-200">{{ $task->task_process }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->specific_process ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->company ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->project?->name ?? 'N/A' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->deliverables ?: '-' }}</td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                @if($task->document_link)
                                    <a href="{{ $task->document_link }}" target="_blank" class="text-blue-600 hover:underline">Open Link</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <p>{{ $task->remarks ?: '-' }}</p>
                                @if(($task->comments_count ?? 0) > 0 && $task->latestComment)
                                    <div class="mt-2 rounded border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 p-2">
                                        <p class="text-xs font-semibold text-slate-800 dark:text-slate-100">Latest comment ({{ $task->comments_count }})</p>
                                        <p class="mt-1 line-clamp-2 text-xs text-slate-600 dark:text-slate-400">"{{ \Illuminate\Support\Str::limit($task->latestComment->body, 90) }}"</p>
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-300">{{ $task->latestComment->user?->name ?? 'Unknown' }} • {{ $task->latestComment->created_at?->diffForHumans() }}</p>
                                    </div>
                                @endif
                            </td>
                            <td class="py-5 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">
                                <span class="inline-flex items-center rounded-full border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-semibold tracking-wide text-slate-800 dark:text-slate-200">
                                    {{ $task->specific_process ?: 'General' }}
                                </span>
                                <div class="mt-2">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide {{ $statusBadgeClass }}">
                                        DONE
                                    </span>
                                </div>
                            </td>
                            <td class="py-4 px-3 text-[11px] font-medium text-slate-700 dark:text-slate-200 leading-relaxed">
                                @php
                                    $roleLabel = $task->project?->member_role ?? 'member';
                                    $roleClass = match($roleLabel) {
                                        'admin' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-700',
                                        'lead' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-700',
                                        'member' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-700',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-900/30 dark:text-gray-300 dark:border-gray-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $roleClass }}">{{ ucwords(str_replace('_', ' ', $roleLabel)) }}</span>
                            </td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->date_received ? \Carbon\Carbon::parse($task->date_received)->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->date_started ? $task->date_started->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $dateFinish ? $dateFinish->format('M d, Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-xs font-medium text-slate-800 dark:text-slate-100 leading-relaxed">{{ $task->due_date ? $task->due_date->format('m-d-Y') : '-' }}</td>
                            <td class="whitespace-nowrap py-4 px-3 text-right text-xs">
                                <a href="{{ route('tasks.show', $task) }}" class="mr-2 rounded-lg border border-blue-200/50 bg-blue-50/50 px-3 py-1.5 font-bold text-blue-600 transition-colors hover:bg-blue-100 dark:border-blue-700/50 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-800/50">Open</a>
                                <span class="text-gray-300 dark:text-slate-600">-</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>

            @if(method_exists($doneTasks, 'hasPages') && $doneTasks->hasPages())
                <div class="mt-4">
                    {{ $doneTasks->links() }}
                </div>
            @endif
        @endif
    @endif
</div>
@endsection
