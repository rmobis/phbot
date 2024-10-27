<?php

namespace App\Tibia\Data\Character;

use App\Tibia\Data\AbstractData;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

class DeathData extends AbstractData
{
    public function __construct(
        public readonly CarbonImmutable $time,
        public readonly int $level,
        public readonly string $reason,
        /** @var Collection<KillerAssistData> */
        public readonly Collection $killers,
        /** @var Collection<KillerAssistData> */
        public readonly Collection $assists,
    ) {}
}
