<?php

namespace App\Support\Enum;

use App\Support\Trait\ArrayableEnum;

enum Region: string
{
    use ArrayableEnum;

    case Europe = 'Europe';
    case NorthAmerica = 'North America';
    case SouthAmerica = 'South America';
    case Oceania = 'Oceania';
}
