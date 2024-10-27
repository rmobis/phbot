<?php

namespace App\Tibia\Data\Guild;

use App\Tibia\Data\AbstractData;
use Carbon\CarbonImmutable;

class GuildHallData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly string $world,
        public readonly CarbonImmutable $paidUntil,
    ) {}
}
