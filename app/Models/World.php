<?php

namespace App\Models;

use App\Support\Enum\Region;
use App\Support\Enum\WorldType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class World extends Model
{
    protected $casts = [
        'region' => Region::class,
        'world_type' => WorldType::class,
    ];

    public function guilds(): HasMany
    {
        return $this->hasMany(Guild::class);
    }
}
