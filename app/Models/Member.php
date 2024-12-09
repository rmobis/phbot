<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Member extends Model
{
    protected $casts = [
        'phone_number' => E164PhoneNumberCast::class,
    ];

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => "{$attributes['first_name']} {$attributes['last_name']}",
        );
    }
}
