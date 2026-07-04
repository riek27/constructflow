<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'     => 'required|exists:projects,id',
            'contract_id'    => 'nullable|exists:contracts,id',
            'variation_id'   => 'nullable|exists:variations,id',
            'type'           => 'required|string|in:payment_application,client_payment',
            'invoice_number' => 'required|string|max:50|unique:payments,invoice_number,' . $this->payment->id,
            'invoice_date'   => 'nullable|date',
            'due_date'       => 'nullable|date',
            'amount'         => 'nullable|numeric|min:0',
            'vat'            => 'nullable|numeric|min:0',
            'status'         => 'nullable|string|in:pending,approved,paid,partially_paid,overdue',
            'notes'          => 'nullable|string',
        ];
    }
}