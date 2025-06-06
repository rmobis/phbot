<?php

namespace App\Models;

use App\Support\Enums\Region;
use App\Support\Enums\WorldType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class World extends Model
{
    use SoftDeletes;

    protected $casts = [
        'region' => Region::class,
        'type' => WorldType::class,
    ];

    public function guilds(): HasMany
    {
        return $this->hasMany(Guild::class);
    }
}
