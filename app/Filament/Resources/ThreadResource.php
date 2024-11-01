<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ThreadResource\Pages;
use App\Models\Thread;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

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
                IconColumn::make('locked')
                    ->label('Vérrouillé')
                    ->options([
                        'heroicon-s-lock-closed' => fn ($record) => $record->locked === true,
                        'heroicon-s-lock-open' => fn ($record) => $record->locked === false,
                    ])
                    ->colors([
                        'warning' => fn ($record) => $record->locked === true,
                        'success' => fn ($record) => $record->locked === false,
                    ]),
                IconColumn::make('resolved_by')
                    ->label('Résolut')
                    ->getStateUsing(fn ($record) => $record->resolved_by == null ? 'heroicon-s-x-mark' : 'heroicon-s-check')
                    ->icon(fn ($state) => $state)
                    ->color(fn ($state) => $state === 'heroicon-s-x-mark' ? 'warning' : 'success')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Date de publication')
                    ->dateTime(),
                TextColumn::make('user.name')
                    ->label('Auteur'),
            ])
            ->filters([
                SelectFilter::make('Channels')->relationship('channels', 'name')->searchable()->preload(),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('view')
                        ->label('Voir le thread')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->url(fn (Thread $record): string => route('forum.show', $record))
                        ->openUrlInNewTab(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
