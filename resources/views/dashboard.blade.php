@extends('layouts.app')
@section('content')
@php
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
@endphp
@php
    $logoPath = \App\Modules\Admin\Models\SystemSetting::valueOf('branding_logo_path', null);
@endphp
<div class="mv-dashboard-shell">
<div class="flex flex-row items-start gap-0 w-full min-h-[calc(100vh-4.5rem)] bg-[#f8fafc] dark:bg-[#0f172a]">
        <!-- Sidebar -->
<div id="mv-sidebar-wrapper" class="shrink-0 hidden md:block sticky top-[4.7rem] z-30" style="width: 16rem; height: calc(100vh - 4.5rem);">
<aside class="dashboard-sidebar relative bg-white dark:bg-slate-900 p-4 text-slate-800 w-full shrink-0 border-r border-slate-200 dark:border-slate-700 h-full overflow-y-auto">
    <!-- Sidebar Header -->
  <div class="sidebar-brand mb-6 rounded-xl bg-[#1e293b] p-4 shadow-lg">
    <h2 class="text-center text-sm font-bold tracking-widest text-white uppercase">
        Movaflex Task <br> Manager
    </h2>
</div>

    <nav class="relative z-10 space-y-1 text-sm">
        <a href="{{ route('dashboard') }}" class="nav-item-active">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('tasks.list') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            <span>My Tasks</span>
        </a>

        <a href="{{ route('tasks.kanban') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" /></svg>
            <span>Kanban</span>
        </a>

        <a href="{{ route('tasks.calendar') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            <span>Calendar</span>
        </a>

        <a href="{{ route('meetings.index') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            <span>Meetings</span>
        </a>

        <a href="{{ route('holidays.index') }}" class="nav-item">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
            <span>Holidays</span>
        </a>

        <a href="{{ route('notifications.history') }}" class="nav-item justify-between">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                <span>Notifications</span>
            </div>
            @if(isset($sidebarUnreadCount) && $sidebarUnreadCount > 0)
                <span class="bg-rose-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ $sidebarUnreadCount }}</span>
            @endif
        </a>

        <hr class="my-2 border-slate-100 dark:border-slate-700">

        @if (auth()->user()?->hasAnyRole(['manager', 'project_manager', 'admin']))
            <a href="{{ route('manager.index') }}" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                <span>Manager</span>
            </a>
        @endif

        @if (auth()->user()?->hasAnyRole(['project_manager', 'pm', 'admin']))
            <a href="{{ route('project-manager.index') }}" class="nav-item">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                <span>Project Manager</span>
            </a>
        @endif

        @if (Route::has('logout'))
            <form method="POST" action="{{ route('logout') }}" class="mt-4 w-fit">
                @csrf
                <button type="submit" class="flex w-fit items-center gap-2 rounded-xl border border-rose-300 bg-rose-50 px-3 py-2 text-rose-700 transition hover:bg-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    Logout
                </button>
            </form>
        @endif
    </nav>
</aside>
</div>

<!-- Main Content -->
<section class="dashboard-main flex-1 min-w-0 p-0 bg-[#f8fafc] dark:bg-[#0f172a]">
            <!-- Dashboard Navbar -->
            <div class="mv-navbar h-12 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between px-5 sticky top-[3.5rem] z-20">
                {{-- Left: Hamburger + Title --}}
                <div class="flex items-center gap-3">
                    <button onclick="mvToggleSidebar()" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors" title="Toggle Sidebar">
                        <svg id="mv-sidebar-icon-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 dark:text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg id="mv-sidebar-icon-close" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500 dark:text-slate-300 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                        </svg>
                    </button>
                    <h1 class="text-2xl font-semibold text-slate-800 dark:text-slate-100">Dashboard</h1>
                    <span class="hidden sm:inline text-xs text-slate-400">{{ $greeting }}, {{ auth()->user()->name }}</span>
                </div>
                {{-- Right: New Project --}}
                <div class="flex items-center gap-3">
                    @can('create-project')
                        <a href="{{ route('projects.create') }}" class="dashboard-create-btn rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm shadow-indigo-200 transition hover:bg-indigo-700">+ New Project</a>
                    @endcan
                </div>
            </div>

            <div class="mv-content-inner px-4 pt-1 pb-3 space-y-4 transition-all duration-300">
            <div class="dashboard-welcome-card relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm transition-all hover:shadow-md">
    <div class="flex items-center gap-4">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" />
            </svg>
        </div>
        
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">
                Welcome to <span class="text-indigo-600 dark:text-indigo-400">Movaflex</span> Task Manager
            </h2>
            <div class="flex items-center gap-2 mt-0.5">
                <span class="flex h-2 w-2 rounded-full bg-green-400"></span>
                <p class="text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase tracking-widest">System Online • Go-Live Edition</p>
            </div>
        </div>
    </div>

    <div class="mt-5 max-w-3xl">
        <p class="text-base leading-relaxed text-slate-600 dark:text-slate-300 italic border-l-4 border-indigo-200 dark:border-indigo-700 pl-6 pr-4 text-justify">
            "{{ $systemAnnouncement }}"
        </p>
    </div>

    <div class="mt-8 flex flex-wrap gap-4">
        <a href="{{ route('tasks.list') }}" class="group inline-flex items-center rounded-xl px-6 py-3 text-sm font-bold text-white shadow-sm transition-all hover:-translate-y-0.5 active:scale-95" style="background-color: #4f46e5; color: #ffffff;">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            Open My Tasks
        </a>

        <a href="{{ route('tasks.kanban') }}" class="group inline-flex items-center rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 px-6 py-3 text-sm font-bold text-slate-700 dark:text-slate-200 transition-all hover:bg-slate-50 dark:hover:bg-slate-700 hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2.5 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" /></svg>
            Kanban Board
        </a>

        @if(auth()->user()?->hasAnyRole(['admin', 'manager']))
            <a href="{{ route('admin.config.index') }}#broadcast-email" class="inline-flex items-center rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-6 py-3 text-sm font-bold text-slate-600 dark:text-slate-300 transition-all hover:bg-slate-200 dark:hover:bg-slate-700 hover:text-slate-800 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2.5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                Email Broadcast
            </a>
        @endif
    </div>
