<?php

namespace App\Support\Enum;

use App\Support\Trait\ArrayableEnum;

enum Region: string
{
    use ArrayableEnum;

    case Europe = 'EU';
    case NorthAmerica = 'NA';
    case SouthAmerica = 'SA';
}
