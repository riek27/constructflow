<?php

namespace App\Exports;

use App\Models\Contract;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContractsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;
    public function __construct(array $filters) { $this->filters = $filters; }

    public function collection()
    {
        $query = Contract::with('project');
        if (!empty($this->filters['projectId'])) $query->where('project_id', $this->filters['projectId']);
        if (!empty($this->filters['status'])) $query->where('status', $this->filters['status']);
        if (!empty($this->filters['from']) && !empty($this->filters['to'])) $query->whereBetween('created_at', [$this->filters['from'], $this->filters['to']]);
        return $query->latest()->get();
    }

    public function headings(): array
    {
        return ['ID', 'Project', 'Contract Number', 'Client', 'Value', 'Status', 'Start Date', 'Completion Date'];
    }

    public function map($contract): array
    {
        return [
            $contract->id,
            $contract->project->name ?? '',
            $contract->contract_number,
            $contract->client,
            $contract->contract_value,
            $contract->status,
            $contract->start_date,
            $contract->completion_date,
        ];
    }
}