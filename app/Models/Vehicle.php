<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'fuel_type_id',
        'fuel_consumption',
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fuelType(): hasOne
    {
        return $this->hasOne(FuelType::class);
    }
}
