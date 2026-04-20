<?php

namespace App\Modules\Tasks\Http\Requests;

use App\Modules\Projects\Services\ProjectService;
use App\Modules\Shared\Enums\TaskPriority;
use App\Modules\Shared\Enums\TaskStatus;
use App\Modules\Tasks\Support\TaskProcessCatalog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    private function resolveProjectId(): int
    {
        $project = $this->route('project');

        if ($project instanceof Model) {
            return (int) $project->getKey();
        }

        if (is_object($project) && method_exists($project, 'getKey')) {
            return (int) $project->getKey();
        }

        return (int) ($project ?? $this->input('project_id'));
    }

    protected function prepareForValidation(): void
    {
        $projectId = $this->resolveProjectId();

        if ($projectId > 0 && !$this->filled('project_id')) {
            $this->merge([
                'project_id' => $projectId,
            ]);
        }

        if ($this->has('status')) {
            $this->merge([
                'status' => TaskStatus::normalize($this->input('status')),
            ]);
        }

        // Normalize assignee payload so validation consistently receives an array of user IDs.
        $assignees = $this->input('assignees', []);

        if (!is_array($assignees)) {
            $assignees = [$assignees];
        }

        $assignees = collect($assignees)
            ->filter(fn ($id) => $id !== null && $id !== '')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        $this->merge([
            'assignees' => $assignees,
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        if (!$user) {
            return false;
        }

        // Only allow users with create-task permission (admin/pm/lead/executive)
        return \Illuminate\Support\Facades\Gate::allows('create-task', $user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $projectId = $this->resolveProjectId();

        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'task_process' => 'required|string|max:255',
            'specific_process' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $taskProcess = (string) $this->input('task_process');
                    $allowedSpecificProcesses = TaskProcessCatalog::specificProcessNamesFor($taskProcess);

                    if (empty($allowedSpecificProcesses)) {
                        return;
                    }

                    if (!in_array((string) $value, $allowedSpecificProcesses, true)) {
                        $fail('Specific process must match the selected task process category.');
                    }
                },
            ],
            'sla_days' => 'nullable|integer|min:1|max:60',
            'team_in_charge' => 'required|string|max:255',
            'team' => 'nullable|in:sales,technical,pre_sales,admin',
            'deliverables' => 'nullable|string|max:255',
            'document_link' => 'nullable|url|max:2048',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,gif,zip|max:10240',
            'remarks' => 'nullable|string|max:2000',
            'assignees' => ['required', 'array', 'min:1'],
            'assignees.*' => ['integer', 'exists:users,id'],
            'priority' => ['nullable', Rule::in(TaskPriority::values())],
            'date_received' => 'nullable|date',
            'date_started' => 'nullable|date|after_or_equal:date_received',
            'due_date' => 'nullable|date',
            'blocked_by_task_id' => [
                'nullable',
                'integer',
                Rule::exists('tasks', 'id')->where(function ($query) use ($projectId) {
                    $query->where('project_id', $projectId);
                }),
            ],
            'status' => ['sometimes', Rule::in(TaskStatus::values())],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'project_id.required' => 'Project is required',
            'project_id.exists' => 'Selected project does not exist',
            'title.required' => 'Task title is required',
            'title.max' => 'Task title cannot exceed 255 characters',
            'description.max' => 'Description cannot exceed 2000 characters',
            'task_process.required' => 'Task process is required',
            'task_process.max' => 'Task process cannot exceed 255 characters',
            'specific_process.required' => 'Specific process is required',
            'specific_process.max' => 'Specific process cannot exceed 255 characters',
            'sla_days.integer' => 'SLA days must be a whole number',
            'sla_days.min' => 'SLA days must be at least 1',
            'sla_days.max' => 'SLA days cannot exceed 60',
            'company.required' => 'Company/Client is required',
            'company.max' => 'Company/Client cannot exceed 255 characters',
            'team_in_charge.required' => 'Person-in-charge is required',
            'deliverables.max' => 'Deliverables cannot exceed 255 characters',
            'document_link.url' => 'Document link must be a valid URL',
            'document_link.max' => 'Document link cannot exceed 2048 characters',
            'document_file.file' => 'The uploaded document must be a valid file',
            'document_file.mimes' => 'Allowed file types: PDF, Word, Excel, image (PNG/JPG/GIF), ZIP',
            'document_file.max' => 'File size must not exceed 10MB',
            'remarks.max' => 'Remarks cannot exceed 2000 characters',
            'assignees.required' => 'At least one assignee is required',
            'assignees.array' => 'Assignees must be a list of users',
            'assignees.min' => 'At least one assignee is required',
            'assignees.*.exists' => 'Each assignee must be a valid user',
            'priority.in' => 'Priority must be one of: low, medium, high, urgent',
            'date_received.date' => 'Date received must be a valid date',
            'date_started.date' => 'Date started must be a valid date',
            'date_started.after_or_equal' => 'Date started must be the same as or after date received',
            'due_date.date' => 'Due date must be a valid date',
            'blocked_by_task_id.exists' => 'Dependency task must belong to the selected project',
            'status.in' => 'Status must be one of: todo, in_progress, blocked, for_review, done, cancelled',
        ];
    }
}
