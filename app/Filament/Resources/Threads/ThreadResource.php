<?php

declare(strict_types=1);

namespace App\Filament\Resources\Threads;

use App\Models\Thread;
use BackedEnum;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Tables\Columns;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

final class ThreadResource extends Resource
{
    protected static ?string $model = Thread::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getNavigationGroup(): string
    {
        return __('Forum');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('title')
                    ->label(__('Titre'))
                    ->sortable(),
                Columns\TextColumn::make('user.name')
                    ->label(__('Auteur')),
                Columns\IconColumn::make('locked')
                    ->label(__('Vérrouillé'))
                    ->boolean()
                    ->trueIcon('heroicon-s-lock-closed')
                    ->trueColor('warning')
                    ->falseIcon('heroicon-s-lock-open')
                    ->falseColor('success'),
                Columns\TextColumn::make('resolved_by')
                    ->label(__('Résolu'))
                    ->badge()
                    ->getStateUsing(fn (Thread $record): string => $record->resolved_by === null ? 'Non' : 'Oui')
                    ->color(fn (Thread $record): string => $record->resolved_by === null ? 'gray' : 'success'),
                Columns\TextColumn::make('created_at')
                    ->label(__('Date de publication'))
                    ->dateTime(),
            ])
            ->recordActions([
                Actions\ActionGroup::make([
                    Actions\Action::make('view')
                        ->label(__('Voir le thread'))
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->url(fn (Thread $record): string => route('forum.show', $record))
                        ->openUrlInNewTab(),
                    Actions\DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                SelectFilter::make('Channels')
                    ->relationship('channels', 'name')
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListThreads::route('/'),
        ];
    }
}
