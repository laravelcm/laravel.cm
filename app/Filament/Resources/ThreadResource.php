<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ThreadResource\Pages;
use App\Models\Thread;
use Filament\Resources\Resource;
use Filament\Tables;
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
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Auteur'),
                Tables\Columns\IconColumn::make('locked')
                    ->label('Vérrouillé')
                    ->boolean()
                    ->trueIcon('heroicon-s-lock-closed')
                    ->trueColor('warning')
                    ->falseIcon('heroicon-s-lock-open')
                    ->falseColor('success'),
                Tables\Columns\TextColumn::make('resolved_by')
                    ->label('Résolu')
                    ->badge()
                    ->getStateUsing(fn (Thread $record): string => $record->resolved_by === null ? 'Non' : 'Oui')
                    ->color(fn (Thread $record): string => $record->resolved_by === null ? 'gray' : 'success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date de publication')
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view')
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Channels')
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
