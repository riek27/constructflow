<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVariationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'        => 'required|exists:projects,id',
            'contract_id'       => 'nullable|exists:contracts,id',
            'variation_number'  => 'required|string|max:50|unique:variations,variation_number',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'estimated_cost'    => 'nullable|numeric',
            'approved_cost'     => 'nullable|numeric',
            'quotation_amount'  => 'nullable|numeric',
            'status'            => 'nullable|string',
        ];
    }
}