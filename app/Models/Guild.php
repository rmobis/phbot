<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guild extends Model
{
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    public function world(): BelongsTo
    {
        return $this->belongsTo(World::class);
    }
}
