<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procurement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'supplier_id',
        'supplier_name',
        'po_number',
        'description',
        'quantity',
        'unit',
        'unit_cost',
        'total_cost',
        'order_date',
        'delivery_date',
        'status',
    ];

    protected $casts = [
        'order_date'    => 'date',
        'delivery_date' => 'date',
        'quantity'      => 'decimal:2',
        'unit_cost'     => 'decimal:2',
        'total_cost'    => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}