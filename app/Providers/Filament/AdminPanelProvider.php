<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Resources\ArticleResource\Widgets\ArticleStatsOverview;
use App\Filament\Resources\ArticleResource\Widgets\MostLikedPostsChart;
use App\Filament\Resources\ArticleResource\Widgets\MostViewedPostsChart;
use App\Filament\Resources\UserResource\Widgets\UserActivityWidget;
use App\Filament\Resources\UserResource\Widgets\UserChartWidget;
use App\Filament\Resources\UserResource\Widgets\UserStatsOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Vormkracht10\FilamentMails\FilamentMailsPlugin;

final class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('cp')
            ->login()
            ->colors([
                'primary' => Color::Green,
            ])
            ->sidebarWidth('18.75rem')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->brandLogo(fn () => view('filament.brand'))
            ->favicon(asset('images/favicons/favicon-32x32.png'))
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                UserStatsOverview::class,
                UserChartWidget::class,
                UserActivityWidget::class,
                ArticleStatsOverview::class,
                MostLikedPostsChart::class,
                MostViewedPostsChart::class,
            ])
            ->plugins([
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(['fr', 'en']),
                FilamentMailsPlugin::make(),
            ])
            ->renderHook(
                'body.start',
                fn (): string => Blade::render('@livewire(\'livewire-ui-modal\')'),
            )
            ->databaseNotifications()
            ->databaseNotificationsPolling('3600s')
            ->spa()
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
