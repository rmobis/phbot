<?php

namespace App\Filament\Tables\Actions;

class GuildStatsLinkAction extends FansiteLinkAction
{
    protected static string $BASE_URL = 'https://guildstats.eu/character?nick=';

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('GuildStats');
    }
}
