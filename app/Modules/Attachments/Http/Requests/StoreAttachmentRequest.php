<?php

namespace App\Modules\Attachments\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization handled in controller
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|max:5120|mimes:pdf,png,jpg,zip,docx',
        ];
    }
}
