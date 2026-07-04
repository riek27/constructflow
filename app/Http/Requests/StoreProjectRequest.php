<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                  => 'required|string|max:255',
            'client'                => 'nullable|string|max:255',
            'consultant'            => 'nullable|string|max:255',
            'location'              => 'nullable|string|max:255',
            'contract_value'        => 'nullable|numeric',
            'start_date'            => 'nullable|date',
            'end_date'              => 'nullable|date',
            'status'                => 'nullable|string',
            'project_manager_id'    => 'nullable|exists:users,id',
            'commercial_manager_id' => 'nullable|exists:users,id',
        ];
    }
}
