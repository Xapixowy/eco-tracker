<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FuelType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'consumption_unit',
        'price_per_unit',
    ];

    public function emissionRecords(): hasMany
    {
        return $this->hasMany(EmissionRecord::class);
    }
}
