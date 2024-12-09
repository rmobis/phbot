<?php

namespace App\Filament\Tables\Actions;

use App\Models\Character;
use Filament\Tables\Actions\Action;

abstract class FansiteLinkAction extends Action
{
    protected static string $BASE_URL;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-s-arrow-top-right-on-square');
        $this->url(
            fn (Character $record) => $this->getLink($record),
            true
        );
    }

    protected function getLink(Character $record): string
    {
        return static::$BASE_URL.$record->name;
    }
}
