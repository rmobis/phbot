<?php

namespace App\Support\Enums;

use App\Support\Traits\ArrayableEnum;
use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Illuminate\Support\Str;

enum Rank: string implements HasColor, HasIcon
{
    use ArrayableEnum;

    case Leader = 'Leader';
    case Legend = 'Legend';
    case Hero = 'Hero';
    case Guardian = 'Guardian';
    case Conqueror = 'Conqueror';
    case Traveler = 'Traveler';
    case New = 'New';
    case Second = 'Second';
    case Retired = 'Retired';

    /**
     * @return array<string, array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string, 950: string}>
     */
    public static function colors(): array
    {
        return [
            'skull-leader' => Color::Red,
            'skull-legend' => Color::hex('#ffffff'),
            'skull-hero' => Color::Yellow,
            'skull-guardian' => Color::Purple,
            'skull-conqueror' => Color::Cyan,
            'skull-traveler' => Color::Orange,
            'skull-new' => Color::Pink,
            'skull-second' => Color::Neutral,
            'skull-retired' => Color::Neutral,
        ];
    }

    public function getIcon(): string
    {
        return 'rpg-death-skull';
    }

    public function getColor(): string
    {
        return 'skull-'.Str::lower($this->value);
    }
}
