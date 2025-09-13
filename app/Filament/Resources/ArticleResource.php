<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Actions\Article\ApprovedArticleAction;
use App\Actions\Article\DeclineArticleAction;
use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

final class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function getNavigationGroup(): string
    {
        return __('Contenu');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->latest())
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('media')
                    ->collection('media')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        return $state;
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Auteur')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date de création'))
                    ->date(),
                Tables\Columns\IconColumn::make('published_at')
                    ->label('Publié')
                    ->getStateUsing(fn (Article $record): bool => $record->isPublished())
                    ->boolean(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Soumission')
                    ->placeholder('N/A')
                    ->date(),
                BadgeableColumn::make('status')
                    ->label('Statut')
                    ->getStateUsing(function ($record) {
                        if ($record->approved_at) {
                            return $record->approved_at->format('d/m/Y');
                        }

                        if ($record->declined_at) {
                            return $record->declined_at->format('d/m/Y');
                        }

                        return '';
                    })
                    ->prefixBadges(function ($record): array|string {
                        if ($record->approved_at) {
                            return [
                                Badge::make('Approuvé')
                                    ->color('success'),
                            ];
                        }

                        if ($record->declined_at) {
                            return [
                                Badge::make('Décliné')
                                    ->color('danger'),
                            ];
                        }

                        return '';
                    })
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('approved')
                        ->visible(fn (Article $record): bool => $record->isAwaitingApproval())
                        ->label('Approuver')
                        ->icon('heroicon-s-check')
                        ->color('success')
                        ->modalHeading(__('Voulez vous approuver cet article'))
                        ->successNotificationTitle(__('Opération effectuée avec succès'))
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-check')
                        ->action(function ($record): void {
                            Gate::authorize('approve', $record);

                            app(ApprovedArticleAction::class)->execute($record);
                        }),
                    Tables\Actions\Action::make('declined')
                        ->visible(fn (Article $record): bool => $record->isAwaitingApproval())
                        ->label('Décliner')
                        ->icon('heroicon-s-x-mark')
                        ->color('warning')
                        ->form([
                            Textarea::make('reason')
                                ->label(__('Raison du refus'))
                                ->maxLength(255)
                                ->required(),
                        ])
                        ->modalHeading('Décliner l\'article')
                        ->modalDescription('Veuillez fournir une raison détaillée pour le refus de cet article. L\'auteur recevra cette explication.')
                        ->successNotificationTitle('Article décliné avec succès')
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-x-mark')
                        ->action(function (array $data, Article $record): void {
                            Gate::authorize('decline', $record);

                            app(DeclineArticleAction::class)->execute($data['reason'], $record);

                            Notification::make()
                                ->title('Article décliné')
                                ->body('L\'auteur a été notifié de la raison du refus.')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('show')
                        ->icon('untitledui-eye')
                        ->url(fn (Article $record): string => route('articles.show', $record))
                        ->openUrlInNewTab()
                        ->label('Afficher'),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('declined')
                        ->label('Décliner la sélection')
                        ->icon('heroicon-s-x-mark')
                        ->color('warning')
                        ->action(fn (Collection $records) => $records->each->update(['declined_at' => now()]))
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-x-mark')
                        ->modalHeading('Décliner')
                        ->modalDescription('Voulez-vous vraiment décliner ces articles ?')
                        ->modalSubmitActionLabel('Confirmer'),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('submitted_at')
                    ->label('Soumis')
                    ->nullable(),
                Tables\Filters\TernaryFilter::make('declined_at')
                    ->label('Décliner')
                    ->nullable(),
                Tables\Filters\TernaryFilter::make('approved_at')
                    ->label('Approuver')
                    ->nullable(),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(4)
            ->filtersFormWidth(MaxWidth::FourExtraLarge);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
        ];
    }
}
