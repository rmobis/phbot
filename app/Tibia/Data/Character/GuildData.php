<?php

namespace App\Tibia\Data\Character;

use App\Tibia\Data\AbstractData;

class GuildData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly string $rank,
    ) {}
}
