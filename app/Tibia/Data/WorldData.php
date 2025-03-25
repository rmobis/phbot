<?php

namespace App\Tibia\Data;

use App\Tibia\Data\World\OnlinePlayerData;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Validation\Present;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;

class WorldData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly string $status,
        public readonly int $playersOnline,
        /** @var Collection<OnlinePlayerData> */
        public readonly Collection $onlinePlayers,
        public readonly string $location,
        public readonly string $pvpType,
        public readonly bool $premiumOnly,
        public readonly string $transferType,
        public readonly bool $battleyeProtected,
        #[RequiredIf('battleyeProtected', true)]
        public readonly string $battleyeDate,
        public readonly string $gameWorldType,
        #[Present]
        public readonly string $tournamentWorldType,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m')]
        public readonly ?CarbonImmutable $creationDate,
        public readonly ?CarbonImmutable $recordDate,
        public readonly int $recordPlayers,
        /** @var Collection<string> */
        public readonly Collection $worldQuestTitles,
    ) {}
}
