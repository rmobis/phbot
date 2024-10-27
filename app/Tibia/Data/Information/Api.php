<?php

namespace App\Tibia\Data\Information;

use App\Tibia\Data\AbstractData;

class Api extends AbstractData
{
    public function __construct(
        public readonly int $version,
        public readonly string $release,
        public readonly string $commit
    ) {}
}
