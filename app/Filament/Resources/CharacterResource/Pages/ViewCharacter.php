<?php

namespace App\Filament\Resources\CharacterResource\Pages;

use App\Filament\Resources\CharacterResource;
use App\Models\Character;
use App\Tibia\TibiaService;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCharacter extends ViewRecord
{
    protected static string $resource = CharacterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('update')
                ->successNotificationTitle('Character updated!')
                ->action(function (Character $record, TibiaService $tibiaService): void {
                    $tibiaService->importCharacter($record->name);
                    $this->redirect($record->id);
                })
                ->after(function (Character $record, Actions\Action $action): void {
                    $action->sendSuccessNotification();
                }),
        ];
    }
}
