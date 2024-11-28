<?php

namespace App\Tibia\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Validation\Present;

class CharacterData extends AbstractData
{
    public function __construct(
        public readonly Character\CharacterData $character,
        #[Present]
        /** @var Collection<Character\AccountBadgeData> */
        public readonly Collection $accountBadges,
        #[Present]
        /** @var Collection<Character\AchievementData> */
        public readonly Collection $achievements,
        #[Present]
        /** @var Collection<Character\DeathData> */
        public readonly Collection $deaths,
        public readonly bool $deathsTruncated,
        public readonly ?Character\AccountInformationData $accountInformation,
        #[Present]
        /** @var Collection<Character\OtherCharacterData> */
        public readonly Collection $otherCharacters,
    ) {}
}
