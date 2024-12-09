<?php

namespace App\Filament\Resources;

use App\Filament\Infolists\Components\GuildEntry;
use App\Filament\Infolists\Components\GuildRankEntry;
use App\Filament\Resources\CharacterResource\Pages;
use App\Filament\Resources\CharacterResource\RelationManagers;
use App\Filament\Tables\Actions\ExevoPanBazaarLinkAction;
use App\Filament\Tables\Actions\GuildStatsLinkAction;
use App\Filament\Tables\Actions\TibiaLinkAction;
use App\Filament\Tables\Actions\UpdateCharacterAction;
use App\Filament\Tables\Actions\UpdateCharactersBulkAction;
use App\Filament\Tables\Columns\BetterTextColumn;
use App\Filament\Tables\Columns\GuildColumn;
use App\Filament\Tables\Columns\GuildRankColumn;
use App\Models\Character;
use App\Models\Guild;
use App\Models\Member;
use App\Support\Enums\Vocation;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CharacterResource extends Resource
{
    protected static ?string $model = Character::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

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
                        GuildEntry::make('guild.name')
                            ->label('Name'),
                        GuildRankEntry::make('guild_rank'),
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
                BetterTextColumn::make('member.fullName')
                    ->viewLink(static fn (Character $record): ?Member => $record->member),
                GuildColumn::make('guild.name')
                    ->sortable(),
                GuildRankColumn::make('guild_rank')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->since()
                    ->dateTimeTooltip(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('guild.name')
                    ->relationship('guild', 'name')
                    ->preload(),
            ])
            ->actions([
                UpdateCharacterAction::make('update'),
                Tables\Actions\ActionGroup::make([
                    TibiaLinkAction::make('tibia'),
                    GuildStatsLinkAction::make('guildstats'),
                    ExevoPanBazaarLinkAction::make('bazaar-history'),
                ]),
            ])
            ->bulkActions([
                UpdateCharactersBulkAction::make('update'),
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
