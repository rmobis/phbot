<?php

namespace App\Tibia\Data\Guild;

use App\Tibia\Data\AbstractData;
use Carbon\CarbonImmutable;

class InviteData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly CarbonImmutable $date,
    ) {}
}
