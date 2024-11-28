<?php

namespace App\Tibia\Data;

use App\Tibia\Data\Casts\OptionalDateTimeInterfaceCast;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\Validation\Present;
use Spatie\LaravelData\Attributes\Validation\RequiredUnless;
use Spatie\LaravelData\Attributes\WithCast;

class GuildData extends AbstractData
{
    public function __construct(
        public readonly string $name,
        public readonly string $world,
        public readonly string $logoUrl,
        #[Present]
        public readonly string $description,
        public readonly bool $active,
        public readonly CarbonImmutable $founded,
        public readonly bool $openApplications,
        #[Present]
        public readonly string $homepage,
        public readonly bool $inWar,
        #[Present]
        #[RequiredUnless('disbandCondition', '')]
        #[WithCast(OptionalDateTimeInterfaceCast::class)]
        public readonly ?CarbonImmutable $disbandDate,
        #[Present]
        #[RequiredUnless('disbandDate', '')]
        public readonly string $disbandCondition,
        public readonly int $playersOnline,
        public readonly int $playersOffline,
        public readonly int $membersTotal,
        public readonly int $membersInvited,
        /** @var Collection<Guild\MemberData> */
        public readonly Collection $members,
        #[Present]
        /** @var Collection<Guild\InviteData> */
        public readonly Collection $invites,
    ) {}
}
