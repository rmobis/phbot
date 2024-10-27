<?php

namespace App\Tibia\Data\Worlds;

use App\Tibia\Data\AbstractData;
use Spatie\LaravelData\Attributes\Validation\Present;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;

class WorldData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly string $status,
        public readonly int $playersOnline,
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
    ) {}
}
