<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
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
            'file'                => 'nullable|file|max:51200', // optional when updating
            'version'             => 'nullable|string|max:10',
            'description'         => 'nullable|string',
        ];
    }
}