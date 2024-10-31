<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ThreadResource\Pages;
use App\Models\Thread;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class ThreadResource extends Resource
{
    protected static ?string $model = Thread::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->sortable(),
                TextColumn::make('locked')
                    ->label('Vérrouillé')
                    ->getStateUsing(fn ($record) => ($record->locked) ? 'Oui' : 'Non')
                    ->colors([
                        'success' => 'Oui',
                        'danger' => 'Non',
                    ])
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Date de publication')
                    ->dateTime(),
                TextColumn::make('user.name')
                    ->label('Auteur'),
            ])
            ->filters([
                Filter::make('is_locked')->query(fn (Builder $query) => $query->where('locked', true))->label('Vérrouillé'),
                SelectFilter::make('Auteur')->relationship('user', 'name')->searchable()->preload(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListThreads::route('/'),
        ];
    }
}
