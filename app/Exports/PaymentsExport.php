<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PaymentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;
    public function __construct(array $filters) { $this->filters = $filters; }

    public function collection()
    {
        $query = Payment::with('project');
        if (!empty($this->filters['projectId'])) $query->where('project_id', $this->filters['projectId']);
        if (!empty($this->filters['status'])) $query->where('status', $this->filters['status']);
        if (!empty($this->filters['from']) && !empty($this->filters['to'])) $query->whereBetween('created_at', [$this->filters['from'], $this->filters['to']]);
        return $query->latest()->get();
    }

    public function headings(): array
    {
        return ['ID', 'Project', 'Invoice #', 'Type', 'Amount', 'VAT', 'Total', 'Due Date', 'Status'];
    }

    public function map($payment): array
    {
        return [
            $payment->id,
            $payment->project->name ?? '',
            $payment->invoice_number,
            $payment->type,
            $payment->amount,
            $payment->vat,
            $payment->total_amount,
            $payment->due_date,
            $payment->status,
        ];
    }
}