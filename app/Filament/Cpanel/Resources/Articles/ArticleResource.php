<?php

declare(strict_types=1);

namespace App\Filament\Cpanel\Resources\Articles;

use App\Actions\Article\ApprovedArticleAction;
use App\Actions\Article\DeclineArticleAction;
use App\Models\Article;
use App\Models\Builders\ArticleQueryBuilder;
use Awcodes\BadgeableColumn\Components\Badge;
use Awcodes\BadgeableColumn\Components\BadgeableColumn;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Columns;
use Filament\Tables\Filters;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

final class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|BackedEnum|null $navigationIcon = 'phosphor-pencil-line-duotone';

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
                    ->label(__('Image'))
                    ->circular(),
                Columns\TextColumn::make('title')
                    ->label(__('Titre'))
                    ->limit(50)
                    ->tooltip(function (Columns\TextColumn $column): ?string {
                        /** @var string $state */
                        $state = $column->getState();

                        if (mb_strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        return $state;
                    })
                    ->sortable()
                    ->searchable(),
                Columns\TextColumn::make('user.name')
                    ->label(__('Auteur'))
                    ->sortable()
                    ->searchable(),
                Columns\TextColumn::make('created_at')
                    ->label(__('Date de création'))
                    ->date()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Columns\IconColumn::make('published_at')
                    ->label(__('Publié'))
                    ->getStateUsing(fn (Article $record): bool => $record->isPublished())
                    ->boolean(),
                Columns\TextColumn::make('submitted_at')
                    ->label(__('Soumission'))
                    ->placeholder('N/A')
                    ->date(),
                BadgeableColumn::make('status')
                    ->label(__('Statut'))
                    ->getStateUsing(function (Article $record): string {
                        if ($record->approved_at) {
                            return $record->approved_at->format('d/m/Y');
                        }

                        if ($record->declined_at) {
                            return $record->declined_at->format('d/m/Y');
                        }

                        return '';
                    })
                    ->prefixBadges(function (Article $record): array {
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
                        ->label(__('Approuver'))
                        ->icon('heroicon-s-check')
                        ->color('success')
                        ->modalHeading(__('Voulez vous approuver cet article'))
                        ->successNotificationTitle(__('Opération effectuée avec succès'))
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-check')
                        ->action(function (Article $record): void {
                            Gate::authorize('approve', $record);

                            resolve(ApprovedArticleAction::class)->execute($record);
                        }),
                    Actions\Action::make('declined')
                        ->visible(fn (Article $record): bool => $record->isAwaitingApproval())
                        ->label(__('Décliner'))
                        ->icon('heroicon-s-x-mark')
                        ->color('warning')
                        ->schema([
                            Textarea::make('reason')
                                ->label(__('Raison du refus'))
                                ->maxLength(255)
                                ->required(),
                        ])
                        ->modalHeading(__('Décliner l\'article'))
                        ->modalDescription(__('Veuillez fournir une raison détaillée pour le refus de cet article. L\'auteur recevra cette explication.'))
                        ->successNotificationTitle(__('Article décliné avec succès'))
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-x-mark')
                        ->action(function (array $data, Article $record): void {
                            Gate::authorize('decline', $record);

                            resolve(DeclineArticleAction::class)->execute($data['reason'], $record);

                            Notification::make()
                                ->title(__('Article décliné'))
                                ->body(__('L\'auteur a été notifié de la raison du refus.'))
                                ->success()
                                ->send();
                        }),
                    Actions\Action::make('show')
                        ->icon('untitledui-eye')
                        ->url(fn (Article $record): string => route('articles.show', $record))
                        ->openUrlInNewTab()
                        ->label(__('Afficher')),
                    Actions\DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\BulkAction::make('declined')
                        ->label(__('Décliner la sélection'))
                        ->icon('heroicon-s-x-mark')
                        ->color('warning')
                        ->action(fn (Collection $records) => $records->each->update(['declined_at' => now()]))
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-x-mark')
                        ->modalHeading(__('Décliner'))
                        ->modalDescription(__('Voulez-vous vraiment décliner ces articles ?'))
                        ->modalSubmitActionLabel(__('Confirmer')),
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                Filters\SelectFilter::make('status')
                    ->label(__('Statut'))
                    ->options([
                        'pending' => __('En attente'),
                        'approved' => __('Approuvé'),
                        'declined' => __('Décliné'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        /** @var ArticleQueryBuilder $query */
                        return match ($data['value'] ?? null) {
                            'pending' => $query->awaitingApproval(),
                            'approved' => $query->published(),
                            'declined' => $query->declined(),
                            default => $query,
                        };
                    }),
                Filters\SelectFilter::make('user_id')
                    ->label(__('Auteur'))
                    ->relationship('user', 'name', fn (Builder $query) => $query->whereHas('articles'))
                    ->searchable()
                    ->multiple()
                    ->preload()
                    ->optionsLimit(10),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
        ];
    }
}
