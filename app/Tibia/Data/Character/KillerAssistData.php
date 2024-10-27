<?php

namespace App\Tibia\Data\Character;

use App\Tibia\Data\AbstractData;
use Spatie\LaravelData\Attributes\Validation\Present;

class KillerAssistData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly bool $player,
        public readonly bool $traded,
        #[Present]
        public readonly string $summon,
    ) {}
}
