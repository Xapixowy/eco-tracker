<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SourceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function emmisionRecords(): hasMany
    {
        return $this->hasMany(EmmisionRecord::class);
    }

    public function Statistics(): hasMany
    {
        return $this->hasMany(Statistic::class);
    }
}
