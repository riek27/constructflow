<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'contract_id',
        'variation_number',
        'title',
        'description',
        'estimated_cost',
        'approved_cost',
        'quotation_amount',
        'status',
    ];

    protected $casts = [
        'estimated_cost'   => 'decimal:2',
        'approved_cost'    => 'decimal:2',
        'quotation_amount' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}