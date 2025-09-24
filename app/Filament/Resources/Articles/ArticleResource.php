<?php

declare(strict_types=1);

namespace App\Filament\Resources\Articles;

use App\Actions\Article\ApprovedArticleAction;
use App\Actions\Article\DeclineArticleAction;
use App\Models\Article;
use Awcodes\BadgeableColumn\Components\Badge;
use Awcodes\BadgeableColumn\Components\BadgeableColumn;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

final class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    public static function getNavigationGroup(): string
    {
        return __('Contenu');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->latest())
            ->columns([
                Columns\SpatieMediaLibraryImageColumn::make('media')
                    ->collection('media')
                    ->label('Image'),
                Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->limit(50)
                    ->tooltip(function (Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        return $state;
                    })
                    ->sortable()
                    ->searchable(),
                Columns\TextColumn::make('user.name')
                    ->label('Auteur')
                    ->sortable()
                    ->searchable(),
                Columns\TextColumn::make('created_at')
                    ->label(__('Date de création'))
                    ->date(),
                Columns\IconColumn::make('published_at')
                    ->label('Publié')
                    ->getStateUsing(fn (Article $record): bool => $record->isPublished())
                    ->boolean(),
                Columns\TextColumn::make('submitted_at')
                    ->label('Soumission')
                    ->placeholder('N/A')
                    ->date(),
                BadgeableColumn::make('status')
                    ->label('Statut')
                    ->getStateUsing(function ($record): string {
                        if ($record->approved_at) {
                            return $record->approved_at->format('d/m/Y');
                        }

                        if ($record->declined_at) {
                            return $record->declined_at->format('d/m/Y');
                        }

                        return '';
                    })
                    ->prefixBadges(function ($record): array {
                        if ($record->approved_at) {
                            return [
                                Badge::make('Approuvé')->color('success'),
                            ];
                        }

                        if ($record->declined_at) {
                            return [
                                Badge::make('Décliné')->color('danger'),
                            ];
                        }

                        return [];
                    })
                    ->sortable(),
            ])
            ->recordActions([
                Actions\ActionGroup::make([
                    Actions\Action::make('approved')
                        ->visible(fn (Article $record): bool => $record->isAwaitingApproval())
                        ->label('Approuver')
                        ->icon('heroicon-s-check')
                        ->color('success')
                        ->modalHeading(__('Voulez vous approuver cet article'))
                        ->successNotificationTitle(__('Opération effectuée avec succès'))
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-check')
                        ->action(function (Article $record): void {
                            Gate::authorize('approve', $record);

                            app(ApprovedArticleAction::class)->execute($record);
                        }),
                    Actions\Action::make('declined')
                        ->visible(fn (Article $record): bool => $record->isAwaitingApproval())
                        ->label('Décliner')
                        ->icon('heroicon-s-x-mark')
                        ->color('warning')
                        ->schema([
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
                    Actions\Action::make('show')
                        ->icon('untitledui-eye')
                        ->url(fn (Article $record): string => route('articles.show', $record))
                        ->openUrlInNewTab()
                        ->label('Afficher'),
                    Actions\DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\BulkAction::make('declined')
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
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                Filters\TernaryFilter::make('submitted_at')
                    ->label('Soumis')
                    ->nullable(),
                Filters\TernaryFilter::make('declined_at')
                    ->label('Décliner')
                    ->nullable(),
                Filters\TernaryFilter::make('approved_at')
                    ->label('Approuver')
                    ->nullable(),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(4)
            ->filtersFormWidth(Width::FourExtraLarge);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
        ];
    }
}
