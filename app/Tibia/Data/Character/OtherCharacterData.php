<?php

namespace App\Tibia\Data\Character;

use App\Tibia\Data\AbstractData;

class OtherCharacterData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly bool $main,
        public readonly string $world,
        public readonly string $status,
        public readonly bool $deleted,
        public readonly bool $traded,
    ) {}
}
