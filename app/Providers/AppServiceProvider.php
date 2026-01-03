<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Policies\NotificationPolicy;
use ArchTech\SEO\SEOManager;
use Filament\Actions;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentIcon;
use Filament\View\PanelsIconAlias;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerBladeDirective();
        $this->registerLocaleDate();
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
        FilamentIcon::register([
            PanelsIconAlias::PAGES_DASHBOARD_NAVIGATION_ITEM => 'untitledui-home-line',
            Actions\View\ActionsIconAlias::DELETE_ACTION => 'untitledui-trash-03',
            Actions\View\ActionsIconAlias::DELETE_ACTION_GROUPED => 'untitledui-trash-03',
            Actions\View\ActionsIconAlias::DELETE_ACTION_MODAL => 'untitledui-trash-03',
            Actions\View\ActionsIconAlias::FORCE_DELETE_ACTION_MODAL => 'untitledui-trash-03',
            Actions\View\ActionsIconAlias::EDIT_ACTION => 'untitledui-edit-03',
            Actions\View\ActionsIconAlias::EDIT_ACTION_GROUPED => 'untitledui-edit-03',
        ]);

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
}
