<?php

namespace App\Models;

use App\Support\Enum\Vocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Character extends Model
{
    protected $casts = [
        'vocation' => Vocation::class,
    ];

    public function world(): BelongsTo
    {
        return $this->belongsTo(World::class);
    }

    public function guild(): BelongsTo
    {
        return $this->belongsTo(Guild::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
