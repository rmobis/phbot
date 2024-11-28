<?php

namespace App\Tibia\Data;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Validation\Present;

class WorldsData extends AbstractData
{
    public function __construct(
        public readonly int $playersOnline,
        public readonly int $recordPlayers,
        public readonly CarbonImmutable $recordDate,
        /** @var Collection<Worlds\WorldData> */
        public readonly Collection $regularWorlds,
        #[Present]
        /** @var Collection<Worlds\WorldData> */
        public readonly Collection $tournamentWorlds,
    ) {}
}
