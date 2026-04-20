<?php

namespace App\Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'role' => ['nullable', 'string'],
            'active' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'in:asc,desc'],
        ];
    }
}
