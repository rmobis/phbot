<?php

namespace App\Tibia\Data\Guilds;

use App\Tibia\Data\AbstractData;
use Spatie\LaravelData\Attributes\Validation\Present;

class GuildData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        #[Present]
        public readonly string $description,
        public readonly string $logoUrl,
    ) {}
}
