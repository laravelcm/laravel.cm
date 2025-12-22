<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Resources\ReplyResource;
use App\Models\Article;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\View\Composers\InactiveDiscussionsComposer;
use App\View\Composers\TopContributorsComposer;
use ArchTech\SEO\SEOManager;
use Filament\Actions;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        $this->bootViewsComposer();
        $this->configureMacros();
        $this->configureEloquent();
        $this->configureFilament();
        $this->configureSeo();
        $this->configureCommands();
        $this->configureUrl();
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

    public function bootViewsComposer(): void
    {
        View::composer('partials._contributions', TopContributorsComposer::class);
        View::composer('partials._contributions', InactiveDiscussionsComposer::class);
    }

    protected function configureEloquent(): void
    {
        ReplyResource::withoutWrapping();

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
            'panels::pages.dashboard.navigation-item' => 'untitledui-home-line',
            'actions::delete-action' => 'untitledui-trash-03',
            'actions::edit-action' => 'untitledui-edit-03',
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
}
