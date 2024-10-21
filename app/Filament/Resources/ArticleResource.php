<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->sortable(),
                TextColumn::make('status')
                    ->getStateUsing(function ($record) {
                        if ($record->approved_at) {
                            return 'Approuver';
                        } elseif ($record->declined_at) {
                            return 'Décliner';
                        } elseif ($record->submitted_at) {
                            return 'Soumis';
                        } else {
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
                    ->sortable(),
            ])
            ->filters([
                Filter::make('submitted_at')->query(fn (Builder $query) => $query->whereNotNull('submitted_at'))->label('Soumis'),
                Filter::make('declined_at')->query(fn (Builder $query) => $query->whereNotNull('declined_at'))->label('Décliner'),
                Filter::make('approved_at')->query(fn (Builder $query) => $query->whereNotNull('approved_at'))->label('Approuver'),
            ])

            ->actions([
                ActionGroup::make([
                    Action::make('approved')
                        ->visible(fn (Article $record) => $record->isAwaitingApproval())
                        ->label('Approuver')
                        ->icon('heroicon-s-check')
                        ->color('success')
                        ->modalHeading(__('Voulez vous approuver cet article'))
                        ->successNotificationTitle(__('Opération effectuée avec succès'))
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-check')
                        ->action(function ($record): void {
                            $record->approved_at = now();
                            $record->save();
                        }),
                    Action::make('declined')
                        ->visible(fn (Article $record) => $record->isAwaitingApproval())
                        ->label('Décliner')
                        ->icon('heroicon-s-x-mark')
                        ->color('warning')
                        ->modalHeading(__('Voulez vous décliner cet article'))
                        ->successNotificationTitle(__('Opération effectuée avec succès'))
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-x-mark')
                        ->action(function ($record): void {
                            $record->declined_at = now();
                            $record->save();
                        }),
                    Tables\Actions\DeleteAction::make('delete'),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('approved')
                        ->label('Approuver la sélection')
                        ->icon('heroicon-s-check')
                        ->color('success')
                        ->action(fn (Collection $records) => $records->each->update(['approved_at' => now()]))
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-check')
                        ->modalHeading('Approuver')
                        ->modalSubheading('Voulez-vous vraiment approuver ces articles ?')
                        ->modalButton('Confirmer'),
                    BulkAction::make('declined')
                        ->label('Décliner la sélection')
                        ->icon('heroicon-s-x-mark')
                        ->color('warning')
                        ->action(fn (Collection $records) => $records->each->update(['declined_at' => now()]))
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-x-mark')
                        ->modalHeading('Décliner')
                        ->modalSubheading('Voulez-vous vraiment décliner ces articles ?')
                        ->modalButton('Confirmer'),

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
