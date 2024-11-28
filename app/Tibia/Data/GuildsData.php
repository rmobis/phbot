<?php

namespace App\Tibia\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Validation\Present;

class GuildsData extends AbstractData
{
    public function __construct(
        public readonly string $world,
        #[Present]
        /** @var Collection<Guilds\GuildData> */
        public readonly Collection $active,
        #[Present]
        /** @var Collection<Guilds\GuildData> */
        public readonly Collection $formation,
    ) {}
}
