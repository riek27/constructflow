<?php

namespace App\Exports;

use App\Models\Procurement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProcurementsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;
    public function __construct(array $filters) { $this->filters = $filters; }

    public function collection()
    {
        $query = Procurement::with('project', 'supplier');
        if (!empty($this->filters['projectId'])) $query->where('project_id', $this->filters['projectId']);
        if (!empty($this->filters['status'])) $query->where('status', $this->filters['status']);
        if (!empty($this->filters['from']) && !empty($this->filters['to'])) $query->whereBetween('created_at', [$this->filters['from'], $this->filters['to']]);
        return $query->latest()->get();
    }

    public function headings(): array
    {
        return ['ID', 'Project', 'PO Number', 'Supplier', 'Total Cost', 'Order Date', 'Delivery Date', 'Status'];
    }

    public function map($procurement): array
    {
        return [
            $procurement->id,
            $procurement->project->name ?? '',
            $procurement->po_number,
            $procurement->supplier->name ?? $procurement->supplier_name,
            $procurement->total_cost,
            $procurement->order_date,
            $procurement->delivery_date,
            $procurement->status,
        ];
    }
}