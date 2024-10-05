<?php

namespace App\Support\Enum;

use App\Support\Trait\ArrayableEnum;

enum WorldType: string
{
    use ArrayableEnum;

    case OptionalPvP = 'optional';
    case OpenPvP = 'open';
    case HardcorePvP = 'hardcore';
    case RetroOpenPvP = 'retro-open';
    case RetroHardcorePvP = 'retro-hardcore';
}
