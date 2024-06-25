<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class EmmisionRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'sourcable_type',
        'sourcable_id',
        'start_at',
        'end_at',
        'co2_emmision',
    ];

    public function sourcable(): MorphTo
    {
        return $this->morphTo();
    }
}
