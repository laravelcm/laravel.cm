<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\DiscussionResource\Pages\ListDiscussions;
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

    protected static string | \BackedEnum | null $navigationIcon = 'untitledui-message-chat-square';

    public static function getNavigationGroup(): string
    {
        return __('Contenu');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Auteur')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('count_all_replies_with_child')
                    ->label('Commentaires'),
                IconColumn::make('locked')
                    ->label('Vérrouillé')
                    ->boolean()
                    ->trueIcon('untitledui-lock-04')
                    ->trueColor('warning')
                    ->falseIcon('untitledui-lock-unlocked-04')
                    ->falseColor('gray'),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->date(),
            ])
            ->filters([
                Filter::make('is_pinned')->query(fn (Builder $query) => $query->where('is_pinned', true))->label('Epinglé'),
                Filter::make('is_locked')->query(fn (Builder $query) => $query->where('locked', true))->label('Vérrouillé'),
            ])
            ->recordActions([
                Action::make('show')
                    ->icon('untitledui-eye')
                    ->iconButton()
                    ->color('gray')
                    ->url(fn (Discussion $record): string => route('discussions.show', $record))
                    ->openUrlInNewTab(),
                DeleteAction::make()
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDiscussions::route('/'),
        ];
    }
}
