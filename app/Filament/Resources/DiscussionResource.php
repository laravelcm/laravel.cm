<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\DiscussionResource\Pages;
use App\Models\Discussion;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class DiscussionResource extends Resource
{
    protected static ?string $model = Discussion::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->sortable(),
                TextColumn::make('Vérrouillé')
                    ->getStateUsing(fn ($record) => ($record->locked) ? 'OUI' : 'NON')
                    ->colors([
                        'success' => 'OUI',
                        'danger' => 'NON',
                    ])
                    ->badge(),
                TextColumn::make('Epinglé')
                    ->getStateUsing(fn ($record) => ($record->is_pinned) ? 'OUI' : 'NON')
                    ->colors([
                        'success' => 'OUI',
                        'danger' => 'NON',
                    ])
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Date de création')
                    ->dateTime(),
                TextColumn::make('user.name')
                    ->label('Auteur'),
            ])
            ->filters([
                Filter::make('is_pinned')->query(fn (Builder $query) => $query->where('is_pinned', true))->label('Epinglé'),
                Filter::make('is_locked')->query(fn (Builder $query) => $query->where('locked', true))->label('Vérrouillé'),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make('delete'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscussions::route('/'),
        ];
    }
}
