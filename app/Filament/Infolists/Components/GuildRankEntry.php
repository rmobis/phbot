<?php

namespace App\Filament\Infolists\Components;

use App\Models\Character;
use App\Providers\AppServiceProvider;
use App\Support\Enums\Rank;
use Filament\Infolists\Components\TextEntry;

class GuildRankEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Rank');

        // for some reason it doesn't pick up the enum color for the icon when using infolists
        $this->iconColor(static fn (?Rank $state) => $state->getColor());
        $this->getStateUsing(static function (Character $record): null|string|Rank {
            if ($record->guild?->name !== AppServiceProvider::MAIN_GUILD) {
                return $record->guild_rank;
            }

            return Rank::from($record->guild_rank);
        });
    }
}
