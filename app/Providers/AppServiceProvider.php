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
use App\View\Composers\ProfileUsersComposer;
use App\View\Composers\TopContributorsComposer;
use Carbon\Carbon;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use SocialiteProviders\Discord\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;

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
        $this->configureCustomSocialProvider();
    }

    public function registerBladeDirective(): void
    {
        Blade::directive('title', fn ($expression) => "<?php \$title = {$expression} ?>");
        Blade::directive('shareImage', fn ($expression) => "<?php \$shareImage = {$expression} ?>");
        Blade::directive('canonical', fn ($expression) => "<?php \$canonical = {$expression} ?>");
    }

    public function configureMacros(): void
    {
        Str::macro('readDuration', function (...$text) {
            $totalWords = str_word_count(implode(' ', $text));
            $minutesToRead = round($totalWords / 200);

            return (int) max(1, $minutesToRead);
        });
    }

    public function bootViewsComposer(): void
    {
        View::composer('partials._contributions', TopContributorsComposer::class);
        View::composer('partials._contributions', InactiveDiscussionsComposer::class);
        View::composer('components.profile-users', ProfileUsersComposer::class);
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
        FilamentColor::register([
            'primary' => Color::Emerald,
            'danger' => Color::Red,
            'info' => Color::Blue,
            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);

        FilamentIcon::register([
            'panels::pages.dashboard.navigation-item' => 'untitledui-home-line',
            'actions::delete-action' => 'untitledui-trash-03',
            'actions::edit-action' => 'untitledui-edit-03',
        ]);

        Tables\Actions\CreateAction::configureUsing(
            fn (Tables\Actions\Action $action) => $action->iconButton()
                ->modalWidth(MaxWidth::ExtraLarge)
                ->slideOver()
        );

        Tables\Actions\EditAction::configureUsing(
            fn (Tables\Actions\Action $action) => $action->iconButton()
                ->modalWidth(MaxWidth::ExtraLarge)
                ->slideOver()
        );

        Tables\Actions\DeleteAction::configureUsing(fn (Tables\Actions\Action $action) => $action->icon('untitledui-trash-03'));
    }

    protected function registerLocaleDate(): void
    {
        date_default_timezone_set('Africa/Douala');
        setlocale(LC_TIME, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');
        setlocale(LC_ALL, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');

        Carbon::setLocale('fr');
    }

    protected function configureSeo(): void
    {
        // @phpstan-ignore-next-line
        seo()
            ->title(
                default: __('pages/home.title'),
                modify: fn (string $title) => $title.' | '.__('global.site_name')
            )
            ->description(default: __('global.site_description'))
            ->image(default: fn () => asset('images/socialcard.png'))
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
        if (! $this->app->isLocal()) {
            URL::forceScheme('https');
        }
    }

    protected function configureCustomSocialProvider(): void
    {
        Event::listen(function (SocialiteWasCalled $event): void {
            $event->extendSocialite('discord', Provider::class);
        });
    }
}
