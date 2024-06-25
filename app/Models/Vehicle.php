<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'fuel_type_id',
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fuelType(): belongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    public function emissionRecords(): morphMany
    {
        return $this->morphMany(EmissionRecord::class, 'sourcable');
    }
}
