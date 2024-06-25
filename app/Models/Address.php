<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'building',
        'apartment',
        'zip_code',
        'city',
        'voivodeship'
    ];

    public function home(): HasOne
    {
        return $this->hasOne(Home::class);
    }
}
