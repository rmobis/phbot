<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CharacterResource\Pages;
use App\Filament\Resources\CharacterResource\RelationManagers;
use App\Models\Character;
use App\Models\Guild;
use App\Providers\AppServiceProvider;
use App\Support\Enums\Rank;
use App\Support\Enums\Vocation;
use App\Tibia\TibiaService;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class CharacterResource extends Resource
{
    protected static ?string $model = Character::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('General Information')
                    ->columns()
                    ->schema([
                        TextEntry::make('name')
                            ->columnSpanFull(),
                        TextEntry::make('vocation'),
                        TextEntry::make('level')
                            ->numeric(),
                    ]),

                Section::make('Guild')
                    ->columns()
                    ->visible(static fn (Character $record) => $record->guild instanceof Guild)
                    ->schema([
                        TextEntry::make('guild.name')
                            ->label('Name')
                            ->icons([
                                'heroicon-s-star' => static fn (?string $state) => $state === AppServiceProvider::MAIN_GUILD,
                            ])
                            ->iconColor('primary')
                            ->url(
                                static function (Character $record): ?string {
                                    if (! $record->guild instanceof Guild) {
                                        return null;
                                    }

                                    return route(
                                        'filament.admin.resources.guilds.view',
                                        ['record' => $record->guild]
                                    );
                                },
                            )
                            ->placeholder('-'),
                        TextEntry::make('guild_rank')
                            ->label('Rank')
                            ->iconColor(static fn (?Rank $state) => $state->getColor())
                            ->getStateUsing(static function (Character $record): null|string|Rank {
                                if ($record->guild?->name !== AppServiceProvider::MAIN_GUILD) {
                                    return $record->guild_rank;
                                }

                                return Rank::tryFrom($record->guild_rank);
                            })
                            ->placeholder('-'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vocation')
                    ->label('Voc')
                    ->formatStateUsing(static fn (Vocation $state) => $state->getShortValue()),
                Tables\Columns\TextColumn::make('guild.name')
                    ->icons([
                        'heroicon-s-star' => static fn (?string $state) => $state === AppServiceProvider::MAIN_GUILD,
                    ])
                    ->iconColor('primary')
                    ->url(
                        static function (Character $record): ?string {
                            if (! $record->guild instanceof Guild) {
                                return null;
                            }

                            return route(
                                'filament.admin.resources.guilds.view',
                                ['record' => $record->guild]
                            );
                        },
                    )
                    ->placeholder('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('guild_rank')
                    ->label('Rank')
                    ->getStateUsing(static function (Character $record): null|string|Rank {
                        if ($record->guild?->name !== AppServiceProvider::MAIN_GUILD) {
                            return $record->guild_rank;
                        }

                        return Rank::tryFrom($record->guild_rank);
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('guild.name')
                    ->relationship('guild', 'name')
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\Action::make('update')
                    ->successNotificationTitle(
                        static fn (Character $record) => "Character {$record->name} updated!"
                    )
                    ->action(function (Character $record, TibiaService $tibiaService): void {
                        $tibiaService->importCharacter($record->name);
                    })
                    ->after(function (Tables\Actions\Action $action): void {
                        $action->sendSuccessNotification();
                    }),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('tibia')
                        ->icon('heroicon-s-arrow-top-right-on-square')
                        ->url(
                            static fn (Character $record) => 'https://www.tibia.com/community/?subtopic=characters&name='.urlencode($record->name),
                            true
                        ),
                    Tables\Actions\Action::make('guildstats')
                        ->label('GuildStats')
                        ->icon('heroicon-s-arrow-top-right-on-square')
                        ->url(
                            static fn (Character $record) => 'https://guildstats.eu/character?nick='.urlencode($record->name),
                            true
                        ),
                    Tables\Actions\Action::make('bazaar-history')
                        ->icon('heroicon-s-arrow-top-right-on-square')
                        ->url(
                            static fn (Character $record) => 'https://www.exevopan.com/?mode=history&descending=true&nicknameFilter='.urlencode($record->name),
                            true
                        ),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('update')
                    ->requiresConfirmation(
                        static fn (Collection $records) => $records->count() > 5
                    )
                    ->successNotificationTitle(
                        static fn (Collection $records) => "{$records->count()} characters updated!"
                    )
                    ->action(
                        /** @param Collection<Character> $records */
                        function (Collection $records, TibiaService $tibiaService): void {
                            foreach ($records as $record) {
                                $tibiaService->importCharacter($record->name);
                            }
                        })
                    ->after(function (Tables\Actions\BulkAction $action): void {
                        $action->sendSuccessNotification();
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CharacterEventsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCharacters::route('/'),
            'view' => Pages\ViewCharacter::route('/{record}'),
        ];
    }
}
