<?php

declare(strict_types=1);

namespace Laravelcm\Badges\Providers;

use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Laravelcm\Badges\BadgesPlugin;
use Laravelcm\Badges\Console\MakeBadgeCommand;
use Laravelcm\Badges\Console\MakePointCommand;
use Laravelcm\Badges\Events\ReputationChanged;
use Laravelcm\Badges\Listeners\SyncBadges;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class BadgesServiceProvider extends PackageServiceProvider
{
    public function register(): void
    {
        Panel::configureUsing(fn (Panel $panel) => $panel->getId() !== 'admin' || $panel->plugin(new BadgesPlugin));
    }

    public function boot(): void
    {
        Relation::morphMap([]);
    }

    public function configurePackage(Package $package): void
    {
        $package->name('gamify')
            ->hasConfigFile()
            ->hasMigrations([
                'add_reputation_on_user_table',
                'create_gamify_tables',
            ])
            ->hasCommands([
                MakePointCommand::class,
                MakeBadgeCommand::class,
            ]);
    }

    public function packageBooted(): void
    {
        Event::listen(ReputationChanged::class, SyncBadges::class);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton('badges', fn () => cache()->rememberForever('gamify.badges.all', fn () => $this->getBadges()->map(fn ($badge) => new $badge)));
    }

    /**
     * Get all the badge inside app/Gamify/Badges folder
     *
     * @return Collection<int, class-string>
     */
    protected function getBadges(): Collection
    {
        $badgeRootNamespace = config(
            'gamify.badge_namespace',
            $this->app->getNamespace().'Gamify\Badges'
        );

        $badges = [];

        foreach (glob(app_path('/Gamify/Badges/').'*.php') as $file) {
            if (is_file($file)) {
                $badges[] = app($badgeRootNamespace.'\\'.pathinfo($file, PATHINFO_FILENAME));
            }
        }

        return collect($badges);
    }
}
