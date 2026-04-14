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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

final class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|BackedEnum|null $navigationIcon = 'phosphor-pencil-line-duotone';

    public static function getNavigationGroup(): string
    {
        return __('Contenu');
    }

    public static function getNavigationBadge(): ?string
    {
        /** @var int $count */
        $count = Cache::remember(
            key: 'articles:pending_count',
            ttl: now()->addMinutes(5),
            callback: fn (): int => Article::query()
                ->whereNotNull('submitted_at')
                ->whereNull('approved_at')
                ->whereNull('declined_at')
                ->count()
        );

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): string
    {
        return __('Articles en attente de validation');
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
                Columns\IconColumn::make('is_sponsored')
                    ->label(__('Sponsorisé'))
                    ->boolean()
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
                    Actions\Action::make('sponsor')
                        ->visible(fn (Article $record): bool => $record->isPublished() && ! $record->isActivelySponsored())
                        ->label(__('Sponsoriser'))
                        ->icon('heroicon-s-star')
                        ->color('warning')
                        ->modalHeading(__('Sponsoriser cet article'))
                        ->modalDescription(__("L'article sera mis en avant sur la page d'accueil."))
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-star')
                        ->action(function (Article $record): void {
                            Gate::authorize('sponsor', $record);

                            $record->update([
                                'is_sponsored' => true,
                                'sponsored_at' => $record->sponsored_at ?? now(),
                            ]);

                            Cache::tags(['home', 'articles'])->flush();

                            Notification::make()
                                ->title(__('Article sponsorisé'))
                                ->success()
                                ->send();
                        }),
                    Actions\Action::make('unsponsor')
                        ->visible(fn (Article $record): bool => $record->isActivelySponsored())
                        ->label(__('Retirer le sponsoring'))
                        ->icon('heroicon-s-x-circle')
                        ->color('gray')
                        ->modalHeading(__('Retirer le sponsoring'))
                        ->modalDescription(__('L\'article ne sera plus mis en avant mais conservera son badge sponsorisé.'))
                        ->requiresConfirmation()
                        ->modalIcon('heroicon-s-x-circle')
                        ->action(function (Article $record): void {
                            Gate::authorize('sponsor', $record);

                            $record->update(['is_sponsored' => false]);

                            Cache::tags(['home', 'articles'])->flush();

                            Notification::make()
                                ->title(__('Sponsoring retiré'))
                                ->success()
                                ->send();
                        }),
                    Actions\Action::make('show')
                        ->icon('untitledui-eye')
                        ->url(fn (Article $record): string => route('articles.show', $record))
                        ->openUrlInNewTab()
                        ->label(__('Afficher')),
                    Actions\DeleteAction::make()
                        ->button()
                        ->label(__('Supprimer'))
                        ->after(fn () => Cache::tags(['home', 'articles'])->flush()),
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
