<?php

namespace App\Tibia\Data\Information;

use App\Tibia\Data\AbstractData;

class StatusData extends AbstractData
{
    public function __construct(
        public readonly int $httpCode
    ) {}
}
