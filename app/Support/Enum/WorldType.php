<?php

namespace App\Support\Enum;

use App\Support\Trait\ArrayableEnum;

enum WorldType: string
{
    use ArrayableEnum;

    case OptionalPvP = 'Optional PvP';
    case OpenPvP = 'Open PvP';
    case HardcorePvP = 'Hardcore PvP';
    case RetroOpenPvP = 'Retro Open PvP';
    case RetroHardcorePvP = 'Retro Hardcore PvP';
}
