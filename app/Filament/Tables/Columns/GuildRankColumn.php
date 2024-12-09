<?php

namespace App\Filament\Tables\Columns;

use App\Models\Character;
use App\Providers\AppServiceProvider;
use App\Support\Enums\Rank;
use Filament\Tables\Columns\TextColumn;

class GuildRankColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Rank');
        $this->getStateUsing(static function (Character $record): null|string|Rank {
            if ($record->guild?->name !== AppServiceProvider::MAIN_GUILD) {
                return $record->guild_rank;
            }

            return Rank::from($record->guild_rank);
        });
    }
}
