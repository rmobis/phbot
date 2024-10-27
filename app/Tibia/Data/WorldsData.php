<?php

namespace App\Tibia\Data;

use App\Tibia\Data\Worlds\WorldData;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Validation\Present;

class WorldsData extends AbstractData
{
    public function __construct(
        public readonly int $playersOnline,
        public readonly int $recordPlayers,
        public readonly CarbonImmutable $recordDate,
        /** @var Collection<WorldData> */
        public readonly Collection $regularWorlds,
        #[Present]
        /** @var Collection<WorldData> */
        public readonly Collection $tournamentWorlds,
    ) {}
}
