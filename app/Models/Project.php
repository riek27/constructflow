<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'client',
        'consultant',
        'location',
        'contract_value',
        'start_date',
        'end_date',
        'status',
        'project_manager_id',
        'commercial_manager_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'contract_value' => 'decimal:2',
    ];

    public function projectManager()
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }

    public function commercialManager()
    {
        return $this->belongsTo(User::class, 'commercial_manager_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function procurements()
    {
        return $this->hasMany(Procurement::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}