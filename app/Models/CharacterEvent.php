<?php

namespace App\Models;

use App\Support\Enums\CharacterEventType;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function newValue(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['new_value_str'] ?? $attributes['new_value_int'] ?? $attributes['new_value_ts'] ?? null,
            set: fn (mixed $value) => match (gettype($value)) {
                'string' => ['new_value_str' => $value],
                'integer' => ['new_value_int' => $value],
                'object' => ['new_value_ts' => $value],
                'NULL' => [],
            }
        );
    }

    public function oldValue(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['old_value_str'] ?? $attributes['old_value_int'] ?? $attributes['old_value_ts'] ?? null,
            set: fn (mixed $value) => match (gettype($value)) {
                'string' => ['old_value_str' => $value],
                'integer' => ['old_value_int' => $value],
                'object' => ['old_value_ts' => $value],
                'NULL' => [],
            }
        );
    }
}
