<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Policies\NotificationPolicy;
use App\Spotlight\Commands;
use App\Spotlight\SpotlightManager;
use ArchTech\SEO\SEOManager;
use BladeUI\Icons\Factory;
use Filament\Actions;
use Filament\Support\Enums\Width;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->scoped(SpotlightManager::class);

        $this->registerBladeDirective();
        $this->registerLocaleDate();
        $this->registerIcon();
    }

    public function boot(): void
    {
        $this->configureMacros();
        $this->configureEloquent();
        $this->configureFilament();
        $this->configureSeo();
        $this->configureCommands();
        $this->configureUrl();
        $this->configurePolicies();
        $this->configureRateLimiting();
        $this->configureSpotlight();
    }

    public function registerBladeDirective(): void
    {
        Blade::directive('title', fn (string $expression): string => sprintf('<?php $title = %s ?>', $expression));
        Blade::directive('shareImage', fn (string $expression): string => sprintf('<?php $shareImage = %s ?>', $expression));
        Blade::directive('canonical', fn (string $expression): string => sprintf('<?php $canonical = %s ?>', $expression));
    }

    public function configureMacros(): void
    {
        Str::macro('readDuration', function (...$text): int {
            $totalWords = str_word_count(implode(' ', $text));
            $minutesToRead = round($totalWords / 200);

            return (int) max(1, $minutesToRead);
        });
    }

    protected function registerIcon(): void
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory): void {
            $factory->add('app', [
                'path' => resource_path('svg'),
                'prefix' => 'app',
            ]);
        });
    }

    protected function configureEloquent(): void
    {
        JsonResource::withoutWrapping();

        Relation::morphMap([
            'article' => Article::class,
            'discussion' => Discussion::class,
            'thread' => Thread::class,
            'reply' => Reply::class,
            'user' => User::class,
        ]);
    }

    protected function configureFilament(): void
    {
        Actions\CreateAction::configureUsing(
            fn (Actions\Action $action): Actions\Action => $action->iconButton()
                ->modalWidth(Width::ExtraLarge)
                ->slideOver()
        );

        Actions\EditAction::configureUsing(
            fn (Actions\Action $action): Actions\Action => $action->iconButton()
                ->modalWidth(Width::ExtraLarge)
                ->slideOver()
        );

        Actions\DeleteAction::configureUsing(
            fn (Actions\Action $action): Actions\Action => $action->iconButton()
        );
    }

    protected function registerLocaleDate(): void
    {
        date_default_timezone_set('Africa/Douala');
        setlocale(LC_TIME, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');
        setlocale(LC_ALL, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');

        Date::setLocale('fr');
    }

    protected function configureSeo(): void
    {
        /** @var SEOManager $seoManager */
        $seoManager = seo();

        $seoManager
            ->title(
                default: __('pages/home.title'),
                modify: fn (string $title): string => $title.' | '.__('global.site_name')
            )
            ->description(default: __('global.site_description'))
            ->image(default: fn (): string => asset('images/socialcard.png'))
            ->site('Laravel.cm')
            ->locale(app()->getLocale())
            ->twitterSite('@laravelcm');
    }

    protected function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction(),
        );
    }

    protected function configureUrl(): void
    {
        URL::forceScheme('https');
    }

    protected function configurePolicies(): void
    {
        Gate::policy(DatabaseNotification::class, NotificationPolicy::class);
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', fn (Request $request): Limit => $request->user()
                ? Limit::perMinute(60)->by($request->user()->id)
                : Limit::perMinute(15)->by($request->ip()));

        RateLimiter::for('auth', fn (Request $request): Limit => Limit::perMinute(5)->by($request->ip()));

        RateLimiter::for('content', fn (Request $request): Limit => Limit::perMinute(10)->by(
            $request->user()->id ?? $request->ip()
        ));
    }

    protected function configureSpotlight(): void
    {
        /** @var SpotlightManager $manager */
        $manager = $this->app->make(SpotlightManager::class);

        $manager->register(Commands\SearchArticles::class);
        $manager->register(Commands\SearchThreads::class);
        $manager->register(Commands\SearchDiscussions::class);
        $manager->register(Commands\SearchUsers::class);
        $manager->register(Commands\GoToArticles::class);
        $manager->register(Commands\GoToForum::class);
        $manager->register(Commands\GoToDiscussions::class);
        $manager->register(Commands\ToggleTheme::class);
        $manager->register(Commands\GoToHome::class);
        $manager->register(Commands\GoToAbout::class);
        $manager->register(Commands\GoToRules::class);
    }
}
