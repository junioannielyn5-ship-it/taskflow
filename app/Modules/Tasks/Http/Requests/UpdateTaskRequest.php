<?php

namespace App\Modules\Tasks\Http\Requests;

use App\Modules\Tasks\Models\Task;
use App\Modules\Shared\Enums\TaskPriority;
use App\Modules\Shared\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    private function resolveTask(): ?Task
    {
        $task = $this->route('task');

        return $task instanceof Task ? $task : null;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('status')) {
            $this->merge([
                'status' => TaskStatus::normalize($this->input('status')),
            ]);
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization is handled in the controller
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $task = $this->resolveTask();
        $projectId = (int) ($task?->project_id ?? 0);

        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'task_process' => 'nullable|string|max:255',
            'specific_process' => 'nullable|string|max:255',
            'sla_days' => 'nullable|integer|min:1|max:60',
            'company' => 'nullable|string|max:255',
            'team_in_charge' => 'nullable|string|max:255',
            'deliverables' => 'nullable|string|max:255',
            'document_link' => 'nullable|url|max:2048',
            'remarks' => 'nullable|string|max:2000',
            'priority' => ['sometimes', Rule::in(TaskPriority::values())],
            'date_received' => 'nullable|date',
            'date_started' => 'nullable|date|after_or_equal:date_received',
            'due_date' => 'nullable|date',
            'blocked_by_task_id' => [
                'nullable',
                'integer',
                Rule::exists('tasks', 'id')->where(function ($query) use ($projectId) {
                    $query->where('project_id', $projectId);
                }),
                Rule::notIn([$task?->id]),
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
            'title.required' => 'Task title is required',
            'title.max' => 'Task title cannot exceed 255 characters',
            'description.max' => 'Description cannot exceed 2000 characters',
            'task_process.max' => 'Task process cannot exceed 255 characters',
            'specific_process.max' => 'Specific process cannot exceed 255 characters',
            'sla_days.integer' => 'SLA days must be a whole number',
            'sla_days.min' => 'SLA days must be at least 1',
            'sla_days.max' => 'SLA days cannot exceed 60',
            'company.max' => 'Company/Client cannot exceed 255 characters',
            'deliverables.max' => 'Deliverables cannot exceed 255 characters',
            'document_link.url' => 'Document link must be a valid URL',
            'document_link.max' => 'Document link cannot exceed 2048 characters',
            'remarks.max' => 'Remarks cannot exceed 2000 characters',
            'priority.in' => 'Priority must be one of: low, medium, high, urgent',
            'date_received.date' => 'Date received must be a valid date',
            'date_started.date' => 'Date started must be a valid date',
            'date_started.after_or_equal' => 'Date started must be the same as or after date received',
            'due_date.date' => 'Due date must be a valid date',
            'blocked_by_task_id.exists' => 'Dependency task must belong to the same project',
            'blocked_by_task_id.not_in' => 'Task cannot depend on itself',
            'status.in' => 'Status must be one of: todo, in_progress, blocked, for_review, done, cancelled',
        ];
    }
}
