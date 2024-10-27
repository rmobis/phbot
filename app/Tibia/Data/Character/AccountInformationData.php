<?php

namespace App\Tibia\Data\Character;

use App\Tibia\Data\AbstractData;
use Carbon\CarbonImmutable;

class AccountInformationData extends AbstractData
{
    public function __construct(
        public readonly ?string $loyaltyTitle,
        public readonly CarbonImmutable $created,
        public readonly ?string $position,
    ) {}
}
