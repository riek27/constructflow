<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'          => 'required|exists:projects,id',
            'documentable_type'   => 'nullable|string',
            'documentable_id'     => 'nullable|integer',
            'title'               => 'required|string|max:255',
            'category'            => 'required|string|max:50',
            'file'                => 'required|file|max:51200', // 50MB max
            'version'             => 'nullable|string|max:10',
            'description'         => 'nullable|string',
        ];
    }
}