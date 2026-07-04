<?php

namespace App\Exports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DocumentsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;
    public function __construct(array $filters) { $this->filters = $filters; }

    public function collection()
    {
        $query = Document::with('project');
        if (!empty($this->filters['projectId'])) $query->where('project_id', $this->filters['projectId']);
        if (!empty($this->filters['from']) && !empty($this->filters['to'])) $query->whereBetween('created_at', [$this->filters['from'], $this->filters['to']]);
        return $query->latest()->get();
    }

    public function headings(): array
    {
        return ['ID', 'Project', 'Title', 'Category', 'Original Name', 'Size (KB)', 'Uploaded At'];
    }

    public function map($document): array
    {
        return [
            $document->id,
            $document->project->name ?? '',
            $document->title,
            $document->category,
            $document->original_name,
            round($document->size / 1024, 1),
            $document->created_at,
        ];
    }
}