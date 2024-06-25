<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

abstract class MediaUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_id',
        'start_at',
        'end_at',
        'fuel_type_id'
    ];

    public function home(): BelongsTo
    {
        return $this->belongsTo(Home::class);
    }

    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }
}
