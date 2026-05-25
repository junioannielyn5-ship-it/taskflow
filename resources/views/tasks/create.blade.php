@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="relative overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
        <div class="pointer-events-none absolute -right-16 -top-16 h-52 w-52 rounded-full bg-cyan-200/35 blur-3xl"></div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Create New Task</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Define scope, assignees, dependencies, and deadline in one workflow.</p>
    </div>

    @php
        $selectedProjectId = old('project_id', request('project_id', $projects->first()?->id));
    @endphp


    @if ($errors->any())
        <div class="mb-4 rounded border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/30 px-4 py-3 text-red-700 dark:text-red-400">
            Please review the highlighted fields and try again.
            <ul class="mt-2 list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="create-task-form" method="POST" action="{{ route('tasks.quickStore') }}" enctype="multipart/form-data" autocomplete="off" class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm" onsubmit="const btn = this.querySelector('button[type=submit]'); setTimeout(() => { btn.disabled = true; btn.textContent = 'Submitting...'; }, 0);">
        @csrf

        <div class="mb-4">
            <label for="task_no" class="block text-gray-700 dark:text-slate-300">Ref. No.</label>
            <input id="task_no" name="task_no" type="text" class="form-input mt-1 block w-full bg-gray-100 dark:bg-slate-700 dark:text-slate-400" placeholder="Auto-generated on save" disabled>
            <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">Auto format: P&lt;Initials&gt;-&lt;ProjectCount&gt;-&lt;TaskNo&gt; (e.g. PLS-0001-0123).</p>
        </div>

        <div class="mb-4">
        </div>

        <div class="mb-4">
            <label for="project_id" class="block text-gray-700 dark:text-slate-300">Project</label>
            <select id="project_id" name="project_id" class="form-input mt-1 block w-full" required>
                <option value="" @selected(empty($selectedProjectId))>Select project</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" @selected((string) $selectedProjectId === (string) $project->id)>{{ $project->name }}</option>
                @endforeach
            </select>
            @error('project_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <input type="hidden" name="title" value="{{ old('title', 'Task Item') }}">

        <div class="mb-4">
            <label for="description" class="block text-gray-700 dark:text-slate-300">Description</label>
            <textarea id="description" name="description" class="form-input mt-1 block w-full" rows="3" autocomplete="off">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="task_process" class="block text-gray-700 dark:text-slate-300">Task Process (Main Category)</label>
            <select id="task_process" name="task_process" class="form-input mt-1 block w-full" required>
                <option value="">Select task process</option>
                @foreach(($taskProcessOptions ?? collect()) as $option)
                    <option value="{{ $option }}" @selected(old('task_process') === $option)>{{ $option }}</option>
                @endforeach
            </select>
            @error('task_process')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">

                <label for="specific_process" class="block text-gray-700 dark:text-slate-300 font-bold">Status (Specific Process)</label>
                <select id="specific_process" name="specific_process" class="form-input mt-1 block w-full font-semibold" required>
                    <option value="">Select specific process</option>
                </select>
                <input type="hidden" id="sla_days" name="sla_days" value="{{ old('sla_days') }}">
                <p id="sla-helper" class="mt-1 text-xs text-gray-700 dark:text-slate-400">SLA is set automatically from Task Process + Specific Process.</p>

            <div id="validity-lead-time-controls" class="mt-3 hidden rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 p-3">
                <label class="inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                    <input id="use_quotation_validity" name="use_quotation_validity" type="checkbox" class="h-4 w-4 rounded border-slate-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500">
                    Adjust lead time based on quotation validity date
                </label>
                <div class="mt-2">
                    <label for="quotation_validity_date" class="block text-xs font-medium text-slate-600 dark:text-slate-400">Quotation Validity Date</label>
                    <input id="quotation_validity_date" name="quotation_validity_date" type="date" class="form-input mt-1 block w-full" disabled>
                </div>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">If enabled, due date and SLA days follow the quotation validity date.</p>
            </div>

            @error('specific_process')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('sla_days')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
        </div>

        <div class="mb-4">
            <label for="team_in_charge" class="block text-gray-700 dark:text-slate-300">Person-in-Charge (PIC)</label>
            <select id="team_in_charge" name="team_in_charge" class="form-input mt-1 block w-full" required>
                <option value="" @selected(old('team_in_charge') === null)>Select person-in-charge</option>
                @foreach(($personInChargeDirectory ?? []) as $department => $people)
                    <optgroup label="{{ $department }}">
                        @foreach($people as $person)
                            <option value="{{ $person }}" @selected(old('team_in_charge') === $person)>{{ $person }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            @if(!empty($personInChargeDirectory))
                <!-- Person-in-charge Directory hidden -->
            @endif
            @error('team_in_charge')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="team" class="block text-gray-700 dark:text-slate-300">Team <span class="text-red-500">*</span></label>
            <select id="team" name="team" class="form-input mt-1 block w-full" required>
                <option value="" @selected(old('team') === null)>Select team</option>
                <option value="sales" @selected(old('team') === 'sales')>Sales</option>
                <option value="technical" @selected(old('team') === 'technical')>Technical</option>
                <option value="pre_sales" @selected(old('team') === 'pre_sales')>Pre-Sales</option>
                <option value="admin" @selected(old('team') === 'admin')>Admin Support</option>
            </select>
            @error('team')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="document_link" class="block text-gray-700 dark:text-slate-300">Document Link / Proof of File</label>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Paste a URL <span class="font-semibold">or</span> upload a file — uploading a file will override the URL field.</p>
            <div class="flex gap-2 items-center mt-1">
                <input
                    id="document_link"
                    type="url"
                    name="document_link"
                    class="form-input block w-full"
                    value="{{ old('document_link') }}"
                    placeholder="https://..."
                >
                <label for="document_file" class="flex-shrink-0 cursor-pointer inline-flex items-center gap-1 rounded border border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 px-3 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600 focus-within:ring-2 focus-within:ring-blue-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                    Attach File
                    <input id="document_file" type="file" name="document_file" class="sr-only"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg,.gif,.zip">
                </label>
            </div>
            <p id="document_file_name" class="mt-1 text-xs text-blue-600 hidden"></p>
            @error('document_link')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('document_file')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="deliverables" class="block text-gray-700 dark:text-slate-300">Deliverables</label>
            <input
                id="deliverables"
                type="text"
                name="deliverables"
                class="form-input pointer-events-auto mt-1 block w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2 text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-500/30"
                value="{{ old('deliverables') }}"
                placeholder="e.g. Test Report, Quotation, COC"
                autocomplete="off"
            >
            @error('deliverables')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="remarks" class="block text-gray-700 dark:text-slate-300">Remarks</label>
            <textarea
                id="remarks"
                name="remarks"
                class="form-input pointer-events-auto mt-1 block w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2 text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-500/30"
                rows="2"
                placeholder="e.g. For review / Waiting for samples"
            >{{ old('remarks') }}</textarea>
            @error('remarks')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="assignee-search" class="block text-gray-700 dark:text-slate-300">Attention</label>
            <input
                id="assignee-search"
                name="assignee_search"
                type="text"
                class="form-input mt-1 block w-full rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-500/30"
                placeholder="Type assignee name then press Enter to assign..."
                autocomplete="off"
            >
            <div id="assignees" class="mt-1 max-h-48 overflow-y-auto rounded border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 p-2"></div>
            <p id="assignees-helper" class="mt-1 text-xs text-red-600 font-semibold">Attension: Select at least one assignee.</p>
            @error('assignees')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('assignees.*')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        

        <div class="mb-4">
            <!-- Ref. No. field moved above -->
            <label for="dependency_type" class="block text-gray-700 dark:text-slate-300">Dependency Type</label>
            <select id="dependency_type" name="dependency_type" class="form-input mt-1 block w-full">
                <option value="">N/A</option>
                <option value="CREATE REFERENCE">Create Task Reference</option>
            </select>
            @error('dependency_type')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div id="reference-inline-form" class="transition-all duration-300 ease-in-out hidden">
            <div class="p-4 bg-cyan-50 dark:bg-cyan-900/20 border border-cyan-200 dark:border-cyan-700 rounded-xl mt-2">
                <h4 class="text-sm font-bold text-cyan-700 dark:text-cyan-400 mb-2">Reference Task Details</h4>
                <div class="mb-2">
                    <label for="reference_task_no_input" class="block text-gray-700 dark:text-slate-300">Ref. No.</label>
                    <input id="reference_task_no_input" name="reference_task_no" type="text" class="form-input mt-1 block w-full bg-gray-100 dark:bg-slate-700 dark:text-slate-400" value="Auto-generated on save" disabled>
                    <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">Auto format: P&lt;Initials&gt;-&lt;ProjectCount&gt;-&lt;TaskNo&gt; (e.g. PLS-0001-0123).</p>
                </div>
                <div class="mb-2">
                    <label for="reference_description_input" class="block text-gray-700 dark:text-slate-300">Description</label>
                    <textarea id="reference_description_input" name="reference_description" class="form-input mt-1 block w-full" rows="2" autocomplete="off"></textarea>
                </div>
                <div class="mb-2">
                    <label for="reference_project_id_select" class="block text-gray-700 dark:text-slate-300">Project</label>
                    <select id="reference_project_id_select" name="reference_project_id" class="form-input mt-1 block w-full">
                        <option value="">Select project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label for="reference_task_process_select" class="block text-gray-700 dark:text-slate-300">Task Process (Main Category)</label>
                    <select id="reference_task_process_select" name="reference_task_process" class="form-input mt-1 block w-full">
                        <option value="">Select task process</option>
                        @foreach(($taskProcessOptions ?? collect()) as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label for="reference_attention_select" class="block text-gray-700 dark:text-slate-300">Attention</label>
                    <select id="reference_attention_select" name="reference_attention[]" class="form-input mt-1 block w-full" multiple>
                        <option value="{{ auth()->user()->name }}" selected>Creator: {{ auth()->user()->name }}</option>
                        @foreach(($personInChargeDirectory ?? []) as $department => $people)
                            <optgroup label="{{ $department }}">
                                @foreach($people as $person)
                                    <option value="{{ $person }}">{{ $person }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">The creator of the reference is automatically included. You can add other team members.</p>
                </div>
                <div class="mb-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="reference_date_received" class="block text-gray-700 dark:text-slate-300">Date Received</label>
                        <input id="reference_date_received" name="reference_date_received" type="date" class="form-input mt-1 block w-full" value="{{ old('reference_date_received', date('Y-m-d')) }}">
                    </div>
                    <div>
                        <label for="reference_date_started" class="block text-gray-700 dark:text-slate-300">Date Started</label>
                        <input id="reference_date_started" name="reference_date_started" type="date" class="form-input mt-1 block w-full">
                    </div>
                    <div>
                        <label for="reference_target_deadline" class="block text-gray-700 dark:text-slate-300">Target Deadline</label>
                        <input id="reference_target_deadline" name="reference_target_deadline" type="date" class="form-input mt-1 block w-full" readonly>
                        <p class="mt-1 text-xs text-gray-500 dark:text-slate-400">Automatically 10 days from Date Received.</p>
                    </div>
                </div>
                <p class="mt-1 text-xs text-blue-600">When Person-in-Charge and Attention are selected, they will receive a notification and email alert.</p>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const dateReceived = document.getElementById('reference_date_received');
                    const targetDeadline = document.getElementById('reference_target_deadline');
                    if (dateReceived) {
                        // Set to today if empty
                        if (!dateReceived.value) {
                            const today = new Date();
                            const yyyy = today.getFullYear();
                            const mm = String(today.getMonth() + 1).padStart(2, '0');
                            const dd = String(today.getDate()).padStart(2, '0');
                            dateReceived.value = `${yyyy}-${mm}-${dd}`;
                        }
                    }
                    if(dateReceived && targetDeadline) {
                        dateReceived.addEventListener('change', function() {
                            if (this.value) {
                                const receivedDate = new Date(this.value);
                                receivedDate.setDate(receivedDate.getDate() + 10);
                                const yyyy = receivedDate.getFullYear();
                                const mm = String(receivedDate.getMonth() + 1).padStart(2, '0');
                                const dd = String(receivedDate.getDate()).padStart(2, '0');
                                targetDeadline.value = `${yyyy}-${mm}-${dd}`;
                            } else {
                                targetDeadline.value = '';
                            }
                        });
                    }
                });
                </script>
            </div>
        </div>

        <div class="mb-4">
            <label for="priority" class="block text-gray-700 dark:text-slate-300">Priority</label>
            <select id="priority" name="priority" class="form-input mt-1 block w-full" required>
                <option value="low" @selected(old('priority') === 'low')>Low</option>
                <option value="medium" @selected(old('priority', 'medium') === 'medium')>Medium</option>
                <option value="high" @selected(old('priority') === 'high')>High</option>
                <option value="urgent" @selected(old('priority') === 'urgent')>Urgent</option>
            </select>
            @error('priority')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="date_received" class="block text-gray-700 dark:text-slate-300">Date Received</label>
            <input id="date_received" type="date" name="date_received" class="form-input mt-1 block w-full" value="{{ old('date_received', date('Y-m-d')) }}">
            @error('date_received')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="date_started" class="block text-gray-700 dark:text-slate-300">Date Started</label>
            <input id="date_started" type="date" name="date_started" class="form-input mt-1 block w-full" value="{{ old('date_started') }}">
            @error('date_started')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="target_deadline" class="block text-gray-700 dark:text-slate-300">Target Deadline</label>
            <input id="target_deadline" type="date" name="target_deadline" class="form-input mt-1 block w-full" value="{{ old('target_deadline', \Carbon\Carbon::now()->addDays(10)->format('Y-m-d')) }}">
            @error('target_deadline')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
        </div>

        <button type="submit" id="submit-task" class="rounded-lg bg-cyan-600 px-4 py-2 font-semibold text-white hover:bg-cyan-700">Create Task</button>
    </form>
    @if (session('success'))
        <script>
            window.location.href = "{{ route('tasks.kanban') }}";
        </script>
    @endif
</div>

@php
    $taskCreateData = [
        'projectMembers' => $projectMembers,
        'projectDefaultAssignees' => $projectDefaultAssignees,
        'projectTasks' => $projectTasks,
        'projectPrefixes' => $projectPrefixes,
        'nextTaskSequence' => $nextTaskSequence ?? 1,
        'processCatalog' => $processCatalog,
        'selectedTaskProcess' => old('task_process'),
        'selectedSpecificProcess' => old('specific_process'),
        'selectedAssignees' => old('assignees', $defaultSelectedAssignees ?? []),
        'selectedDependency' => old('blocked_by_task_id'),
        'currentUserId' => auth()->id(),
        'taskCreated' => session()->has('success'),
        'taskCreatedMessage' => session('success'),
    ];
@endphp
<script id="task-create-data" type="application/json">@json($taskCreateData)</script>

@include('partials.sweetalert2-local')
<script>
document.addEventListener('DOMContentLoaded', function () {
        // DEBUG LOGGING FOR TROUBLESHOOTING DROPDOWN OPTIONS
        try {
            const payloadEl = document.getElementById('task-create-data');
            const payload = payloadEl ? JSON.parse(payloadEl.textContent || '{}') : {};
            console.log("1. Full Process Catalog Content:", payload.processCatalog);

            const taskProcessSelect = document.getElementById('task_process');
            console.log("2. Selected Main Process Value:", `'${taskProcessSelect.value}'`);

            if (payload.processCatalog && payload.processCatalog[taskProcessSelect.value]) {
                console.log("✅ MATCH FOUND! Options:", payload.processCatalog[taskProcessSelect.value]);
            } else {
                console.error("❌ NO MATCH: Walang nahanap na options para sa value na iyan.");
                console.log("Available Keys in Catalog:", Object.keys(payload.processCatalog || {}));
            }
        } catch (e) {
            console.error("[DEBUG] Error while checking processCatalog matching:", e);
        }
    // --- File upload display ---
    const docFileInput = document.getElementById('document_file');
    const docFileNameEl = document.getElementById('document_file_name');
    const docLinkInput = document.getElementById('document_link');
    if (docFileInput) {
        docFileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                docFileNameEl.textContent = 'Selected: ' + this.files[0].name;
                docFileNameEl.classList.remove('hidden');
                docLinkInput.value = '';
                docLinkInput.removeAttribute('required');
            } else {
                docFileNameEl.classList.add('hidden');
                docFileNameEl.textContent = '';
            }
        });
    }

    const payloadEl = document.getElementById('task-create-data');
    const payload = payloadEl ? JSON.parse(payloadEl.textContent || '{}') : {};
    const projectMembersMap = payload.projectMembers || {};
    const projectDefaultAssigneesMap = payload.projectDefaultAssignees || {};
    const projectTasksMap = payload.projectTasks || {};
    const processCatalog = payload.processCatalog || {};
    const projectPrefixes = payload.projectPrefixes || {};
    const nextTaskSequence = payload.nextTaskSequence || 1;
    const selectedTaskProcess = payload.selectedTaskProcess || '';
    const selectedSpecificProcess = payload.selectedSpecificProcess || '';
    const selectedAssignees = payload.selectedAssignees || [];
    const selectedDependency = payload.selectedDependency || '';
    const currentUserId = String(payload.currentUserId || '');
    const projectSelect = document.getElementById('project_id');
    const assigneesContainer = document.getElementById('assignees');
    const assigneeSearchInput = document.getElementById('assignee-search');
    const assigneesHelper = document.getElementById('assignees-helper');
    const dependencySelect = document.getElementById('blocked_by_task_id');
    const taskProcessSelect = document.getElementById('task_process');
    const specificProcessSelect = document.getElementById('specific_process');
    const slaDaysInput = document.getElementById('sla_days');
    const slaHelper = document.getElementById('sla-helper');
    const validityLeadTimeControls = document.getElementById('validity-lead-time-controls');
    const useQuotationValidityCheckbox = document.getElementById('use_quotation_validity');
    const quotationValidityDateInput = document.getElementById('quotation_validity_date');
    const form = projectSelect ? projectSelect.closest('form') : null;
    const dateReceivedInput = form ? form.querySelector('input[name="date_received"]') : null;
    const dateStartedInput = form ? form.querySelector('input[name="date_started"]') : null;
    const dueDateInput = form ? form.querySelector('input[name="due_date"]') : null;
    const dependencyLockHelper = document.getElementById('dependency-lock-helper');
    const validityBasedSpecificProcess = 'Proposal/Quotation - For end-user evaluation';

    let selectedAssigneeValues = selectedAssignees.map(String);
    let initialSpecificProcess = selectedSpecificProcess;

    const hiddenAssigneesContainer = document.createElement('div');
    hiddenAssigneesContainer.id = 'assignee-hidden-inputs';
    hiddenAssigneesContainer.className = 'hidden';
    if (form) {
        form.appendChild(hiddenAssigneesContainer);
    }

    const updateReferencePreview = () => {
        const previewInput = document.getElementById('task_no');
        if (!previewInput) return;
        
        const projId = projectSelect ? projectSelect.value : null;
        if (projId && projectPrefixes[projId]) {
            const prefix = projectPrefixes[projId];
            const sequence = String(nextTaskSequence).padStart(4, '0');
            previewInput.value = `${prefix}-${sequence}`;
        } else {
            previewInput.value = '';
            previewInput.placeholder = 'Auto-generated on save';
        }
    };

    if (projectSelect) {
        projectSelect.addEventListener('change', () => {
            renderAssignees(projectSelect.value);
            updateReferencePreview();
        });
    }

    const syncHiddenAssigneeInputs = () => {
        if (!hiddenAssigneesContainer) {
            return;
        }

        hiddenAssigneesContainer.innerHTML = '';
        selectedAssigneeValues.forEach((assigneeId) => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'assignees[]';
            hiddenInput.value = String(assigneeId);
            hiddenAssigneesContainer.appendChild(hiddenInput);
        });
    };

    const updateAssigneeHelperState = () => {
        if (!assigneesHelper) {
            return;
        }

        if (selectedAssigneeValues.length > 0) {
            assigneesHelper.classList.remove('text-red-600');
            assigneesHelper.classList.add('text-gray-500');
            assigneesHelper.textContent = `Selected ${selectedAssigneeValues.length} assignee(s).`;
            return;
        }

        assigneesHelper.classList.remove('text-gray-500');
        assigneesHelper.classList.add('text-red-600');
        assigneesHelper.textContent = 'Select at least one assignee.';
    };

    const renderAssignees = (projectId) => {
        assigneesContainer.innerHTML = '';

        const members = projectMembersMap[String(projectId)] || [];
        const searchTerm = (assigneeSearchInput ? assigneeSearchInput.value : '').trim().toLowerCase();

        if (members.length === 0) {
            assigneesContainer.innerHTML = '<p class="text-sm text-slate-500 dark:text-slate-400">No assignable members in this project yet.</p>';
            selectedAssigneeValues = [];
            syncHiddenAssigneeInputs();
            updateAssigneeHelperState();
            return;
        }

        const allowedMemberIds = members.map((member) => String(member.id));
        selectedAssigneeValues = selectedAssigneeValues.filter((id) => allowedMemberIds.includes(id));

        syncHiddenAssigneeInputs();

        const filteredMembers = searchTerm === ''
            ? members
            : members.filter((member) => String(member.name || '').toLowerCase().includes(searchTerm));

        if (filteredMembers.length === 0) {
            assigneesContainer.innerHTML = '<p class="text-sm text-slate-500 dark:text-slate-400">No assignee matched your search.</p>';
            updateAssigneeHelperState();
            return;
        }

        filteredMembers.forEach((member) => {
            const row = document.createElement('label');
            row.htmlFor = 'assignee-' + member.id;
            row.className = 'flex items-center gap-2 rounded px-2 py-1.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700';

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.id = 'assignee-' + member.id;
            checkbox.name = 'assignees[]';
            checkbox.value = String(member.id);
            checkbox.className = 'h-4 w-4 rounded border-slate-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500';
            checkbox.checked = selectedAssigneeValues.includes(String(member.id));

            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    if (!selectedAssigneeValues.includes(checkbox.value)) {
                        selectedAssigneeValues.push(checkbox.value);
                    }
                } else {
                    selectedAssigneeValues = selectedAssigneeValues.filter((id) => id !== checkbox.value);
                }

                syncHiddenAssigneeInputs();
                updateAssigneeHelperState();
            });

            const text = document.createElement('span');
            text.textContent = member.name;

            row.appendChild(checkbox);
            row.appendChild(text);
            assigneesContainer.appendChild(row);
        });

        updateAssigneeHelperState();
    };

    // const renderDependencies = (projectId) => {};

    const hasCompleteScheduleDates = () => {
        return Boolean(
            dateReceivedInput && dateReceivedInput.value
            && dateStartedInput && dateStartedInput.value
            && dueDateInput && dueDateInput.value
        );
    };

    const updateDependencyLockState = () => {
        // IDAGDAG ITONG LINE NA ITO:
        if (!dependencySelect) return;
        dependencySelect.disabled = false;
        if (!dependencyLockHelper) {
            return;
        }
        dependencyLockHelper.classList.remove('text-red-600');
        dependencyLockHelper.classList.add('text-gray-500');
        dependencyLockHelper.textContent = 'Optional: select a task that must be completed first.';
    };

    const toIsoDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    const applyDueDateFromSla = () => {
        if (!dateStartedInput || !dueDateInput || !slaDaysInput || !slaDaysInput.value) {
            return;
        }

        if (!dateStartedInput.value) {
            return;
        }

        const startDate = new Date(`${dateStartedInput.value}T00:00:00`);
        if (Number.isNaN(startDate.getTime())) {
            return;
        }

        startDate.setDate(startDate.getDate() + Number(slaDaysInput.value));
        dueDateInput.value = toIsoDate(startDate);
    };

    const applyDueDateFromValidityDate = () => {
        if (!dateStartedInput || !dueDateInput || !slaDaysInput || !quotationValidityDateInput || !useQuotationValidityCheckbox) {
            return;
        }

        if (!useQuotationValidityCheckbox.checked || !quotationValidityDateInput.value || !dateStartedInput.value) {
            return;
        }

        const startDate = new Date(`${dateStartedInput.value}T00:00:00`);
        const validityDate = new Date(`${quotationValidityDateInput.value}T00:00:00`);

        if (Number.isNaN(startDate.getTime()) || Number.isNaN(validityDate.getTime())) {
            return;
        }

        const millis = validityDate.getTime() - startDate.getTime();
        const dayDiff = Math.max(1, Math.ceil(millis / 86400000));

        slaDaysInput.value = String(dayDiff);
        dueDateInput.value = toIsoDate(validityDate);
    };

    const normalizeProcessKey = (value) => String(value || '').trim().toLowerCase();

    const getProcessOptions = (processName) => {
        if (!processName) return [];
        // Always use normalized matching for robustness
        const normalize = v => String(v || '').trim().toLowerCase();
        const target = normalize(processName);
        const matchedKey = Object.keys(processCatalog).find(key => normalize(key) === target);
        if (matchedKey && Array.isArray(processCatalog[matchedKey])) {
            return processCatalog[matchedKey];
        }
        return [{ name: 'General', sla_days: 1 }];
    };

    const renderSpecificProcessOptions = () => {
        if (!taskProcessSelect || !specificProcessSelect) {
            return;
        }

        const selectedProcess = taskProcessSelect.value;
        const options = getProcessOptions(selectedProcess);
        const previousSelection = specificProcessSelect.value || initialSpecificProcess;

        specificProcessSelect.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = 'Select specific process';
        specificProcessSelect.appendChild(placeholder);

        options.forEach((item) => {
            const option = document.createElement('option');
            option.value = item.name;
            option.textContent = `${item.name} (SLA ${item.sla_days} day/s)`;
            if (previousSelection === item.name) {
                option.selected = true;
            }
            specificProcessSelect.appendChild(option);
        });

        if (!specificProcessSelect.value && options.length > 0) {
            specificProcessSelect.value = options[0].name;
        }

        const selectedOption = options.find((item) => item.name === specificProcessSelect.value) || null;
        slaDaysInput.value = selectedOption ? String(selectedOption.sla_days) : '';

        const allowsValidityLeadTime = selectedOption && selectedOption.name === validityBasedSpecificProcess;

        if (validityLeadTimeControls) {
            validityLeadTimeControls.classList.toggle('hidden', !allowsValidityLeadTime);
        }

        if (!allowsValidityLeadTime && useQuotationValidityCheckbox && quotationValidityDateInput) {
            useQuotationValidityCheckbox.checked = false;
            quotationValidityDateInput.value = '';
            quotationValidityDateInput.disabled = true;
        }

        if (allowsValidityLeadTime && useQuotationValidityCheckbox && quotationValidityDateInput) {
            quotationValidityDateInput.disabled = !useQuotationValidityCheckbox.checked;
        }

        if (slaHelper) {
            slaHelper.textContent = selectedOption
                ? `SLA set to ${selectedOption.sla_days} day/s.`
                : 'SLA is set automatically from Task Process + Specific Process.';
        }

        if (allowsValidityLeadTime && useQuotationValidityCheckbox && useQuotationValidityCheckbox.checked) {
            applyDueDateFromValidityDate();
        } else {
            applyDueDateFromSla();
        }
        initialSpecificProcess = '';
    };

    updateDependencyLockState();

    if (projectSelect) {
        renderAssignees(projectSelect.value);
        updateReferencePreview();
    }

    if (taskProcessSelect && selectedTaskProcess) {
        taskProcessSelect.value = selectedTaskProcess;
    }

    renderSpecificProcessOptions();

    if (assigneeSearchInput) {
        assigneeSearchInput.addEventListener('input', () => {
            renderAssignees(projectSelect.value);
        });

        assigneeSearchInput.addEventListener('keydown', (event) => {
            if (event.key !== 'Enter') {
                return;
            }

            event.preventDefault();

            const firstVisibleCheckbox = assigneesContainer.querySelector('input[type="checkbox"]');

            if (!firstVisibleCheckbox) {
                return;
            }

            if (!firstVisibleCheckbox.checked) {
                firstVisibleCheckbox.checked = true;
                firstVisibleCheckbox.dispatchEvent(new Event('change'));
            }

            assigneeSearchInput.value = '';
            renderAssignees(projectSelect.value);
        });
    }

    if (taskProcessSelect) {
        taskProcessSelect.addEventListener('change', () => {
            if (specificProcessSelect) {
                specificProcessSelect.value = '';
            }
            renderSpecificProcessOptions();
        });
    }

    if (specificProcessSelect) {
        specificProcessSelect.addEventListener('change', () => {
            renderSpecificProcessOptions();
        });
    }

    if (dateStartedInput) {
        dateStartedInput.addEventListener('change', () => {
            if (useQuotationValidityCheckbox && useQuotationValidityCheckbox.checked) {
                applyDueDateFromValidityDate();
                updateDependencyLockState();
                return;
            }

            applyDueDateFromSla();
            updateDependencyLockState();
        });
    }

    if (dateReceivedInput) {
        dateReceivedInput.addEventListener('change', () => {
            updateDependencyLockState();
        });
    }

    if (dueDateInput) {
        dueDateInput.addEventListener('change', () => {
            updateDependencyLockState();
        });
    }

    if (useQuotationValidityCheckbox && quotationValidityDateInput) {
        useQuotationValidityCheckbox.addEventListener('change', () => {
            quotationValidityDateInput.disabled = !useQuotationValidityCheckbox.checked;

            if (!useQuotationValidityCheckbox.checked) {
                quotationValidityDateInput.value = '';
                renderSpecificProcessOptions();
                return;
            }

            applyDueDateFromValidityDate();
        });

        quotationValidityDateInput.addEventListener('change', () => {
            applyDueDateFromValidityDate();
            updateDependencyLockState();
        });
    }

    projectSelect.addEventListener('change', () => {
        if (assigneeSearchInput) {
            assigneeSearchInput.value = '';
        }
        selectedAssigneeValues = [];
        renderAssignees(projectSelect.value);
        // renderDependencies(projectSelect.value); // removed
        updateDependencyLockState();
    });

    updateAssigneeHelperState();

    if (form) {
        form.addEventListener('submit', (event) => {
            if (selectedAssigneeValues.length > 0) {
                return;
            }

            event.preventDefault();
            updateAssigneeHelperState();
            assigneesContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }

    if (payload.taskCreated && window.Swal) {
        window.Swal.fire({
            icon: 'success',
            title: 'Task Created',
            text: payload.taskCreatedMessage || 'Task created successfully.',
            timer: 1800,
            showConfirmButton: false,
        });
    }

    // Show all validation errors in a browser alert for easier debugging
    const errorAlert = document.querySelector('.mb-4.rounded.border-red-200');
    if (errorAlert) {
        let errorList = errorAlert.querySelectorAll('li');
        if (errorList.length > 0) {
            let messages = Array.from(errorList).map(li => li.textContent.trim()).join('\n');
            alert('Task Form Validation Errors:\n' + messages);
            // Also log to console for devs
            console.error('Task Form Validation Errors:', messages);
        }
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const dependencyTypeSelect = document.getElementById('dependency_type');
    const referenceForm = document.getElementById('reference-inline-form');

    function syncMainToReference() {
        // Description
        const mainDesc = document.getElementById('description');
        const refDesc = document.getElementById('reference_description_input');
        if (mainDesc && refDesc) refDesc.value = mainDesc.value;

        // Project
        const mainProject = document.getElementById('project_id');
        const refProject = document.getElementById('reference_project_id_select');
        if (mainProject && refProject) refProject.value = mainProject.value;

        // Task Process
        const mainProcess = document.getElementById('task_process');
        const refProcess = document.getElementById('reference_task_process_select');
        if (mainProcess && refProcess) refProcess.value = mainProcess.value;

        // Date Received
        const mainDateReceived = document.getElementById('date_received');
        const refDateReceived = document.getElementById('reference_date_received');
        if (mainDateReceived && refDateReceived && mainDateReceived.value) {
            refDateReceived.value = mainDateReceived.value;
            refDateReceived.dispatchEvent(new Event('change'));
        }

        // Attention — sync checked assignees by name
        const assigneesBox = document.getElementById('assignees');
        const refAttention = document.getElementById('reference_attention_select');
        if (assigneesBox && refAttention) {
            const checkedBoxes = assigneesBox.querySelectorAll('input[type="checkbox"]:checked');
            const selectedNames = Array.from(checkedBoxes).map(function(cb) {
                const lbl = cb.closest('label');
                const sp = lbl ? lbl.querySelector('span') : null;
                return sp ? sp.textContent.trim() : null;
            }).filter(Boolean);
            Array.from(refAttention.options).forEach(function(opt) {
                opt.selected = selectedNames.includes(opt.value);
            });
        }
    }

    function isReferenceActive() {
        return dependencyTypeSelect && dependencyTypeSelect.value === 'CREATE REFERENCE';
    }

    // Live sync: whenever main fields change, update reference if active
    ['description', 'project_id', 'task_process', 'date_received'].forEach(function(fieldId) {
        const el = document.getElementById(fieldId);
        if (el) {
            el.addEventListener('change', function() { if (isReferenceActive()) syncMainToReference(); });
            el.addEventListener('input', function() { if (isReferenceActive()) syncMainToReference(); });
        }
    });

    // Live sync: when assignees are toggled
    const assigneesBox = document.getElementById('assignees');
    if (assigneesBox) {
        assigneesBox.addEventListener('change', function() { if (isReferenceActive()) syncMainToReference(); });
    }

    if (dependencyTypeSelect && referenceForm) {
        dependencyTypeSelect.addEventListener('change', function () {
            if (this.value === 'CREATE REFERENCE') {
                referenceForm.classList.remove('hidden');
                referenceForm.style.display = 'block';
                syncMainToReference();
            } else {
                referenceForm.classList.add('hidden');
                referenceForm.style.display = 'none';
            }
        });
        // Initial state on page load
        if (dependencyTypeSelect.value === 'CREATE REFERENCE') {
            referenceForm.classList.remove('hidden');
            referenceForm.style.display = 'block';
            syncMainToReference();
        } else {
            referenceForm.classList.add('hidden');
            referenceForm.style.display = 'none';
        }
    }
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function() {
    var depDropdown = document.getElementById('dependency_type');
    var refForm = document.getElementById('reference-inline-form');
    function toggleReferenceForm() {
        if (depDropdown && refForm) {
            if (depDropdown.value === 'CREATE REFERENCE') {
                refForm.classList.remove('hidden');
            } else {
                refForm.classList.add('hidden');
            }
        }
    }
    if (depDropdown) {
        depDropdown.addEventListener('change', toggleReferenceForm);
        toggleReferenceForm();
    }
});
</script>
@endsection
