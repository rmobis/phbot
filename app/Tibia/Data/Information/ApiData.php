<?php

namespace App\Tibia\Data\Information;

use App\Tibia\Data\AbstractData;

class ApiData extends AbstractData
{
    public function __construct(
        public readonly int $version,
        public readonly string $release,
        public readonly string $commit
    ) {}
}
