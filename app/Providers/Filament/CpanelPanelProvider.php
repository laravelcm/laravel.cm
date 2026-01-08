<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use Shopperlabs\Theme\Pureline\PurelineTheme;

final class CpanelPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('cpanel')
            ->path('cpanel')
            ->colors([
                'primary' => Color::Emerald,
                'danger' => Color::Red,
                'info' => Color::Blue,
                'success' => Color::Green,
                'warning' => Color::Amber,
            ])
            ->sidebarWidth('18.75rem')
            ->sidebarCollapsibleOnDesktop()
            ->spa(hasPrefetching: true)
            ->brandLogo(fn (): View => view('filament.brand'))
            ->favicon(asset('images/favicons/favicon-32x32.png'))
            ->discoverResources(in: app_path('Filament/Cpanel/Resources'), for: 'App\Filament\Cpanel\Resources')
            ->discoverPages(in: app_path('Filament/Cpanel/Pages'), for: 'App\Filament\Cpanel\Pages')
            ->discoverWidgets(in: app_path('Filament/Cpanel/Widgets'), for: 'App\Filament\Cpanel\Widgets')
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->plugins([
                PurelineTheme::make()
                    // @phpstan-ignore argument.type
                    ->primaryColor(Color::Emerald),
                SpatieTranslatablePlugin::make()
                    ->defaultLocales(['fr', 'en']),
            ])
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
