<?php

namespace App\Filament\Tables\Actions;

use App\Models\Character;
use App\Tibia\TibiaService;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class UpdateCharactersBulkAction extends BulkAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->requiresConfirmation(
            static fn (Collection $records) => $records->count() > 5
        );
        $this->successNotificationTitle(
            static fn (Collection $records) => "{$records->count()} characters updated!"
        );
        $this->action(
            /** @param Collection<Character> $records */
            function (Collection $records, TibiaService $tibiaService): void {
                foreach ($records as $record) {
                    $tibiaService->importCharacter($record->name);
                }
            });
        $this->after(function (self $action): void {
            $action->sendSuccessNotification();
        });
    }
}
