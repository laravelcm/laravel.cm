<?php

declare(strict_types=1);

namespace App\Filament\Cpanel\Resources\Threads;

use App\Models\Thread;
use BackedEnum;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Tables\Columns;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class ThreadResource extends Resource
{
    protected static ?string $model = Thread::class;

    protected static string|BackedEnum|null $navigationIcon = 'phosphor-chat-centered-dots-duotone';

    public static function getNavigationGroup(): string
    {
        return __('Forum');
    }

    public static function getLabel(): string
    {
        return __('Sujets');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->latest())
            ->columns([
                Columns\TextColumn::make('title')
                    ->label(__('Titre'))
                    ->limit(50)
                    ->sortable(),
                Columns\TextColumn::make('channels.name')
                    ->label(__('Channels'))
                    ->badge()
                    ->toggleable(),
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
                    ->getStateUsing(fn (Thread $record): string => $record->resolved_by === null ? __('Non') : __('Oui'))
                    ->color(fn (Thread $record): string => $record->resolved_by === null ? 'gray' : 'success'),
                Columns\TextColumn::make('created_at')
                    ->label(__('Date de publication'))
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->dateTime(),
            ])
            ->recordActions([
                Actions\Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->iconButton()
                    ->url(fn (Thread $record): string => route('forum.show', $record))
                    ->openUrlInNewTab(),
                Actions\DeleteAction::make(),
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
                    ->multiple()
                    ->preload(),
                TernaryFilter::make('resolved')
                    ->label(__('Résolu'))
                    ->attribute('resolved_by')
                    ->nullable(),
                TernaryFilter::make('locked')
                    ->label(__('Vérrouillé'))
                    ->nullable(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListThreads::route('/'),
        ];
    }
}
