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

    public static function getNavigationGroup(): string
    {
        return __('Forum');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Auteur'),
                IconColumn::make('locked')
                    ->label('Vérrouillé')
                    ->boolean()
                    ->trueIcon('heroicon-s-lock-closed')
                    ->trueColor('warning')
                    ->falseIcon('heroicon-s-lock-open')
                    ->falseColor('success'),
                TextColumn::make('resolvedBy.name')
                    ->label('Résolu par'),
                TextColumn::make('created_at')
                    ->label('Date de publication')
                    ->dateTime(),
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
