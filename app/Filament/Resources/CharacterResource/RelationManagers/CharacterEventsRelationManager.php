<?php

namespace App\Filament\Resources\CharacterResource\RelationManagers;

use App\Support\Enums\CharacterEventType;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CharacterEventsRelationManager extends RelationManager
{
    protected static string $relationship = 'characterEvents';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->defaultSort('happened_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('happened_at')
                    ->label('Happened At')
                    ->since(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('old_value')
                    ->label('Old Value'),
                Tables\Columns\TextColumn::make('new_value')
                    ->label('New Value'),
            ])
            ->filters([
                Tables\Filters\Filter::make('no-meta')
                    ->query(
                        static fn (Builder $query): Builder => $query->whereNotIn(
                            'type',
                            [CharacterEventType::FirstSeen, CharacterEventType::FullUpdate, CharacterEventType::PartialUpdate]
                        ),
                    )
                    ->default(),
                Tables\Filters\SelectFilter::make('type')
                    ->options(CharacterEventType::class),
            ]);
    }
}
