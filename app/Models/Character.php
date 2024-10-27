<?php

namespace App\Models;

use App\Support\Enum\Vocation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function scopeWhereAnyName(Builder $query, iterable $names): void
    {
        $names = collect($names)->map(static fn (string $name): string => Str::upper($name));

        $query->whereIn(DB::raw('UPPER(`name`)'), $names);
    }
}
