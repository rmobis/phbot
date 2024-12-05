<?php

namespace App\Filament\Resources\CharacterResource\Pages;

use App\Filament\Resources\CharacterResource;
use App\Tibia\TibiaService;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Pages\ListRecords;

class ListCharacters extends ListRecords
{
    protected static string $resource = CharacterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('import-new')
                ->label('Import New')
                ->form([
                    Forms\Components\Textarea::make('names')
                        ->helperText('One name per line')
                        ->required(),
                ])
                ->action(function (array $data, TibiaService $tibiaService): void {
                    $names = collect(explode("\n", $data['names'] ?? ''))
                        ->filter();

                    foreach ($names as $name) {
                        $tibiaService->importCharacter($name);
                    }
                }),
        ];
    }
}
