<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\ThreadResource\Pages\ListThreads;
use App\Filament\Resources\ThreadResource\Pages;
use App\Models\Thread;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class ThreadResource extends Resource
{
    protected static ?string $model = Thread::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

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
                TextColumn::make('resolved_by')
                    ->label('Résolu')
                    ->badge()
                    ->getStateUsing(fn (Thread $record): string => $record->resolved_by === null ? 'Non' : 'Oui')
                    ->color(fn (Thread $record): string => $record->resolved_by === null ? 'gray' : 'success'),
                TextColumn::make('created_at')
                    ->label('Date de publication')
                    ->dateTime(),
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('view')
                        ->label('Voir le thread')
                        ->icon('heroicon-o-eye')
                        ->color('success')
                        ->url(fn (Thread $record): string => route('forum.show', $record))
                        ->openUrlInNewTab(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListThreads::route('/'),
        ];
    }
}
