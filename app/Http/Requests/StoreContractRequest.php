<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'                => 'required|exists:projects,id',
            'contract_number'           => 'required|string|max:50|unique:contracts,contract_number',
            'contract_value'            => 'nullable|numeric',
            'currency'                  => 'nullable|string|max:10',
            'client'                    => 'nullable|string|max:255',
            'start_date'                => 'nullable|date',
            'completion_date'           => 'nullable|date',
            'retention_percent'         => 'nullable|numeric|min:0|max:100',
            'defects_liability_months'  => 'nullable|integer|min:0',
            'payment_terms'             => 'nullable|string',
            'scope_summary'             => 'nullable|string',
            'status'                    => 'nullable|string',
        ];
    }
}