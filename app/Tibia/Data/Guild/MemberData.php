<?php

namespace App\Tibia\Data\Guild;

use App\Tibia\Data\AbstractData;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\Validation\Present;

class MemberData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        #[Present]
        public readonly string $title,
        public readonly string $rank,
        public readonly string $vocation,
        public readonly int $level,
        public readonly CarbonImmutable $joined,
        public readonly string $status,
    ) {}
}
