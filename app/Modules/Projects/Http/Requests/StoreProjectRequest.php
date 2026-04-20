<?php

namespace App\Modules\Projects\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create-project') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'project_owner' => 'required|string|max:10',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:pending_request,ongoing',
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
            'project_owner.required' => 'Project owner is required',
            'project_owner.in' => 'Project owner must be LS or NR',
            'description.string' => 'Description must be a string',
            'description.max' => 'Description cannot exceed 1000 characters',
            'status.required' => 'Project status is required',
            'status.in' => 'Status must be either Pending Request or Ongoing',
        ];
    }
}
