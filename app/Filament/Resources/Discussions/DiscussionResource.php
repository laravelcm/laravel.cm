<?php

declare(strict_types=1);

namespace App\Filament\Resources\Discussions;

use App\Models\Discussion;
use BackedEnum;
use Filament\Actions;
use Filament\Resources\Resource;
use Filament\Tables\Columns;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class DiscussionResource extends Resource
{
    protected static ?string $model = Discussion::class;

    protected static string|BackedEnum|null $navigationIcon = 'untitledui-message-chat-square';

    public static function getNavigationGroup(): string
    {
        return __('Contenu');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('title')
                    ->label(__('Titre'))
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                Columns\TextColumn::make('user.name')
                    ->label(__('Auteur'))
                    ->sortable()
                    ->searchable(),
                Columns\TextColumn::make('replies_count')
                    ->label(__('Commentaires'))
                    ->counts('replies'),
                Columns\IconColumn::make('locked')
                    ->label(__('Vérrouillé'))
                    ->boolean()
                    ->trueIcon('untitledui-lock-04')
                    ->trueColor('warning')
                    ->falseIcon('untitledui-lock-unlocked-04')
                    ->falseColor('gray'),
                Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->date(),
            ])
            ->filters([
                Filter::make('is_pinned')
                    ->query(fn (Builder $query) => $query->where('is_pinned', true))
                    ->label(__('Epinglé')),
                Filter::make('is_locked')
                    ->query(fn (Builder $query) => $query->where('locked', true))
                    ->label(__('Vérrouillé')),
            ])
            ->recordActions([
                Actions\Action::make('show')
                    ->icon('untitledui-eye')
                    ->iconButton()
                    ->color('gray')
                    ->url(fn (Discussion $record): string => route('discussions.show', $record))
                    ->openUrlInNewTab(),
                Actions\DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
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
