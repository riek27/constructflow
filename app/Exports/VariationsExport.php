<?php

namespace App\Exports;

use App\Models\Variation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VariationsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;
    public function __construct(array $filters) { $this->filters = $filters; }

    public function collection()
    {
        $query = Variation::with('project');
        if (!empty($this->filters['projectId'])) $query->where('project_id', $this->filters['projectId']);
        if (!empty($this->filters['status'])) $query->where('status', $this->filters['status']);
        if (!empty($this->filters['from']) && !empty($this->filters['to'])) $query->whereBetween('created_at', [$this->filters['from'], $this->filters['to']]);
        return $query->latest()->get();
    }

    public function headings(): array
    {
        return ['ID', 'Project', 'Variation #', 'Title', 'Estimated Cost', 'Approved Cost', 'Status'];
    }

    public function map($variation): array
    {
        return [
            $variation->id,
            $variation->project->name ?? '',
            $variation->variation_number,
            $variation->title,
            $variation->estimated_cost,
            $variation->approved_cost,
            $variation->status,
        ];
    }
}