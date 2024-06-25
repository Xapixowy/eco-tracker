<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'source_type_id',
        'total_co2'
    ];

    protected $attributes = [
        'total_co2' => 0,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sourceType(): BelongsTo
    {
        return $this->belongsTo(SourceType::class);
    }
}
