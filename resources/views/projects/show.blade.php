@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
        <div class="pointer-events-none absolute -left-16 -top-16 h-52 w-52 rounded-full bg-emerald-200/35 blur-3xl"></div>
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                @php
                    $statusLabel = ucwords(str_replace('_', ' ', $project->status ?? 'pending_request'));
                    $teamLabel = ($project->status ?? 'pending_request') === 'ongoing' ? 'Technical' : 'Sales';
                @endphp
                <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">{{ $project->name }}</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Created by {{ $project->creator?->name ?? 'Unknown' }} · {{ $statusLabel }} ({{ $teamLabel }})</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Company Name: {{ $project->company_name ?: '-' }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Project Owner: {{ $project->project_owner ?: '-' }}</p>
            </div>
            <a href="{{ route('projects.index') }}" class="rounded-lg border border-slate-300 dark:border-slate-600 px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:bg-slate-700/50">Back to Projects</a>
        </div>
    </div>

    @if($project->description)
        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 text-sm text-slate-700 dark:text-slate-300 shadow-sm">
            {{ $project->description }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm">
            <h2 class="mb-3 text-lg font-semibold text-slate-800 dark:text-slate-100">Project Members</h2>
            @if($project->members->isEmpty())
                <p class="text-sm text-slate-500 dark:text-slate-400">No members assigned.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach($project->members as $member)
                        <li class="flex items-center justify-between py-2 text-sm">
                            <span class="text-slate-700 dark:text-slate-300">{{ $member->user?->name ?? 'Unknown User' }}</span>
                            <span class="rounded-full bg-slate-100 dark:bg-slate-700 px-2.5 py-1 text-xs font-medium text-slate-600 dark:text-slate-400">{{ ucfirst($member->role ?? 'member') }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-5 shadow-sm">
            <h2 class="mb-3 text-lg font-semibold text-slate-800 dark:text-slate-100">Task List</h2>
            @if($project->tasks->isEmpty())
                <p class="text-sm text-slate-500 dark:text-slate-400">No tasks found for this project.</p>
            @else
                <ul class="divide-y divide-slate-100">
                    @foreach($project->tasks as $task)
                        @php
                            $taskNumber = $task->task_no ?: sprintf('TSK-%05d', $task->id);
                        @endphp
                        <li class="py-3 text-sm">
                            <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between md:gap-4">
                                <div class="min-w-0">
                                    <a href="{{ route('tasks.show', $task) }}" class="font-medium text-blue-600 hover:underline">{{ $taskNumber }} — {{ $task->title }}</a>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ ucfirst(str_replace('_', ' ', $task->status ?? 'todo')) }} · {{ strtoupper($task->priority ?? 'medium') }}</p>
                                    <p class="mt-2 text-xs text-slate-600 dark:text-slate-300">
                                        <span class="font-semibold text-slate-700 dark:text-slate-300">Deliverables:</span>
                                        {{ $task->deliverables ?: '-' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2 md:justify-end">
                                    @if($task->document_link)
                                        <a href="{{ $task->document_link }}" target="_blank" class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-700 px-3 py-1 text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-200">Attach Files</a>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-slate-100 dark:bg-slate-700 px-3 py-1 text-xs font-semibold text-slate-500 dark:text-slate-400">No attachment</span>
                                    @endif
                                    <a href="{{ route('tasks.kanban') }}" class="inline-flex items-center rounded-full bg-emerald-50 dark:bg-emerald-900/300 px-3 py-1 text-xs font-semibold text-white hover:bg-emerald-600">Approve</a>
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
