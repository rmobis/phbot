<?php

namespace App\Filament\Resources\GuildResource\Pages;

use App\Filament\Resources\GuildResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuilds extends ListRecords
{
    protected static string $resource = GuildResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
