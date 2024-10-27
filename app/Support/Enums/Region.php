<?php

namespace App\Support\Enums;

use App\Support\Traits\ArrayableEnum;

enum Region: string
{
    use ArrayableEnum;

    case Europe = 'Europe';
    case NorthAmerica = 'North America';
    case SouthAmerica = 'South America';
    case Oceania = 'Oceania';
}
