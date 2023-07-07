<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Resources\ReplyResource;
use App\Models\Article;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\View\Composers\AuthUserComposer;
use App\View\Composers\ChannelsComposer;
use App\View\Composers\InactiveDiscussionsComposer;
use App\View\Composers\ModeratorsComposer;
use App\View\Composers\ProfileUsersComposer;
use App\View\Composers\TopContributorsComposer;
use App\View\Composers\TopMembersComposer;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerBladeDirective();
    }

    public function boot(): void
    {
        date_default_timezone_set('Africa/Douala');
        setlocale(LC_TIME, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');
        setlocale(LC_ALL, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');
        Carbon::setLocale('fr');

        $this->bootMacros();
        $this->bootViewsComposer();
        $this->bootEloquentMorphs();
        $this->bootFilament();

        ReplyResource::withoutWrapping();
    }

    public function registerBladeDirective(): void
    {
        Blade::directive('title', fn ($expression) => "<?php \$title = {$expression} ?>");
        Blade::directive('shareImage', fn ($expression) => "<?php \$shareImage = {$expression} ?>");
        Blade::directive('canonical', fn ($expression) => "<?php \$canonical = {$expression} ?>");
    }

    public function bootMacros(): void
    {
        Str::macro('readDuration', function (...$text) {
            $totalWords = str_word_count(implode(' ', $text));
            $minutesToRead = round($totalWords / 200);

            return (int) max(1, $minutesToRead);
        });
    }

    public function bootViewsComposer(): void
    {
        View::composer('forum._channels', ChannelsComposer::class);
        View::composer('forum._top-members', TopMembersComposer::class);
        View::composer('forum._moderators', ModeratorsComposer::class);
        View::composer('discussions._contributions', TopContributorsComposer::class);
        View::composer('discussions._contributions', InactiveDiscussionsComposer::class);
        View::composer('components.profile-users', ProfileUsersComposer::class);
        View::composer('*', AuthUserComposer::class);
    }

    public function bootEloquentMorphs(): void
    {
        Relation::morphMap([
            'article' => Article::class,
            'discussion' => Discussion::class,
            'thread' => Thread::class,
            'reply' => Reply::class,
            'user' => User::class,
        ]);
    }

    public function bootFilament(): void
    {
        Filament::serving(function (): void {
            Filament::registerTheme(
                mix('css/filament.css'),
            );
        });

        Filament::registerRenderHook(
            'body.start',
            fn (): string => Blade::render('@livewire(\'livewire-ui-modal\')'),
        );
    }
}
