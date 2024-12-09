<?php

namespace App\Filament\Tables\Columns;

use App\Filament\Support\Concerns\CanBeMain;
use App\Filament\Support\Concerns\CanLinkToResource;
use App\Models\Character;
use App\Models\Guild;
use App\Providers\AppServiceProvider;
use Filament\Tables\Columns\TextColumn;

class GuildColumn extends TextColumn
{
    use CanBeMain;
    use CanLinkToResource;

    protected function setUp(): void
    {
        parent::setUp();

        $this->isMain(static fn (?string $state) => $state === AppServiceProvider::MAIN_GUILD);
        $this->viewLink(static fn (Character $record): ?Guild => $record->guild);
        $this->placeholder('-');
    }
}
