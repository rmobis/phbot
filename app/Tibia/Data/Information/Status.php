<?php

namespace App\Tibia\Data\Information;

use App\Tibia\Data\AbstractData;

class Status extends AbstractData
{
    public function __construct(
        public readonly int $httpCode
    ) {}
}
