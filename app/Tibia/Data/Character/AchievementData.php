<?php

namespace App\Tibia\Data\Character;

use App\Tibia\Data\AbstractData;

class AchievementData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly int $grade,
        public readonly bool $secret,
    ) {}
}