</div>

            <div class="dashboard-stats grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
                <a href="/projects" class="group relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-300 mb-1">Active Projects</p>
                            <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $totalProjects }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h8m-8 4h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" /></svg>
                        </div>
                    </div>
                </a>
                <a href="{{ route('tasks.list') }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-300 mb-1">My Tasks</p>
                            <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $totalTasks }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2" /></svg>
                        </div>
                    </div>
                </a>
                <a href="{{ route('tasks.list', ['status' => 'for_review']) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-300 mb-1">Pending Review</p>
                            <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $pendingReview }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-amber-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z" /></svg>
                        </div>
                    </div>
                </a>
                <a href="{{ route('tasks.list') }}" class="group relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-300 mb-1">Overdue</p>
                            <h3 class="text-3xl font-bold text-slate-800 dark:text-white">{{ $overdue }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-rose-500 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" /></svg>
                        </div>
                    </div>
                </a>
            </div>

            <div class="dashboard-analytics grid grid-cols-1 gap-4 xl:grid-cols-2">
                <div id="latest-notifications-card" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-md transition-all scroll-mt-24">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Task Status Overview</h3>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('dashboard.export.status-overview.csv') }}" class="rounded border border-slate-200 dark:border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-500 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-white">CSV</a>
                            <a href="{{ route('dashboard.export.status-overview.pdf') }}" class="rounded border border-slate-200 dark:border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-500 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-white">PDF</a>
                        </div>
                    </div>
                    <p class="mb-3 text-sm text-slate-500 dark:text-slate-300">Done: <span id="done-percentage" class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $donePercentage }}%</span> · In Progress: <span id="in-progress-percentage" class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $inProgressPercentage }}%</span></p>
                    <div class="relative h-48 w-full">
                        <canvas id="taskStatusChart"></canvas>
                    </div>
                </div>
                <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-md transition-all">
                    <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white">Tasks Over Time</h3>
                    <div class="relative h-48 w-full">
                        <canvas id="tasksOverTimeChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- ===== PROJECT PROGRESS: Sales / Technical Tabs ===== --}}
            <div class="dashboard-panel rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-5 shadow-sm hover:shadow-md transition-all" id="mv-progress-panel">

                {{-- Tab header --}}
                <div class="mb-4 flex items-center gap-2">
                    <h3 class="mr-auto text-lg font-semibold text-slate-800 dark:text-white">Project Progress</h3>
                    <button id="mv-tab-sales"
                        onclick="mvSwitchTab('sales')"
                        class="mv-tab-btn rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wide transition">
                        Sales
                    </button>
                    <button id="mv-tab-technical"
                        onclick="mvSwitchTab('technical')"
                        class="mv-tab-btn rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-wide transition">
                        Technical
                    </button>
                </div>

                @if(collect($projectProgress ?? [])->isEmpty())
                    <p class="text-sm text-slate-500">No project progress available yet.</p>
                @else
                    {{-- SALES tab content --}}
                    <div id="mv-tab-content-sales" class="mv-tab-content space-y-2">
                        @php $salesHasAny = collect($projectProgress)->contains(fn($p) => count($p['sales']['tasks']) > 0); @endphp
                        @if(!$salesHasAny)
                            <p class="text-sm text-slate-400">No Sales tasks found.</p>
                        @else
                            @foreach($projectProgress as $pi => $project)
                                @if(count($project['sales']['tasks']) > 0)
                                <div class="mv-accordion rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                                    {{-- Project header --}}
                                    <button
                                        class="mv-accordion-trigger flex w-full items-center justify-between px-4 py-3 text-left hover:bg-slate-50 dark:hover:bg-slate-800/50 transition"
                                        onclick="mvToggleAccordion(this)">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="h-2 w-2 flex-shrink-0 rounded-full bg-emerald-500"></span>
                                            <span class="truncate text-sm font-semibold text-slate-800 dark:text-white">{{ $project['name'] }}</span>
                                        </div>
                                        <div class="ml-3 flex flex-shrink-0 items-center gap-3">
                                            <span class="rounded-full bg-emerald-100 dark:bg-emerald-500/20 px-2 py-0.5 text-[11px] font-semibold text-emerald-700 dark:text-emerald-400">
                                                {{ count($project['sales']['tasks']) }} task{{ count($project['sales']['tasks']) !== 1 ? 's' : '' }}
                                            </span>
                                            <span class="tabular-nums text-xs text-slate-500">
                                                {{ $project['sales']['done'] }}/{{ $project['sales']['total'] }}
                                            </span>
                                            <div class="relative h-1.5 w-20 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                                                @php
                                                    $salesPercent = isset($project['sales']['percent']) ? ((float) $project['sales']['percent']) : 0;
                                                @endphp
                                                <div class="absolute inset-y-0 left-0 rounded-full bg-emerald-500 transition-all progress-bar"
                                                    data-width="{{ $salesPercent }}"></div>
                                            </div>
                                            <span class="w-8 text-right text-xs font-semibold text-emerald-600 dark:text-emerald-400">{{ $project['sales']['percent'] }}%</span>
                                            <svg class="mv-chevron h-4 w-4 flex-shrink-0 text-slate-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </button>
                                    {{-- Task list --}}
                                    <div class="mv-accordion-body hidden border-t border-slate-100 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-800/30 px-4 py-4">
                                        <div class="mv-task-flow space-y-4">
                                            <div class="relative overflow-x-auto pb-2">
                                                <div class="relative min-w-[680px] px-2 pt-1">
                                                    <div class="flex min-w-[680px] items-start justify-between gap-1">
                                                        @foreach($project['sales']['tasks'] as $ti => $task)
                                                            @php
                                                                $statusLabel = ucwords(str_replace('_', ' ', $task['status']));
                                                                $nodeState = match($task['status']) {
                                                                    'done' => 'mv-node-done',
                                                                    'in_progress' => 'mv-node-in-progress',
                                                                    'for_review' => 'mv-node-for-review',
                                                                    'todo', 'backlog' => 'mv-node-todo',
                                                                    default => 'mv-node-todo',
                                                                };
                                                            @endphp
                                                            <button type="button" class="mv-task-node relative flex flex-col items-center px-1 text-center {{ $ti === 0 ? 'is-selected' : '' }}" data-target="sales-{{ $project['id'] }}-task-{{ $task['id'] }}" onclick="mvSelectTask(this)">
                                                                <span class="mv-node {{ $nodeState }}"></span>
                                                                <span class="mt-2 text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $task['task_no'] ?: ('Task ' . ($ti + 1)) }}</span>
                                                                <span class="text-xs uppercase tracking-wide text-slate-500">{{ $statusLabel }}</span>
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="space-y-2">
                                                @foreach($project['sales']['tasks'] as $ti => $task)
                                                    @php
                                                        $statusBadgeClass = match($task['status']) {
                                                            'done' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400',
                                                            'in_progress' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400',
                                                            'for_review' => 'bg-orange-100 dark:bg-orange-500/20 text-orange-700 dark:text-orange-400',
                                                            'todo', 'backlog' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400',
                                                            default => 'bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300',
                                                        };
                                                    @endphp
                                                    <div id="sales-{{ $project['id'] }}-task-{{ $task['id'] }}" class="mv-task-detail rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 p-3 {{ $ti === 0 ? '' : 'hidden' }}">
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">{{ $task['task_no'] ?: ('Task ' . ($ti + 1)) }}</span>
                                                            <span class="truncate text-sm font-medium text-slate-700 dark:text-slate-200">{{ $task['title'] }}</span>
                                                            <span class="ml-auto rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $statusBadgeClass }}">{{ ucwords(str_replace('_', ' ', $task['status'])) }}</span>
                                                        </div>
                                                        @if($task['due_date'])
                                                            <p class="mt-1 text-xs text-slate-400">Due: {{ $task['due_date'] }}</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    {{-- TECHNICAL tab content --}}
                    <div id="mv-tab-content-technical" class="mv-tab-content hidden space-y-2">
                        @php $techHasAny = collect($projectProgress)->contains(fn($p) => count($p['technical']['tasks']) > 0); @endphp
                        @if(!$techHasAny)
                            <p class="text-sm text-slate-400">No Technical tasks found.</p>
                        @else
                            @foreach($projectProgress as $pi => $project)
                                @if(count($project['technical']['tasks']) > 0)
                                <div class="mv-accordion rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                                    <button
                                        class="mv-accordion-trigger flex w-full items-center justify-between px-4 py-3 text-left hover:bg-slate-50 dark:hover:bg-slate-800/50 transition"
                                        onclick="mvToggleAccordion(this)">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <span class="h-2 w-2 flex-shrink-0 rounded-full bg-blue-500"></span>
                                            <span class="truncate text-sm font-semibold text-slate-800 dark:text-white">{{ $project['name'] }}</span>
                                        </div>
                                        <div class="ml-3 flex flex-shrink-0 items-center gap-3">
                                            <span class="rounded-full bg-blue-100 dark:bg-blue-500/20 px-2 py-0.5 text-[11px] font-semibold text-blue-700 dark:text-blue-400">
                                                {{ count($project['technical']['tasks']) }} task{{ count($project['technical']['tasks']) !== 1 ? 's' : '' }}
                                            </span>
                                            <span class="tabular-nums text-xs text-slate-500">
                                                {{ $project['technical']['done'] }}/{{ $project['technical']['total'] }}
                                            </span>
                                            <div class="relative h-1.5 w-20 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-700">
                                                @php
                                                    $techPercent = isset($project['technical']['percent']) ? ((float) $project['technical']['percent']) : 0;
                                                @endphp
                                                <div class="absolute inset-y-0 left-0 rounded-full bg-blue-500 transition-all progress-bar"
                                                    data-width="{{ $techPercent }}"></div>
                                            </div>
                                            <span class="w-8 text-right text-xs font-semibold text-blue-600 dark:text-blue-400">{{ $project['technical']['percent'] }}%</span>
                                            <svg class="mv-chevron h-4 w-4 flex-shrink-0 text-slate-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                        </div>
                                    </button>
                                    <div class="mv-accordion-body hidden border-t border-slate-100 dark:border-slate-700 bg-slate-50/60 dark:bg-slate-800/30 px-4 py-4">
                                        <div class="mv-task-flow space-y-4">
                                            <div class="relative overflow-x-auto pb-2">
                                                <div class="relative min-w-[680px] px-2 pt-1">
                                                    <div class="flex min-w-[680px] items-start justify-between gap-1">
                                                        @foreach($project['technical']['tasks'] as $ti => $task)
                                                            @php
                                                                $statusLabel = ucwords(str_replace('_', ' ', $task['status']));
                                                                $nodeState = match($task['status']) {
                                                                    'done' => 'mv-node-done',
                                                                    'in_progress' => 'mv-node-in-progress',
                                                                    'for_review' => 'mv-node-for-review',
                                                                    'todo', 'backlog' => 'mv-node-todo',
                                                                    default => 'mv-node-todo',
                                                                };
                                                            @endphp
                                                            <button type="button" class="mv-task-node relative flex flex-col items-center px-1 text-center {{ $ti === 0 ? 'is-selected' : '' }}" data-target="technical-{{ $project['id'] }}-task-{{ $task['id'] }}" onclick="mvSelectTask(this)">
                                                                <span class="mv-node {{ $nodeState }}"></span>
                                                                <span class="mt-2 text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $task['task_no'] ?: ('Task ' . ($ti + 1)) }}</span>
                                                                <span class="text-xs uppercase tracking-wide text-slate-500">{{ $statusLabel }}</span>
                                                            </button>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="space-y-2">
                                                @foreach($project['technical']['tasks'] as $ti => $task)
                                                    @php
                                                        $statusBadgeClass = match($task['status']) {
                                                            'done' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400',
                                                            'in_progress' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400',
                                                            'for_review' => 'bg-orange-100 dark:bg-orange-500/20 text-orange-700 dark:text-orange-400',
                                                            'todo', 'backlog' => 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400',
                                                            default => 'bg-slate-100 dark:bg-slate-700/50 text-slate-600 dark:text-slate-300',
                                                        };
                                                    @endphp
                                                    <div id="technical-{{ $project['id'] }}-task-{{ $task['id'] }}" class="mv-task-detail rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 p-3 {{ $ti === 0 ? '' : 'hidden' }}">
                                                        <div class="flex items-center gap-2">
                                                            <span class="text-xs font-bold text-blue-600 dark:text-blue-400">{{ $task['task_no'] ?: ('Task ' . ($ti + 1)) }}</span>
                                                            <span class="truncate text-sm font-medium text-slate-700 dark:text-slate-200">{{ $task['title'] }}</span>
                                                            <span class="ml-auto rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $statusBadgeClass }}">{{ ucwords(str_replace('_', ' ', $task['status'])) }}</span>
                                                        </div>
                                                        @if($task['due_date'])
                                                            <p class="mt-1 text-xs text-slate-400">Due: {{ $task['due_date'] }}</p>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>

            <style>
                .mv-tab-btn { background: #f1f5f9; color: #64748b; }
                .mv-tab-btn.mv-tab-active-sales { background: #d1fae5; color: #059669; }
                .mv-tab-btn.mv-tab-active-technical { background: #dbeafe; color: #2563eb; }
                .mv-chevron.open { transform: rotate(180deg); }
                .mv-task-node:not(:first-child)::before {
                    content: '';
                    position: absolute;
                    right: 50%;
                    top: 9px;
                    width: 100%;
                    height: 2px;
                    background: #334155;
                    z-index: 0;
                }
                .mv-task-node.is-selected .mv-node {
                    transform: scale(1.08);
                    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.25);
                }
                .mv-node {
                    position: relative;
                    z-index: 1;
                    width: 18px;
                    height: 18px;
                    border-radius: 999px;
                    border: 2px solid transparent;
                    background: #1e293b;
                    transition: all 0.2s ease;
                }
                .mv-node-done {
                    background: #10b981;
                    border-color: #10b981;
                }
                .mv-node-in-progress {
                    background: #3b82f6;
                    border-color: #3b82f6;
                }
                .mv-node-todo {
                    background: #f59e0b;
                    border-color: #f59e0b;
                }
                .mv-node-for-review {
                    background: #f59e0b;
                    border-color: #f59e0b;
                }
            </style>
            <script>
                function mvSwitchTab(tab) {
                    document.querySelectorAll('.mv-tab-content').forEach(el => el.classList.add('hidden'));
                    document.querySelectorAll('.mv-tab-btn').forEach(btn => { btn.classList.remove('mv-tab-active-sales','mv-tab-active-technical'); });
                    document.getElementById('mv-tab-content-' + tab).classList.remove('hidden');
                    document.getElementById('mv-tab-' + tab).classList.add('mv-tab-active-' + tab);
                }
                function mvToggleAccordion(trigger) {
                    var body    = trigger.nextElementSibling;
                    var chevron = trigger.querySelector('.mv-chevron');
                    var isOpen  = !body.classList.contains('hidden');
                    body.classList.toggle('hidden', isOpen);
                    chevron && chevron.classList.toggle('open', !isOpen);
                }
                function mvSelectTask(nodeEl) {
                    var flow = nodeEl.closest('.mv-task-flow');
                    if (!flow) return;

                    flow.querySelectorAll('.mv-task-node').forEach(function (n) {
                        n.classList.remove('is-selected');
                    });
                    nodeEl.classList.add('is-selected');

                    var targetId = nodeEl.getAttribute('data-target');
                    flow.querySelectorAll('.mv-task-detail').forEach(function (detail) {
                        detail.classList.add('hidden');
                    });

                    var target = flow.querySelector('[id="' + targetId + '"]');
                    if (target) {
                        target.classList.remove('hidden');
                    }
                }
                // Init: activate Sales tab by default
                document.addEventListener('DOMContentLoaded', function () { mvSwitchTab('sales'); });
            </script>

            <div class="dashboard-panel rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-md transition-all">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Urgent Tasks</h3>
                    <a href="{{ route('tasks.list', ['priority' => 'urgent']) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 hover:underline">View All</a>
                </div>
                @if($urgentTasks->isEmpty())
                    <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 px-6 py-12 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="mt-3 text-sm text-slate-500">No urgent tasks found</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-2 border-b-2 border-slate-200 dark:border-slate-700">
                                    <th class="px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Title</th>
                                    <th class="px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Project</th>
                                    <th class="px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Assignees</th>
                                    <th class="px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Priority</th>
                                    <th class="px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-widest text-slate-500">Due</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800">
                                @foreach($urgentTasks as $task)
                                    <tr class="border-2 border-slate-200 dark:border-slate-700 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                        <td class="px-3 py-3 font-medium text-slate-700 dark:text-slate-200">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-violet-700 dark:text-violet-400 hover:text-violet-500 dark:hover:text-violet-300 hover:underline">{{ $task->title }}</a>
                                        </td>
                                        <td class="px-3 py-3 text-slate-500 dark:text-slate-300">{{ $task->project->name ?? '-' }}</td>
                                        <td class="px-3 py-3">
                                            <div class="flex -space-x-2">
                                                @forelse($task->assignees->take(4) as $assignee)
                                                    <div class="flex h-7 w-7 items-center justify-center rounded-full border-2 border-white dark:border-slate-800 bg-violet-100 dark:bg-indigo-500/20 text-xs font-semibold text-violet-700 dark:text-indigo-300" title="{{ $assignee->name }}">
                                                        {{ strtoupper(substr($assignee->name, 0, 1)) }}
                                                    </div>
                                                @empty
                                                    <span class="text-xs text-slate-400 dark:text-slate-600">-</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-3 py-3">
                                            @php
                                                $pinClass = match($task->priority) {
                                                    'urgent' => 'pin-urgent',
                                                    'high' => 'pin-high',
                                                    'low' => 'pin-low',
                                                    default => 'pin-medium',
                                                };
                                            @endphp
                                            <span class="priority-pin {{ $pinClass }}">
                                                @if(($task->priority ?? '') === 'urgent')
                                                    <span class="pin-dot inline-block h-2 w-2 rounded-full animate-pulse"></span>
                                                @endif
                                                {{ strtoupper($task->priority ?? 'medium') }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-3 {{ $task->isOverdue() ? 'font-semibold text-rose-600 dark:text-rose-400' : 'text-slate-500 dark:text-slate-300' }}">{{ $task->due_date ? $task->due_date->format('m-d-Y') : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                <div class="dashboard-panel rounded-3xl border border-slate-200/80 dark:border-white/10 bg-white/95 dark:bg-slate-900/50 p-6 shadow-sm backdrop-blur-md transition-all hover:shadow-md">
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Recent Activity</h3>
                        <a href="{{ route('tasks.list') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">View All</a>
                    </div>
                    <ul class="activity-timeline relative space-y-6" style="padding-left: 2px;">
                        @forelse(($recentActivities ?? $recentActivity) as $log)
                            @php
                                $desc = (string) $log->getDescription();
                                $descLower = strtolower($desc);
                                $isAlert = str_contains($descLower, 'overdue') || str_contains($descLower, 'alert') || str_contains($descLower, 'deadline');
                                $isCreate = str_contains($descLower, 'create') || str_contains($descLower, 'added') || str_contains($descLower, 'new');
                                $isStatus = str_contains($descLower, 'status') || str_contains($descLower, 'moved') || str_contains($descLower, 'updated');
                                $dotColor = $isAlert
                                    ? 'background:#f59e0b'
                                    : ($isCreate
                                        ? 'background:#10b981'
                                        : ($isStatus
                                            ? 'background:#3b82f6'
                                            : 'background:#8b5cf6'));
                            @endphp
                            <li class="relative flex items-start gap-4">
                                <div class="timeline-dot" style="{{ str_contains($dotColor, 'background') ? $dotColor : 'background:' . $dotColor }}"></div>
                                <div class="-mt-1 min-w-0 flex-1">
                                    <div class="flex items-start justify-between gap-3">
                                        <p class="text-sm leading-5">
                                            <span class="font-bold text-slate-800 dark:text-white">{{ $log->actor?->name ?? 'System' }}</span>
                                            <span class="text-slate-500 dark:text-slate-300"> {{ $desc }}</span>
                                        </p>
                                        <span class="whitespace-nowrap text-xs italic text-slate-500 dark:text-slate-500">{{ $log->created_at?->diffForHumans() }}</span>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Activity Log Entry</p>
                                </div>
                            </li>
                        @empty
                            <li class="py-5">
                                <div class="flex flex-col items-center rounded-2xl border border-dashed border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 px-5 py-8 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4V9m2 12H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="mt-3 text-sm text-slate-500">No recent activity yet.</p>
                                    <a href="{{ route('tasks.create') }}" class="mt-4 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-500">Get Started</a>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="dashboard-panel rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-md transition-all">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Latest Notifications</h3>
                        <button id="mark-all-notifications-read" type="button" class="rounded-lg border border-slate-200 dark:border-slate-600 px-3 py-1.5 text-xs font-medium text-slate-500 dark:text-slate-300 transition hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-white">Mark all as read</button>
                    </div>
                    <ul id="latest-notifications-list" class="divide-y divide-slate-100 dark:divide-slate-800/50">
                        @forelse($latestNotifications as $notif)
                            <li class="flex items-start justify-between gap-3 py-3 text-sm" data-notification-id="{{ $notif->id }}" data-notification-link="{{ $notif->data['link'] ?? '' }}">
                                <a href="{{ $notif->data['link'] ?? route('dashboard') }}" class="flex-1 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:underline">{{ $notif->data['message'] ?? $notif->data['body'] ?? '-' }}</a>
                                <button type="button" class="mark-notification-read rounded-md p-1 text-slate-400 dark:text-slate-500 transition hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-600 dark:hover:text-white" aria-label="Mark as read" title="Mark as read">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </li>
                        @empty
                            <li class="py-3 text-sm text-slate-500">No notifications</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            </div>{{-- end .px-4.py-3 --}}
        </section>
    </div>
</div>
@php
    $dashboardData = [
        'statusLabelsTransformed' => ['Todo', 'In Progress', 'For Review', 'Done'],
        'chartData' => $chartData ?? $statusCounts,
        'statusCounts' => $statusCounts,
        'tasksPerDayLabelsFormatted' => $tasksPerDayLabelsFormatted,
        'tasksPerDay' => $tasksPerDay,
        'dashboardUrl' => route('dashboard'),
        'unreadNotificationsUrl' => route('dashboard.notifications.unread'),
        'notificationReadUrlTemplate' => route('notifications.read', ['id' => '__ID__']),
        'notificationReadAllUrl' => route('notifications.read-all'),
        'metricsUrl' => route('dashboard.metrics'),
    ];
@endphp
<script id="dashboard-data" type="application/json">@json($dashboardData)</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const payloadEl = document.getElementById('dashboard-data');
    const payload = payloadEl ? JSON.parse(payloadEl.textContent || '{}') : {};

    let statusChart;
    let lineChart;

    if (window.Chart) {
        const statusCtx = document.getElementById('taskStatusChart');
        const lineCtx = document.getElementById('tasksOverTimeChart');

        if (statusCtx) {
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: payload.statusLabelsTransformed || ['Todo', 'In Progress', 'For Review', 'Done'],
                    datasets: [{
                        data: payload.chartData || payload.statusCounts || [],
                        backgroundColor: ['#94a3b8', '#6366f1', '#f59e0b', '#10b981'],
                        borderWidth: 2,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed || 0;
                                    const total = context.dataset.data.reduce((sum, item) => sum + item, 0) || 1;
                                    const pct = Math.round((value / total) * 100);
                                    return `${context.label}: ${value} (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        if (lineCtx) {
            lineChart = new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: payload.tasksPerDayLabelsFormatted || [],
                    datasets: [{
                        label: 'Tasks Created',
                        data: payload.tasksPerDay || [],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.15)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        }
    }

    const notificationsList = document.getElementById('latest-notifications-list');
    const markAllReadButton = document.getElementById('mark-all-notifications-read');

    const updateGlobalNotificationBadge = (unreadCount) => {
        const badge = document.getElementById('global-notification-badge');

        if (!badge) {
            return;
        }

        if (!unreadCount || unreadCount <= 0) {
            badge.classList.add('hidden');
            badge.textContent = '0';
            return;
        }

        badge.classList.remove('hidden');
        badge.textContent = unreadCount > 99 ? '99+' : String(unreadCount);
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const getNotificationReadUrl = (notificationId) => {
        return (payload.notificationReadUrlTemplate || '').replace('__ID__', encodeURIComponent(notificationId));
    };

    const renderNotifications = (items) => {
        if (!notificationsList) {
            return;
        }

        if (!items || items.length === 0) {
            notificationsList.innerHTML = '<li class="py-2 text-gray-400">No notifications</li>';
            updateGlobalNotificationBadge(0);
            return;
        }

        notificationsList.innerHTML = items
            .map(item => `
                <li class="flex items-start justify-between gap-3 py-3 text-sm text-slate-600" data-notification-id="${item.id}" data-notification-link="${item.link ?? ''}">
                    <a href="${item.link || payload.dashboardUrl || '#'}" class="flex-1 text-slate-700 hover:text-blue-600 hover:underline">${item.message ?? '-'}</a>
                    <button type="button" class="mark-notification-read rounded-md p-1 text-blue-200/80 transition hover:bg-slate-100 hover:text-slate-600" aria-label="Mark as read" title="Mark as read">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </li>
            `)
            .join('');
    };

    const refreshNotifications = async () => {
        try {
            const response = await fetch(payload.unreadNotificationsUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (response.status === 401) {
                handleSessionExpired();
                return;
            }

            if (!response.ok) {
                return;
            }

            const dataPayload = await response.json();
            const items = dataPayload.data || [];
            renderNotifications(items);
            updateGlobalNotificationBadge(typeof dataPayload.unread_count === 'number' ? dataPayload.unread_count : items.length);
        } catch (error) {
        }
    };

    const markNotificationAsRead = async (notificationId) => {
        if (!notificationId || !payload.notificationReadUrlTemplate) {
            return;
        }

        try {
            const response = await fetch(getNotificationReadUrl(notificationId), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                return;
            }

            const readPayload = await response.json();
            if (typeof readPayload.unread_count === 'number') {
                updateGlobalNotificationBadge(readPayload.unread_count);
            }

            await refreshNotifications();
        } catch (error) {
        }
    };

    const markAllNotificationsAsRead = async () => {
        if (!payload.notificationReadAllUrl) {
            return;
        }

        try {
            const response = await fetch(payload.notificationReadAllUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                return;
            }

            const readPayload = await response.json();
            if (typeof readPayload.unread_count === 'number') {
                updateGlobalNotificationBadge(readPayload.unread_count);
            }

            renderNotifications([]);
        } catch (error) {
        }
    };

    notificationsList?.addEventListener('click', function (event) {
        const target = event.target instanceof Element ? event.target.closest('.mark-notification-read') : null;
        if (!target) {
            return;
        }

        const item = target.closest('[data-notification-id]');
        const notificationId = item?.getAttribute('data-notification-id');
        if (!notificationId) {
            return;
        }

        markNotificationAsRead(notificationId);
    });

    markAllReadButton?.addEventListener('click', function () {
        markAllNotificationsAsRead();
    });

    const refreshMetrics = async () => {
        if (!payload.metricsUrl) {
            return;
        }

        try {
            const response = await fetch(payload.metricsUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (response.status === 401) {
                handleSessionExpired();
                return;
            }

            if (!response.ok) {
                return;
            }

            const metrics = await response.json();

            if (statusChart && Array.isArray(metrics.chartData || metrics.statusCounts)) {
                statusChart.data.datasets[0].data = metrics.chartData || metrics.statusCounts;
                statusChart.update();
            }

            if (lineChart && Array.isArray(metrics.tasksPerDay) && Array.isArray(metrics.tasksPerDayLabelsFormatted)) {
                lineChart.data.labels = metrics.tasksPerDayLabelsFormatted;
                lineChart.data.datasets[0].data = metrics.tasksPerDay;
                lineChart.update();
            }

            const donePct = document.getElementById('done-percentage');
            const inProgressPct = document.getElementById('in-progress-percentage');

            if (donePct && typeof metrics.donePercentage === 'number') {
                donePct.textContent = `${metrics.donePercentage}%`;
            }

            if (inProgressPct && typeof metrics.inProgressPercentage === 'number') {
                inProgressPct.textContent = `${metrics.inProgressPercentage}%`;
            }
        } catch (error) {
        }
    };

    // Apply progress bar widths from data attributes
    document.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
        const width = parseFloat(bar.getAttribute('data-width')) || 0;
        bar.style.width = width + '%';
    });

    var notifInterval = setInterval(refreshNotifications, 15000);
    var metricsInterval = setInterval(refreshMetrics, 15000);

    function handleSessionExpired() {
        clearInterval(notifInterval);
        clearInterval(metricsInterval);
        window.location.href = '/login';
    }
});

/* ── Sidebar Toggle ── */
function mvToggleSidebar() {
    var wrapper = document.getElementById('mv-sidebar-wrapper');
    var iconOpen = document.getElementById('mv-sidebar-icon-open');
    var iconClose = document.getElementById('mv-sidebar-icon-close');
    if (!wrapper) return;

    var isCollapsed = wrapper.classList.toggle('mv-sidebar-collapsed');

    if (iconOpen && iconClose) {
        iconOpen.classList.toggle('hidden', !isCollapsed);
        iconClose.classList.toggle('hidden', isCollapsed);
    }

    localStorage.setItem('mv-sidebar', isCollapsed ? 'collapsed' : 'open');
}

/* Restore sidebar state - default to open */
(function() {
    var state = localStorage.getItem('mv-sidebar');
    var wrapper = document.getElementById('mv-sidebar-wrapper');
    var iconOpen = document.getElementById('mv-sidebar-icon-open');
    var iconClose = document.getElementById('mv-sidebar-icon-close');

    if (state === 'collapsed') {
        if (wrapper) wrapper.classList.add('mv-sidebar-collapsed');
        if (iconOpen) iconOpen.classList.remove('hidden');
        if (iconClose) iconClose.classList.add('hidden');
    } else {
        // Sidebar open: show close icon, hide hamburger
        localStorage.setItem('mv-sidebar', 'open');
        if (iconOpen) iconOpen.classList.add('hidden');
        if (iconClose) iconClose.classList.remove('hidden');
    }
})();
</script>
@endsection

