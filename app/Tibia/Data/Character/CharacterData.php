<?php

namespace App\Tibia\Data\Character;

use App\Tibia\Data\AbstractData;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Validation\Present;

class CharacterData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        #[Present]
        /** @var Collection<string> */
        public readonly Collection $formerNames,
        public readonly string $title,
        public readonly int $unlockedTitles,
        public readonly string $sex,
        public readonly string $vocation,
        public readonly int $level,
        public readonly int $achievementPoints,
        public readonly string $world,
        #[Present]
        /** @var Collection<string> */
        public readonly Collection $formerWorlds,
        public readonly string $residence,
        public readonly ?string $marriedTo,
        #[Present]
        /** @var Collection<HouseData> */
        public readonly Collection $houses,
        public readonly ?GuildData $guild,
        public readonly CarbonImmutable $lastLogin,
        public readonly ?CarbonImmutable $deletionDate,
        public readonly ?string $comment,
        public readonly string $accountStatus,
        public readonly ?string $position,
        public readonly bool $traded = false,
    ) {}
}
