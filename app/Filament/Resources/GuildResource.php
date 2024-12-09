<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuildResource\Pages;
use App\Filament\Tables\Columns\BetterTextColumn;
use App\Models\Guild;
use App\Providers\AppServiceProvider;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GuildResource extends Resource
{
    protected static ?string $model = Guild::class;

    protected static ?string $navigationIcon = 'rpg-round-shield';

    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BetterTextColumn::make('name')
                    ->isMain(static fn (?string $state) => $state === AppServiceProvider::MAIN_GUILD)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('world.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('characters_count')
                    ->label('Characters')
                    ->counts('characters'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuilds::route('/'),
            'view' => Pages\ViewGuild::route('/{record}'),
        ];
    }
}
