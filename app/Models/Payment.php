<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'contract_id',
        'variation_id',
        'type',
        'invoice_number',
        'invoice_date',
        'due_date',
        'amount',
        'vat',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date'     => 'date',
        'amount'       => 'decimal:2',
        'vat'          => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}