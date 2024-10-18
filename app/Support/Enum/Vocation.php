<?php

namespace App\Support\Enum;

use App\Support\Trait\ArrayableEnum;

enum Vocation: string
{
    use ArrayableEnum;

    case None = 'None';
    case Druid = 'Druid';
    case Sorcerer = 'Sorcerer';
    case Paladin = 'Paladin';
    case Knight = 'Knight';
    case ElderDruid = 'Elder Druid';
    case MasterSorcerer = 'Master Sorcerer';
    case RoyalPaladin = 'Royal Paladin';
    case EliteKnight = 'Elite Knight';
}
