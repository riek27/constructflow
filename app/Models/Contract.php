<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'contract_number',
        'contract_value',
        'currency',
        'client',
        'start_date',
        'completion_date',
        'retention_percent',
        'defects_liability_months',
        'payment_terms',
        'scope_summary',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'completion_date' => 'date',
        'contract_value' => 'decimal:2',
        'retention_percent' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}