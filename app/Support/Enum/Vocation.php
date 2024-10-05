<?php

namespace App\Support\Enum;

use App\Support\Trait\ArrayableEnum;

enum Vocation: string
{
    use ArrayableEnum;

    case None = 'N';
    case Druid = 'D';
    case Sorcerer = 'S';
    case Paladin = 'P';
    case Knight = 'K';
    case ElderDruid = 'ED';
    case MasterSorcerer = 'MS';
    case RoyalPaladin = 'RP';
    case EliteKnight = 'EK';
}
