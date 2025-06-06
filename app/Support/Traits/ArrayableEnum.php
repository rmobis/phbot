<?php

namespace App\Support\Traits;

use BackedEnum;

/**
 * @template T of BackedEnum
 */
trait ArrayableEnum
{
    /**
     * @return (string|int)[]
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return (string|int)[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array<string, string|int>
     */
    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }
}
