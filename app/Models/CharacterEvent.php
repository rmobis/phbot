<?php

namespace App\Models;

use App\Support\Enums\CharacterEventType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CharacterEvent extends Model
{
    protected $casts = [
        'type' => CharacterEventType::class,
    ];

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
