@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm flex gap-4 dark:bg-slate-800 dark:border-slate-700">
        <div class="relative inline-block" id="kanban-project-picker">
            <button
                type="button"
                id="project-toggle-btn"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-700"
            >
                Project
                <span class="text-xs text-slate-500" id="project-selected-label">All Projects</span>
            </button>
            <div id="project-dropdown" class="absolute left-0 z-20 mt-2 hidden min-w-[260px] rounded-xl border border-slate-200 bg-white p-2 shadow-lg dark:bg-slate-800 dark:border-slate-700">
                <button type="button" class="project-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-700" data-project-id="">All Projects</button>
                @forelse(($projects ?? collect()) as $project)
                    <button
                        type="button"
                        class="project-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-700"
                        data-project-id="{{ $project['id'] }}"
                        data-project-name="{{ $project['name'] }}"
                    >
                        {{ $project['name'] }}
                    </button>
                @empty
                    <p class="px-3 py-2 text-xs text-slate-500">No projects available.</p>
                @endforelse
            </div>
        </div>
        <div class="relative inline-block" id="kanban-company-picker">
            <button
                type="button"
                id="company-toggle-btn"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-700"
            >
                Company Name
                <span class="text-xs text-slate-500" id="company-selected-label">All Companies</span>
            </button>
            <div id="company-dropdown" class="absolute left-0 z-20 mt-2 hidden min-w-[260px] rounded-xl border border-slate-200 bg-white p-2 shadow-lg dark:bg-slate-800 dark:border-slate-700">
                <button type="button" class="company-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-700" data-company-name="">All Companies</button>
                @foreach(['PBI', 'TOYOTA', 'Splash', 'Movaflex'] as $company)
                    <button
                        type="button"
                        class="company-option-btn block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-700"
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
                    'headerClass' => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300',
                    'columnClass' => 'border-red-200 bg-red-50/60 dark:border-red-800/50 dark:bg-red-900/20',
                    'countClass' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
                    'cardClass' => 'border-red-200 bg-red-50 dark:border-red-800/50 dark:bg-red-900/30',
                    'emptyClass' => 'border-red-200 bg-red-50 text-red-700 dark:border-red-800/50 dark:bg-red-900/20 dark:text-red-400',
                ],
                'todo' => [
                    'label' => 'To-do',
                    'headerClass' => 'bg-orange-200 text-orange-900 dark:bg-orange-900/40 dark:text-orange-300',
                    'columnClass' => 'border-orange-300 bg-orange-50/60 dark:border-orange-800/50 dark:bg-orange-900/20',
                    'countClass' => 'bg-orange-200 text-orange-800 dark:bg-orange-900/40 dark:text-orange-300',
                    'cardClass' => 'border-orange-300 bg-orange-50 dark:border-orange-800/50 dark:bg-orange-900/30',
                    'emptyClass' => 'border-orange-300 bg-orange-50 text-orange-800 dark:border-orange-800/50 dark:bg-orange-900/20 dark:text-orange-400',
                ],
                'in_progress' => [
                    'label' => 'In-Progress',
                    'headerClass' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300',
                    'columnClass' => 'border-blue-200 bg-blue-50/60 dark:border-blue-800/50 dark:bg-blue-900/20',
                    'countClass' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                    'cardClass' => 'border-blue-200 bg-blue-50 dark:border-blue-800/50 dark:bg-blue-900/30',
                    'emptyClass' => 'border-blue-200 bg-blue-50 text-blue-700 dark:border-blue-800/50 dark:bg-blue-900/20 dark:text-blue-400',
                ],
                'done' => [
                    'label' => 'Done',
                    'headerClass' => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300',
                    'columnClass' => 'border-green-200 bg-green-50/60 dark:border-green-800/50 dark:bg-green-900/20',
                    'countClass' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300',
                    'cardClass' => 'border-green-200 bg-green-50 dark:border-green-800/50 dark:bg-green-900/30',
                    'emptyClass' => 'border-green-200 bg-green-50 text-green-700 dark:border-green-800/50 dark:bg-green-900/20 dark:text-green-400',
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
            <div class="kanban-column rounded-2xl border p-4 shadow-sm {{ $columnMeta[$key]['columnClass'] }}" data-target-status="{{ $targetStatus }}">
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
                        <div class="kanban-card rounded-xl border p-3 {{ $columnMeta[$key]['cardClass'] }} {{ $isDelayed ? 'ring-1 ring-red-300' : '' }}" data-task-id="{{ $task->id }}" data-project-id="{{ $task->project?->id ?? '' }}" draggable="true">
                            <div class="mb-2 flex items-start justify-between gap-2">
                                <a href="{{ route('tasks.show', $task) }}" class="text-sm font-semibold text-slate-800 hover:text-blue-600 hover:underline dark:text-slate-100">{{ $task->title }}</a>
                                <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $priorityClass }}">{{ $priorityLabel }}</span>
                            </div>
                            <div class="space-y-1 text-xs text-slate-600 dark:text-slate-300">
                                <p><span class="font-semibold">Project:</span> {{ $task->project?->name ?: '-' }}</p>
                                <p><span class="font-semibold">Task No:</span> {{ $taskNo }}</p>
                                <p><span class="font-semibold">Due:</span> {{ $task->due_date ? $task->due_date->format('m-d-Y') : '-' }}</p>
                                <p><span class="font-semibold">Project Owner:</span> {{ $projectOwner }}</p>
                                <p><span class="font-semibold">Person-in-charge:</span> {{ $task->team_in_charge ?: '-' }}</p>
                                @if($isDelayed)
                                    <p><span class="font-semibold text-red-700">Overdue:</span> <span class="text-red-700">{{ $overdueDays }} day(s)</span></p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="rounded-xl border border-dashed px-3 py-4 text-center text-xs {{ $columnMeta[$key]['emptyClass'] }}">No tasks in this column.</p>
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
