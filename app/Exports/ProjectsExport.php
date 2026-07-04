<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Project::query();
        if (!empty($this->filters['projectId'])) $query->where('id', $this->filters['projectId']);
        if (!empty($this->filters['status'])) $query->where('status', $this->filters['status']);
        if (!empty($this->filters['from']) && !empty($this->filters['to'])) $query->whereBetween('created_at', [$this->filters['from'], $this->filters['to']]);
        return $query->latest()->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Client', 'Consultant', 'Location', 'Contract Value', 'Start Date', 'End Date', 'Status'];
    }

    public function map($project): array
    {
        return [
            $project->id,
            $project->name,
            $project->client,
            $project->consultant,
            $project->location,
            $project->contract_value,
            $project->start_date,
            $project->end_date,
            $project->status,
        ];
    }
}