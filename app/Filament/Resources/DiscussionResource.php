<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\DiscussionResource\Pages;
use App\Models\Discussion;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class DiscussionResource extends Resource
{
    protected static ?string $model = Discussion::class;

    protected static ?string $navigationIcon = 'untitledui-message-chat-square';

    public static function getNavigationGroup(): string
    {
        return __('Contenu');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Auteur')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('count_all_replies_with_child')
                    ->label('Commentaires'),
                Tables\Columns\IconColumn::make('locked')
                    ->label('Vérrouillé')
                    ->boolean()
                    ->trueIcon('untitledui-lock-04')
                    ->trueColor('warning')
                    ->falseIcon('untitledui-lock-unlocked-04')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->date(),
            ])
            ->filters([
                Filter::make('is_pinned')->query(fn (Builder $query) => $query->where('is_pinned', true))->label('Epinglé'),
                Filter::make('is_locked')->query(fn (Builder $query) => $query->where('locked', true))->label('Vérrouillé'),
            ])
            ->actions([
                Tables\Actions\Action::make('show')
                    ->icon('untitledui-eye')
                    ->iconButton()
                    ->color('gray')
                    ->url(fn (Discussion $record) => route('discussions.show', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
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
