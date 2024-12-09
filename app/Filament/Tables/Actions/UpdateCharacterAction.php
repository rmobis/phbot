<?php

namespace App\Filament\Tables\Actions;

use App\Models\Character;
use App\Tibia\TibiaService;
use Filament\Tables\Actions\Action;

class UpdateCharacterAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->successNotificationTitle(
            static fn (Character $record) => "Character {$record->name} updated!"
        );
        $this->action(function (Character $record, TibiaService $tibiaService): void {
            $tibiaService->importCharacter($record->name);
        });
        $this->after(function (self $action): void {
            $action->sendSuccessNotification();
        });
    }
}
