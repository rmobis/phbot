<?php

namespace App\Support\Enums;

use App\Support\Traits\ArrayableEnum;

enum JobQueue: string
{
    use ArrayableEnum;

    case Default = 'default';
    case Priority = 'priority';
}
