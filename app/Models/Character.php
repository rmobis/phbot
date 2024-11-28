<?php

namespace App\Models;

use App\Observers\CharacterObserver;
use App\Support\Enums\Vocation;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[ObservedBy(CharacterObserver::class)]
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

    public function characterEvents(): HasMany
    {
        return $this->hasMany(CharacterEvent::class);
    }

    public function scopeWhereAnyName(Builder $query, iterable $names): void
    {
        $names = collect($names)->map(static fn (string $name): string => Str::upper($name));

        $query->whereIn(DB::raw('UPPER(`name`)'), $names);
    }
}
