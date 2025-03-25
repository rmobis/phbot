<?php

namespace App\Filament\Resources\MemberResource\RelationManagers;

use App\Filament\Tables\Actions\BetterAction;
use App\Filament\Tables\Columns\BetterTextColumn;
use App\Filament\Tables\Columns\GuildColumn;
use App\Filament\Tables\Columns\GuildRankColumn;
use App\Models\Character;
use App\Models\Member;
use App\Support\Enums\Vocation;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CharactersRelationManager extends RelationManager
{
    protected static string $relationship = 'characters';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->inverseRelationship('member')
            ->paginated(false)
            ->columns([
                BetterTextColumn::make('name')
                    ->isMain(
                        static fn (Member $parent, Character $record) => $parent->main_character_id === $record->id
                    ),
                Tables\Columns\TextColumn::make('level')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('vocation')
                    ->label('Voc')
                    ->formatStateUsing(static fn (Vocation $state) => $state->getShortValue()),
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
                //
            ])
            ->headerActions([
                Tables\Actions\AssociateAction::make()
                    ->recordSelect(
                        static function (Forms\Components\Select $select) {
                            return $select->unique(Member::class, 'main_character_id')
                                ->validationMessages([
                                    'unique' => 'This character is already the main character for another member.',
                                ]);
                        },
                    )
                    ->preloadRecordSelect(),
            ])
            ->actions([
                BetterAction::make('mark-as-main')
                    ->successNotificationTitle(
                        static fn (Character $record) => "Character {$record->name} marked as main!",
                    )
                    ->action(function (Member $parent, Character $record): void {
                        $parent->update(['main_character_id' => $record->id]);
                    })
                    ->after(function (Tables\Actions\Action $action): void {
                        $action->sendSuccessNotification();
                    }),
                Tables\Actions\DissociateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\DissociateBulkAction::make(),
                ]),
            ])
            ->defaultSort(static function (Builder $query) {
                // force main character to be the first
                return $query->orderBy(
                    Member::select('name')
                        ->where('main_character_id', DB::raw('"characters"."id"'))
                        ->limit(1)
                );
            });
    }
}
