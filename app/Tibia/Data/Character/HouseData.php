<?php

namespace App\Tibia\Data\Character;

use App\Tibia\Data\AbstractData;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\MapInputName;

class HouseData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly string $town,
        public readonly CarbonImmutable $paid,
        #[MapInputName('houseid')]
        public readonly int $houseId
    ) {}
}
