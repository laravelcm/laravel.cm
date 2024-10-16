<?php

namespace App\Filament\Resources;

use App\Filament\Actions\ApprovedAction;
use App\Filament\Actions\DeclinedAction;
use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ActionGroup;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                ->label('Titre')
                ->sortable(),
                TextColumn::make('status')
                ->label('Status')
                ->getStateUsing(function ($record) {
                    if ($record->approved_at) {
                        return 'Approuver';
                    } elseif ($record->declined_at) {
                        return 'Décliner';
                    } elseif($record->submitted_at) {
                        return 'Soumis';
                    }else{
                        return 'Brouillon';
                    }
                })
                ->colors([
                    'success' => 'Approuver',
                    'danger' => 'Décliner',
                    'warning' => 'Soumis',
                    'default' => 'Brouillon',
                ])
                ->badge(),
                TextColumn::make('submitted_at')
                ->label('Date de soumission')
                ->dateTime(),
                TextColumn::make('user.name')
                ->label('Auteur')
                ->sortable()
            ])
            ->filters([
                Filter::make('submitted_at')->query( fn (Builder $query) => $query->whereNotNull('submitted_at'))->label('Soumis'),
                Filter::make('declined_at')->query( fn (Builder $query) => $query->whereNotNull('declined_at'))->label('Décliner'),
                Filter::make('approved_at')->query( fn (Builder $query) => $query->whereNotNull('approved_at'))->label('Approuver')
            ])

            ->actions([
                ActionGroup::make([
                    ApprovedAction::make('approved'),
                    DeclinedAction::make('declined'),
                    Tables\Actions\DeleteAction::make('delete'),
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
            'index' => Pages\ListArticles::route('/'),
        ];
    }
}
