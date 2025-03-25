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
    case ViceLeader = 'Vice Leader';
    case Hero = 'Hero';
    case Major = 'Major';
    case Prodigy = 'Prodigy';
    case Rising = 'Rising';

    case Member = 'Member';
    case Recruta = 'Recruta';
    case MembroNovo = 'Membro Novo';
    case Reserva = 'Reserva';
    case Academy = 'Academy';
    case SemRank = 'Sem Rank';

    /**
     * @return array<string, array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string, 950: string}>
     */
    public static function colors(): array
    {
        return [
            'skull-leader' => Color::Red,
            'skull-vice-leader' => Color::hex('#ffffff'),
            'skull-hero' => Color::Yellow,
            'skull-major' => Color::Purple,
            'skull-prodigy' => Color::Purple,
            'skull-rising' => Color::Purple,

            'skull-member' => Color::Cyan,
            'skull-recruta' => Color::Orange,
            'skull-membro-novo' => Color::Pink,
            'skull-reserva' => Color::Neutral,
            'skull-academy' => Color::Neutral,
            'skull-sem-rank' => Color::Neutral,
        ];
    }

    public function getIcon(): string
    {
        return 'rpg-death-skull';
    }

    public function getColor(): string
    {
        return 'skull-'.Str::kebab($this->value);
    }
}
