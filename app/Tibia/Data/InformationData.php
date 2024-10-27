<?php

namespace App\Tibia\Data;

use App\Tibia\Data\Information\Api;
use App\Tibia\Data\Information\Status;
use Carbon\CarbonImmutable;

class InformationData extends AbstractData
{
    public function __construct(
        public readonly Api $api,
        public readonly CarbonImmutable $timestamp,
        public readonly Status $status,
    ) {}
}
