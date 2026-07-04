<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProcurementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'    => 'required|exists:projects,id',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'po_number'     => 'required|string|max:50|unique:procurements,po_number,' . $this->procurement->id,
            'description'   => 'nullable|string',
            'quantity'      => 'nullable|numeric|min:0',
            'unit'          => 'nullable|string|max:20',
            'unit_cost'     => 'nullable|numeric|min:0',
            'total_cost'    => 'nullable|numeric|min:0',
            'order_date'    => 'nullable|date',
            'delivery_date' => 'nullable|date',
            'status'        => 'nullable|string|in:requested,approved,ordered,delivered,closed',
        ];
    }
}