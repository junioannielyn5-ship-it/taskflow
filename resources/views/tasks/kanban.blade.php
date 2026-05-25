@extends('layouts.app')

@section('content')
<div class="relative space-y-6 min-h-screen">
    <!-- Dynamic Background Effects -->
    <div class="pointer-events-none absolute right-0 top-0 h-[500px] w-[500px] -translate-y-1/3 translate-x-1/3 rounded-full bg-gradient-to-br from-blue-500/20 to-purple-500/20 blur-[80px] dark:from-blue-600/20 dark:to-purple-600/20"></div>
    <div class="pointer-events-none absolute bottom-0 left-0 h-[400px] w-[400px] -translate-x-1/3 translate-y-1/3 rounded-full bg-gradient-to-tr from-emerald-500/20 to-cyan-500/20 blur-[80px] dark:from-emerald-600/20 dark:to-cyan-600/20"></div>

    {{-- Page Header --}}
    <div class="relative flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6 z-10">
        <div>
            <div class="mb-1 inline-flex items-center rounded-full border border-slate-200/50 bg-white/70 px-2.5 py-0.5 text-[10px] font-semibold tracking-wide text-blue-700 shadow-sm backdrop-blur-md dark:border-slate-700 dark:bg-slate-900/70 dark:text-blue-300">
                <span class="mr-1.5 flex h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                Workflow Management
            </div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Task <span class="text-blue-600 dark:text-blue-400">Kanban</span>
            </h1>
        </div>
        @can('create-task')
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 hover:bg-blue-700 px-3.5 py-1.5 text-xs font-bold text-white shadow-sm transition-all hover:-translate-y-0.5 duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                Create Task
            </a>
        @endcan
    </div>

    <div class="relative overflow-visible rounded-xl border border-slate-200/40 bg-white/80 px-4 py-3 shadow-sm dark:border-slate-800 dark:bg-slate-900/90 flex flex-wrap gap-3 mb-4 z-10">
        <div class="relative inline-block" id="kanban-project-picker">
            <button
                type="button"
                id="project-toggle-btn"
                class="inline-flex items-center gap-1.5 rounded-lg border-0 ring-1 ring-inset ring-slate-300/40 bg-white/70 py-1.5 px-3 text-xs font-semibold text-slate-900 shadow-sm backdrop-blur-sm transition-all hover:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/55 dark:text-white dark:ring-slate-700/50 dark:hover:bg-slate-800"
            >
                <span class="text-[10px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Project:</span>
                <span class="font-bold" id="project-selected-label">All Projects</span>
                <svg class="h-3.5 w-3.5 text-slate-400 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div id="project-dropdown" class="absolute left-0 z-30 mt-1.5 hidden min-w-[220px] rounded-lg border border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95 p-1 shadow-md backdrop-blur-xl">
                <button type="button" class="project-option-btn block w-full rounded-md px-2.5 py-1.5 text-left text-xs font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50" data-project-id="">All Projects</button>
                @forelse(($projects ?? collect()) as $project)
                    <button
                        type="button"
                        class="project-option-btn block w-full rounded-md px-2.5 py-1.5 text-left text-xs font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50"
                        data-project-id="{{ $project['id'] }}"
                        data-project-name="{{ $project['name'] }}"
                    >
                        {{ $project['name'] }}
                    </button>
                @empty
                    <p class="px-2.5 py-1.5 text-[10px] text-slate-400">No projects available.</p>
                @endforelse
            </div>
        </div>
        <div class="relative inline-block" id="kanban-company-picker">
            <button
                type="button"
                id="company-toggle-btn"
                class="inline-flex items-center gap-1.5 rounded-lg border-0 ring-1 ring-inset ring-slate-300/40 bg-white/70 py-1.5 px-3 text-xs font-semibold text-slate-900 shadow-sm backdrop-blur-sm transition-all hover:bg-white focus:ring-2 focus:ring-inset focus:ring-blue-500 dark:bg-slate-900/55 dark:text-white dark:ring-slate-700/50 dark:hover:bg-slate-800"
            >
                <span class="text-[10px] font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">Company:</span>
                <span class="font-bold" id="company-selected-label">All Companies</span>
                <svg class="h-3.5 w-3.5 text-slate-400 ml-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
            </button>
            <div id="company-dropdown" class="absolute left-0 z-30 mt-1.5 hidden min-w-[220px] rounded-lg border border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95 p-1 shadow-md backdrop-blur-xl">
                <button type="button" class="company-option-btn block w-full rounded-md px-2.5 py-1.5 text-left text-xs font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50" data-company-name="">All Companies</button>
                @foreach(['PBI', 'TOYOTA', 'Splash', 'Movaflex'] as $company)
                    <button
                        type="button"
                        class="company-option-btn block w-full rounded-md px-2.5 py-1.5 text-left text-xs font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/50"
                        data-company-name="{{ $company }}"
                    >
                        {{ $company }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div id="kanban-board" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-4">
        @php
            $columnMeta = [
                'backlogs' => [
                    'label' => 'Backlog',
                    'headerClass' => 'bg-red-100 dark:bg-red-500/20 text-red-750 dark:text-red-300 border border-red-200/60 dark:border-red-800',
                    'columnClass' => 'border-slate-200/40 bg-white/40 dark:border-slate-850 dark:bg-slate-900/25',
                    'countClass' => 'bg-red-100 dark:bg-red-500/25 text-red-750 dark:text-red-300 border border-red-200/60 dark:border-red-800',
                    'cardClass' => 'border-slate-200/40 bg-white dark:border-slate-800 dark:bg-slate-900/90 shadow-sm hover:-translate-y-0.5 duration-200',
                    'emptyClass' => 'border-dashed border-slate-200 dark:border-slate-800 bg-white/20 dark:bg-slate-900/20 text-slate-400 dark:text-slate-500',
                ],
                'todo' => [
                    'label' => 'To-do',
                    'headerClass' => 'bg-amber-100 dark:bg-orange-500/20 text-amber-750 dark:text-orange-200 border border-amber-200/60 dark:border-orange-800',
                    'columnClass' => 'border-slate-200/40 bg-white/40 dark:border-slate-850 dark:bg-slate-900/25',
                    'countClass' => 'bg-amber-100 dark:bg-orange-500/25 text-amber-750 dark:text-orange-200 border border-amber-200/60 dark:border-orange-800',
                    'cardClass' => 'border-slate-200/40 bg-white dark:border-slate-800 dark:bg-slate-900/90 shadow-sm hover:-translate-y-0.5 duration-200',
                    'emptyClass' => 'border-dashed border-slate-200 dark:border-slate-800 bg-white/20 dark:bg-slate-900/20 text-slate-400 dark:text-slate-500',
                ],
                'in_progress' => [
                    'label' => 'In-Progress',
                    'headerClass' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-750 dark:text-blue-300 border border-blue-200/60 dark:border-blue-800',
                    'columnClass' => 'border-slate-200/40 bg-white/40 dark:border-slate-850 dark:bg-slate-900/25',
                    'countClass' => 'bg-blue-100 dark:bg-blue-500/25 text-blue-750 dark:text-blue-300 border border-blue-200/60 dark:border-blue-800',
                    'cardClass' => 'border-slate-200/40 bg-white dark:border-slate-800 dark:bg-slate-900/90 shadow-sm hover:-translate-y-0.5 duration-200',
                    'emptyClass' => 'border-dashed border-slate-200 dark:border-slate-800 bg-white/20 dark:bg-slate-900/20 text-slate-400 dark:text-slate-500',
                ],
                'done' => [
                    'label' => 'Done',
                    'headerClass' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-750 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800',
                    'columnClass' => 'border-slate-200/40 bg-white/40 dark:border-slate-850 dark:bg-slate-900/25',
                    'countClass' => 'bg-emerald-100 dark:bg-emerald-500/25 text-emerald-750 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800',
                    'cardClass' => 'border-slate-200/40 bg-white dark:border-slate-800 dark:bg-slate-900/90 shadow-sm hover:-translate-y-0.5 duration-200',
                    'emptyClass' => 'border-dashed border-slate-200 dark:border-slate-800 bg-white/20 dark:bg-slate-900/20 text-slate-400 dark:text-slate-500',
                ],
            ];
        @endphp

        @foreach ($columns as $key => $tasks)
            @php
                $targetStatus = match($key) {
                    'backlogs' => 'blocked',
                    'in_progress' => 'in_progress',
                    'done' => 'done',
                    default => 'todo',
                };
            @endphp
            <div class="kanban-column rounded-xl border p-3 shadow-sm {{ $columnMeta[$key]['columnClass'] }}" data-target-status="{{ $targetStatus }}">
                <div class="mb-3.5 flex items-center justify-between">
                    <h2 class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $columnMeta[$key]['headerClass'] }}">{{ $columnMeta[$key]['label'] }}</h2>
                    <span class="rounded-full px-2 py-0.5 text-[10px] font-bold {{ $columnMeta[$key]['countClass'] }}">{{ $tasks->count() }}</span>
                </div>

                <div class="space-y-2">
                    @forelse ($tasks as $task)
                        @php
                            $isDelayed = $task->isOverdue();
                            $priorityClass = match(strtolower((string) $task->priority)) {
                                'urgent', 'high' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-400 border border-red-200/50 dark:border-red-900/50',
                                'medium' => 'bg-orange-100 text-orange-700 dark:bg-orange-950/40 dark:text-orange-400 border border-orange-200/50 dark:border-orange-900/50',
                                default => 'bg-green-100 text-green-700 dark:bg-green-950/40 dark:text-green-400 border border-green-200/50 dark:border-green-900/50',
                            };
                            $priorityLabel = strtoupper((string) ($task->priority ?: 'low'));
                            $projectOwner = $task->project?->project_owner ?: 'Sales (Sales Project)';
                            $taskNo = $task->task_no ?: sprintf('TSK-%05d', $task->id);
                            $overdueDays = $isDelayed && $task->due_date ? $task->due_date->diffInDays(now()) : 0;
                        @endphp
                        <div class="kanban-card relative z-10 rounded-lg border p-3 {{ $columnMeta[$key]['cardClass'] }} {{ $isDelayed ? 'ring-1 ring-red-500/40 bg-red-50/20 dark:bg-red-950/20' : '' }} transition-all duration-300" data-task-id="{{ $task->id }}" data-project-id="{{ $task->project?->id ?? '' }}" draggable="true">
                            <div class="mb-2 flex items-start justify-between gap-2">
                                <a href="{{ route('tasks.show', $task) }}" class="text-xs font-bold text-slate-850 dark:text-slate-100 hover:text-blue-600 dark:hover:text-blue-400 hover:underline leading-snug">{{ $task->title }}</a>
                                <span class="inline-flex items-center rounded px-1.5 py-0.5 text-[9px] font-bold {{ $priorityClass }}">{{ $priorityLabel }}</span>
                            </div>
                            <div class="space-y-0.5 text-[11px] text-slate-500 dark:text-slate-400">
                                <p><span class="font-bold text-slate-600 dark:text-slate-350">Project:</span> {{ $task->project?->name ?: '-' }}</p>
                                <p><span class="font-bold text-slate-600 dark:text-slate-350">Task No:</span> {{ $taskNo }}</p>
                                <p><span class="font-bold text-slate-600 dark:text-slate-350">Due:</span> {{ $task->due_date ? $task->due_date->format('m-d-Y') : '-' }}</p>
                                <p><span class="font-bold text-slate-600 dark:text-slate-350">Owner:</span> {{ $projectOwner }}</p>
                                <p><span class="font-bold text-slate-600 dark:text-slate-350">PIC:</span> {{ $task->team_in_charge ?: '-' }}</p>
                                @if($isDelayed)
                                    <p><span class="font-bold text-rose-500 dark:text-rose-450">Overdue:</span> <span class="text-rose-500 dark:text-rose-450 font-bold">{{ $overdueDays }} day(s)</span></p>
                                @endif
                            </div>
                        </div>
                    @empty
                        @if($key === 'backlogs')
                            {{-- Example placeholder cards for Backlog --}}
                            @foreach([
                                ['title' => 'Design new landing page', 'priority' => 'MEDIUM', 'pc' => 'bg-orange-100 text-orange-700 dark:bg-orange-950/40 dark:text-orange-400 border border-orange-200/50 dark:border-orange-900/50', 'project' => 'Marketing', 'due' => '05-15-2026', 'pic' => 'Unassigned'],
                                ['title' => 'API integration planning', 'priority' => 'LOW', 'pc' => 'bg-green-100 text-green-700 dark:bg-green-950/40 dark:text-green-400 border border-green-200/50 dark:border-green-900/50', 'project' => 'Technical', 'due' => '05-20-2026', 'pic' => 'Unassigned'],
                                ['title' => 'User research & interviews', 'priority' => 'HIGH', 'pc' => 'bg-red-100 text-red-700 dark:bg-red-950/40 dark:text-red-400 border border-red-200/50 dark:border-red-900/50', 'project' => 'Product', 'due' => '05-10-2026', 'pic' => 'Unassigned'],
                            ] as $example)
                            <div class="kanban-card rounded-lg border p-3 {{ $columnMeta[$key]['cardClass'] }} shadow-sm opacity-60 pointer-events-none">
                                <div class="mb-2 flex items-start justify-between gap-2">
                                    <span class="text-xs font-bold text-slate-800 dark:text-slate-100 leading-snug">{{ $example['title'] }}</span>
                                    <span class="inline-flex items-center rounded px-1.5 py-0.5 text-[9px] font-bold {{ $example['pc'] }}">{{ $example['priority'] }}</span>
                                </div>
                                <div class="space-y-0.5 text-[11px] text-slate-500 dark:text-slate-400">
                                    <p><span class="font-bold text-slate-600 dark:text-slate-350">Project:</span> {{ $example['project'] }}</p>
                                    <p><span class="font-bold text-slate-600 dark:text-slate-350">Due:</span> {{ $example['due'] }}</p>
                                    <p><span class="font-bold text-slate-600 dark:text-slate-350">PIC:</span> {{ $example['pic'] }}</p>
                                </div>
                            </div>
                            @endforeach
                            <p class="mt-2 text-center text-[10px] italic text-slate-400 dark:text-slate-500">— Example cards —</p>
                        @else
                            <p class="rounded-lg border border-dashed px-3 py-4 text-center text-xs {{ $columnMeta[$key]['emptyClass'] }}">No tasks in this column.</p>
                        @endif
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const board = document.getElementById('kanban-board');
    if (!board) {
        return;
    }

    const projectToggleBtn = document.getElementById('project-toggle-btn');
    const projectDropdown = document.getElementById('project-dropdown');
    const projectSelectedLabel = document.getElementById('project-selected-label');
    const projectOptionButtons = document.querySelectorAll('.project-option-btn');

    // Company picker
    const companyToggleBtn = document.getElementById('company-toggle-btn');
    const companyDropdown = document.getElementById('company-dropdown');
    const companySelectedLabel = document.getElementById('company-selected-label');
    const companyOptionButtons = document.querySelectorAll('.company-option-btn');
    // Company dropdown show/hide
    if (companyToggleBtn && companyDropdown) {
        companyToggleBtn.addEventListener('click', () => {
            companyDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            const target = event.target;
            const picker = document.getElementById('kanban-company-picker');
            if (!(target instanceof Element) || !picker || picker.contains(target)) {
                return;
            }
            companyDropdown.classList.add('hidden');
        });
    }

    // Company filter logic
    companyOptionButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const selectedCompany = button.getAttribute('data-company-name') || '';
            const selectedCompanyLabel = selectedCompany || 'All Companies';
            if (companySelectedLabel) {
                companySelectedLabel.textContent = selectedCompanyLabel;
            }
            cards.forEach((card) => {
                // Company name is shown in Project line, so we check text content
                const cardCompany = card.querySelector('.space-y-1 p')?.textContent || '';
                // If company is empty, show all
                const isVisible = selectedCompany === '' || cardCompany.includes(selectedCompany);
                card.classList.toggle('hidden', !isVisible);
            });
            if (companyDropdown) {
                companyDropdown.classList.add('hidden');
            }
        });
    });

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    let draggedCard = null;

    const cards = board.querySelectorAll('.kanban-card');
    const columns = board.querySelectorAll('.kanban-column');

    if (projectToggleBtn && projectDropdown) {
        projectToggleBtn.addEventListener('click', () => {
            projectDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (event) => {
            const target = event.target;
            const picker = document.getElementById('kanban-project-picker');

            if (!(target instanceof Element) || !picker || picker.contains(target)) {
                return;
            }

            projectDropdown.classList.add('hidden');
        });
    }

    projectOptionButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const selectedProjectId = button.getAttribute('data-project-id') || '';
            const selectedProjectName = button.getAttribute('data-project-name') || 'All Projects';

            if (projectSelectedLabel) {
                projectSelectedLabel.textContent = selectedProjectName;
            }

            cards.forEach((card) => {
                const cardProjectId = card.getAttribute('data-project-id') || '';
                const isVisible = selectedProjectId === '' || cardProjectId === selectedProjectId;
                card.classList.toggle('hidden', !isVisible);
            });

            if (projectDropdown) {
                projectDropdown.classList.add('hidden');
            }
        });
    });

    cards.forEach((card) => {
        card.addEventListener('dragstart', () => {
            draggedCard = card;
            card.classList.add('opacity-60');
        });

        card.addEventListener('dragend', () => {
            card.classList.remove('opacity-60');
        });
    });

    columns.forEach((column) => {
        column.addEventListener('dragover', (event) => {
            event.preventDefault();
            column.classList.add('ring-2', 'ring-blue-300');
        });

        column.addEventListener('dragleave', () => {
            column.classList.remove('ring-2', 'ring-blue-300');
        });

        column.addEventListener('drop', async (event) => {
            event.preventDefault();
            column.classList.remove('ring-2', 'ring-blue-300');

            if (!draggedCard) {
                return;
            }

            const taskId = draggedCard.dataset.taskId;
            const targetStatus = column.dataset.targetStatus;

            if (!taskId || !targetStatus) {
                return;
            }

            try {
                const response = await fetch(`{{ route('tasks.update', '__TASK__') }}`.replace('__TASK__', taskId), {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: targetStatus }),
                });

                if (!response.ok) {
                    const payload = await response.json().catch(() => ({}));
                    alert(payload.message || 'Unable to move task to the selected column.');
                    return;
                }

                window.location.reload();
            } catch (error) {
                alert('Unable to update task status right now.');
            }
        });
    });
});
</script>
@endsection
