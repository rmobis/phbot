<?php

namespace App\Tibia\Data;

use Carbon\CarbonImmutable;

class InformationData extends AbstractData
{
    public function __construct(
        public readonly Information\ApiData $api,
        public readonly CarbonImmutable $timestamp,
        public readonly Information\StatusData $status,
    ) {}
}
