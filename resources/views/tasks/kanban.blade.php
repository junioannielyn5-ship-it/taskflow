@extends('layouts.app')

@section('content')
<div class="relative space-y-6">
    <div class="pointer-events-none absolute right-0 top-0 h-64 w-64 translate-x-1/3 -translate-y-1/3 rounded-full bg-blue-100/40 blur-3xl dark:hidden"></div>
    <div class="pointer-events-none absolute bottom-0 left-20 h-52 w-52 rounded-full bg-slate-200/30 blur-3xl dark:hidden"></div>

    <div class="relative overflow-visible rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 p-4 shadow-md dark:shadow-none flex gap-4">
        <div class="relative inline-block" id="kanban-project-picker">
            <button
                type="button"
                id="project-toggle-btn"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-600"
            >
                Project
                <span class="text-xs text-slate-500 dark:text-slate-400" id="project-selected-label">All Projects</span>
            </button>
            <div id="project-dropdown" class="absolute left-0 z-20 mt-2 hidden min-w-[260px] rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 p-2 shadow-xl">
                <button type="button" class="project-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700" data-project-id="">All Projects</button>
                @forelse(($projects ?? collect()) as $project)
                    <button
                        type="button"
                        class="project-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700"
                        data-project-id="{{ $project['id'] }}"
                        data-project-name="{{ $project['name'] }}"
                    >
                        {{ $project['name'] }}
                    </button>
                @empty
                    <p class="px-3 py-2 text-xs text-slate-400">No projects available.</p>
                @endforelse
            </div>
        </div>
        <div class="relative inline-block" id="kanban-company-picker">
            <button
                type="button"
                id="company-toggle-btn"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-600"
            >
                Company Name
                <span class="text-xs text-slate-500 dark:text-slate-400" id="company-selected-label">All Companies</span>
            </button>
            <div id="company-dropdown" class="absolute left-0 z-20 mt-2 hidden min-w-[260px] rounded-xl border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 p-2 shadow-xl">
                <button type="button" class="company-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700" data-company-name="">All Companies</button>
                @foreach(['PBI', 'TOYOTA', 'Splash', 'Movaflex'] as $company)
                    <button
                        type="button"
                        class="company-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700"
                        data-company-name="{{ $company }}"
                    >
                        {{ $company }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div id="kanban-board" class="grid grid-cols-1 gap-4 lg:grid-cols-4">
        @php
            $columnMeta = [
                'backlogs' => [
                    'label' => 'Backlog',
                    'headerClass' => 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 border border-red-300 dark:border-red-400/35',
                    'columnClass' => 'border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80',
                    'countClass' => 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-200 border border-red-300 dark:border-red-400/30',
                    'cardClass' => 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800',
                    'emptyClass' => 'border-dashed border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500',
                ],
                'todo' => [
                    'label' => 'To-do',
                    'headerClass' => 'bg-amber-100 dark:bg-orange-500/20 text-amber-700 dark:text-orange-200 border border-amber-300 dark:border-orange-400/35',
                    'columnClass' => 'border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80',
                    'countClass' => 'bg-amber-100 dark:bg-orange-500/20 text-amber-700 dark:text-orange-200 border border-amber-300 dark:border-orange-400/30',
                    'cardClass' => 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800',
                    'emptyClass' => 'border-dashed border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500',
                ],
                'in_progress' => [
                    'label' => 'In-Progress',
                    'headerClass' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-200 border border-blue-300 dark:border-blue-400/35',
                    'columnClass' => 'border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80',
                    'countClass' => 'bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-200 border border-blue-300 dark:border-blue-400/30',
                    'cardClass' => 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800',
                    'emptyClass' => 'border-dashed border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500',
                ],
                'done' => [
                    'label' => 'Done',
                    'headerClass' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-200 border border-emerald-300 dark:border-emerald-400/35',
                    'columnClass' => 'border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/80',
                    'countClass' => 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-200 border border-emerald-300 dark:border-emerald-400/30',
                    'cardClass' => 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800',
                    'emptyClass' => 'border-dashed border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-400 dark:text-slate-500',
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
            <div class="kanban-column rounded-2xl border p-4 shadow-xl {{ $columnMeta[$key]['columnClass'] }}" data-target-status="{{ $targetStatus }}">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="rounded-full px-3 py-1 text-sm font-semibold {{ $columnMeta[$key]['headerClass'] }}">{{ $columnMeta[$key]['label'] }}</h2>
                    <span class="rounded-full px-2 py-0.5 text-xs {{ $columnMeta[$key]['countClass'] }}">{{ $tasks->count() }}</span>
                </div>

                <div class="space-y-3">
                    @forelse ($tasks as $task)
                        @php
                            $isDelayed = $task->isOverdue();
                            $priorityClass = match(strtolower((string) $task->priority)) {
                                'urgent', 'high' => 'bg-red-600 text-white',
                                'medium' => 'bg-orange-500 text-white',
                                default => 'bg-green-600 text-white',
                            };
                            $priorityLabel = strtoupper((string) ($task->priority ?: 'low'));
                            $projectOwner = $task->project?->project_owner ?: 'Sales (Sales Project)';
                            $taskNo = $task->task_no ?: sprintf('TSK-%05d', $task->id);
                            $overdueDays = $isDelayed && $task->due_date ? $task->due_date->diffInDays(now()) : 0;
                        @endphp
                        <div class="kanban-card rounded-xl border p-3 {{ $columnMeta[$key]['cardClass'] }} {{ $isDelayed ? 'ring-1 ring-red-400/60' : '' }} shadow-sm hover:shadow-md dark:shadow-none transition-shadow" data-task-id="{{ $task->id }}" data-project-id="{{ $task->project?->id ?? '' }}" draggable="true">
                            <div class="mb-2 flex items-start justify-between gap-2">
                                <a href="{{ route('tasks.show', $task) }}" class="text-sm font-semibold text-slate-800 dark:text-slate-100 hover:text-blue-600 dark:hover:text-blue-400 hover:underline">{{ $task->title }}</a>
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $priorityClass }}">{{ $priorityLabel }}</span>
                            </div>
                            <div class="space-y-1 text-xs text-slate-500 dark:text-slate-400">
                                <p><span class="font-semibold text-slate-600 dark:text-slate-300">Project:</span> {{ $task->project?->name ?: '-' }}</p>
                                <p><span class="font-semibold text-slate-600 dark:text-slate-300">Task No:</span> {{ $taskNo }}</p>
                                <p><span class="font-semibold text-slate-600 dark:text-slate-300">Due:</span> {{ $task->due_date ? $task->due_date->format('m-d-Y') : '-' }}</p>
                                <p><span class="font-semibold text-slate-600 dark:text-slate-300">Project Owner:</span> {{ $projectOwner }}</p>
                                <p><span class="font-semibold text-slate-600 dark:text-slate-300">Person-in-charge:</span> {{ $task->team_in_charge ?: '-' }}</p>
                                @if($isDelayed)
                                    <p><span class="font-semibold text-rose-500 dark:text-rose-400">Overdue:</span> <span class="text-rose-500 dark:text-rose-400">{{ $overdueDays }} day(s)</span></p>
                                @endif
                            </div>
                        </div>
                    @empty
                        @if($key === 'backlogs')
                            {{-- Example placeholder cards for Backlog --}}
                            @foreach([
                                ['title' => 'Design new landing page', 'priority' => 'MEDIUM', 'pc' => 'bg-orange-500 text-white', 'project' => 'Marketing', 'due' => '05-15-2026', 'pic' => 'Unassigned'],
                                ['title' => 'API integration planning', 'priority' => 'LOW', 'pc' => 'bg-green-600 text-white', 'project' => 'Technical', 'due' => '05-20-2026', 'pic' => 'Unassigned'],
                                ['title' => 'User research & interviews', 'priority' => 'HIGH', 'pc' => 'bg-red-600 text-white', 'project' => 'Product', 'due' => '05-10-2026', 'pic' => 'Unassigned'],
                            ] as $example)
                            <div class="kanban-card rounded-xl border p-3 {{ $columnMeta[$key]['cardClass'] }} shadow-sm opacity-60 pointer-events-none">
                                <div class="mb-2 flex items-start justify-between gap-2">
                                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $example['title'] }}</span>
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $example['pc'] }}">{{ $example['priority'] }}</span>
                                </div>
                                <div class="space-y-1 text-xs text-slate-500 dark:text-slate-400">
                                    <p><span class="font-semibold text-slate-600 dark:text-slate-300">Project:</span> {{ $example['project'] }}</p>
                                    <p><span class="font-semibold text-slate-600 dark:text-slate-300">Due:</span> {{ $example['due'] }}</p>
                                    <p><span class="font-semibold text-slate-600 dark:text-slate-300">Person-in-charge:</span> {{ $example['pic'] }}</p>
                                </div>
                            </div>
                            @endforeach
                            <p class="mt-2 text-center text-[11px] italic text-slate-400 dark:text-slate-500">— Example cards (no real tasks yet) —</p>
                        @else
                            <p class="rounded-xl border border-dashed px-3 py-4 text-center text-xs {{ $columnMeta[$key]['emptyClass'] }}">No tasks in this column.</p>
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
