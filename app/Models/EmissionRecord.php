<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EmissionRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'sourcable_type',
        'sourcable_id',
        'fuel_type_id',
        'fuel_consumption',
        'start_at',
        'end_at',
        'co2_emmision',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function sourcable(): MorphTo
    {
        return $this->morphTo();
    }
    
    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }
}
