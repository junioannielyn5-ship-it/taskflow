<?php

namespace App\Modules\Projects\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $project = $this->route('project');
        return $this->user()?->can('update', $project) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'project_owner' => 'sometimes|in:LS,NR,PB,VA,EC',
            'description' => 'nullable|string|max:1000',
            'status' => 'sometimes|in:pending_request,ongoing',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Project name is required',
            'name.string' => 'Project name must be a string',
            'name.max' => 'Project name cannot exceed 255 characters',
            'company_name.string' => 'Company name must be a string',
            'company_name.max' => 'Company name cannot exceed 255 characters',
            'project_owner.in' => 'Project owner must be one of the registered codes: LS, NR, PB, VA, or EC',
            'description.string' => 'Description must be a string',
            'description.max' => 'Description cannot exceed 1000 characters',
            'status.in' => 'Status must be either Pending Request or Ongoing',
        ];
    }
}
