@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="relative overflow-hidden rounded-xl border border-slate-200/40 bg-white/90 p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/90">
        <div class="pointer-events-none absolute -left-16 -top-16 h-52 w-52 rounded-full bg-emerald-200/35 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                @php
                    $statusLabel = ucwords(str_replace('_', ' ', $project->status ?? 'pending_request'));
                    $teamLabel = ($project->status ?? 'pending_request') === 'ongoing' ? 'Technical' : 'Sales';
                @endphp
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $project->name }}</h1>
                <p class="text-xs text-slate-550 dark:text-slate-400 mt-0.5">Created by {{ $project->creator?->name ?? 'Unknown' }} · {{ $statusLabel }} ({{ $teamLabel }})</p>
                <p class="text-xs text-slate-550 dark:text-slate-400 mt-0.5">Company Name: {{ $project->company_name ?: '-' }}</p>
                <p class="text-xs text-slate-550 dark:text-slate-400 mt-0.5">Project Owner: {{ $project->project_owner ?: '-' }}</p>
            </div>
            <a href="{{ route('projects.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 px-3 py-1.5 text-[11px] font-semibold text-slate-700 dark:text-slate-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200 hover:-translate-y-0.5">Back to Projects</a>
        </div>
    </div>

    @if($project->description)
        <div class="rounded-xl border border-slate-200/40 bg-white/90 dark:border-slate-800 dark:bg-slate-900/90 p-3 sm:p-4 text-xs text-slate-700 dark:text-slate-300 shadow-sm">
            {{ $project->description }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <div class="rounded-xl border border-slate-200/40 bg-white/90 p-4 dark:border-slate-800 dark:bg-slate-900/90 shadow-sm">
            <h2 class="mb-3 text-sm font-bold text-slate-800 dark:text-slate-100">Project Members</h2>
            @if($project->members->isEmpty())
                <p class="text-xs text-slate-500 dark:text-slate-400">No members assigned.</p>
            @else
                <ul class="divide-y divide-slate-200 dark:divide-slate-800/80">
                    @foreach($project->members as $member)
                        <li class="flex items-center justify-between py-2 text-xs">
                            <span class="text-slate-700 dark:text-slate-300">{{ $member->user?->name ?? 'Unknown User' }}</span>
                            <span class="rounded-full bg-slate-100 dark:bg-slate-800 px-2 py-0.5 text-[10px] font-bold text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">{{ ucfirst($member->role ?? 'member') }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="rounded-xl border border-slate-200/40 bg-white/90 p-4 dark:border-slate-800 dark:bg-slate-900/90 shadow-sm">
            <h2 class="mb-3 text-sm font-bold text-slate-800 dark:text-slate-100">Task List</h2>
            @if($project->tasks->isEmpty())
                <p class="text-xs text-slate-500 dark:text-slate-400">No tasks found for this project.</p>
            @else
                <ul class="divide-y divide-slate-200 dark:divide-slate-800/80">
                    @foreach($project->tasks as $task)
                        @php
                            $taskNumber = $task->task_no ?: sprintf('TSK-%05d', $task->id);
                        @endphp
                        <li class="py-2.5 text-xs">
                            <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between md:gap-4">
                                <div class="min-w-0">
                                    <a href="{{ route('tasks.show', $task) }}" class="font-bold text-blue-600 dark:text-blue-400 hover:underline">{{ $taskNumber }} — {{ $task->title }}</a>
                                    <p class="mt-0.5 text-[10px] text-slate-500 dark:text-slate-400">{{ ucfirst(str_replace('_', ' ', $task->status ?? 'todo')) }} · {{ strtoupper($task->priority ?? 'medium') }}</p>
                                    <p class="mt-1.5 text-[11px] text-slate-600 dark:text-slate-350">
                                        <span class="font-bold text-slate-700 dark:text-slate-300">Deliverables:</span>
                                        {{ $task->deliverables ?: '-' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-1.5 md:justify-end">
                                    @if($task->document_link)
                                        <a href="{{ $task->document_link }}" target="_blank" class="inline-flex items-center gap-1 rounded border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 px-2 py-0.5 text-[10px] font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Attach Files</a>
                                    @else
                                        <span class="inline-flex items-center rounded bg-slate-100 dark:bg-slate-900/40 px-2 py-0.5 text-[10px] font-medium text-slate-450 dark:text-slate-500 border border-slate-200/55 dark:border-slate-800">No attachment</span>
                                    @endif
                                    <a href="{{ route('tasks.kanban') }}" class="inline-flex items-center gap-1 rounded border border-emerald-100 dark:border-emerald-900/50 bg-emerald-50/50 dark:bg-emerald-950/40 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 dark:text-emerald-400 hover:bg-emerald-100/80 dark:hover:bg-emerald-900/50 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">Approve</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
