<?php

namespace App\Support\Enums;

use App\Support\Traits\ArrayableEnum;

enum CharacterEventType: string
{
    use ArrayableEnum;

    // Meta Events
    case FirstSeen = 'first-seen';
    case FullUpdate = 'full-update';
    case PartialUpdate = 'partial-update';

    // Game Events
    case NameChange = 'name-change';
    case LevelUp = 'level-up';
    case LevelDown = 'level-down'; // TODO: implement full death event
    case WorldTransfer = 'world-transfer';
    case JoinGuild = 'join-guild';
    case LeaveGuild = 'leave-guild';
    case PromotedDemoted = 'promoted-demoted'; // not happy with the naming here, maybe RankChange?
    // TODO: maybe consider vocation change?
}
