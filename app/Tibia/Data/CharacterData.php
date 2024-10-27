<?php

namespace App\Tibia\Data;

use App\Tibia\Data\Character\AccountBadgeData;
use App\Tibia\Data\Character\AccountInformationData;
use App\Tibia\Data\Character\AchievementData;
use App\Tibia\Data\Character\CharacterData as InnerCharacterData;
use App\Tibia\Data\Character\DeathData;
use App\Tibia\Data\Character\OtherCharacterData;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Validation\Present;

class CharacterData extends AbstractData
{
    public function __construct(
        public readonly InnerCharacterData $character,
        #[Present]
        /** @var Collection<AccountBadgeData> */
        public readonly Collection $accountBadges,
        #[Present]
        /** @var Collection<AchievementData> */
        public readonly Collection $achievements,
        #[Present]
        /** @var Collection<DeathData> */
        public readonly Collection $deaths,
        public readonly bool $deathsTruncated,
        public readonly ?AccountInformationData $accountInformation,
        #[Present]
        /** @var Collection<OtherCharacterData> */
        public readonly Collection $otherCharacters,
    ) {}
}
