<?php

namespace App\Tibia\Data\World;

use App\Tibia\Data\AbstractData;

class OnlinePlayerData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly int $level,
        public readonly string $vocation,
    ) {}
}
