<?php

namespace App\Providers;

use App\Http\Resources\ReplyResource;
use App\Models\Article;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
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
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

class AppServiceProvider extends ServiceProvider
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
        $this->bootHealthCheck();
        $this->bootFilament();

        ReplyResource::withoutWrapping();
    }

    public function registerBladeDirective(): void
    {
        Blade::directive('title', function ($expression) {
            return "<?php \$title = $expression ?>";
        });

        Blade::directive('shareImage', function ($expression) {
            return "<?php \$shareImage = $expression ?>";
        });

        Blade::directive('canonical', function ($expression) {
            return "<?php \$canonical = $expression ?>";
        });
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

    public function bootHealthCheck(): void
    {
        Health::checks([
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            UsedDiskSpaceCheck::new(),
            DatabaseCheck::new(),
            CacheCheck::new(),
        ]);
    }

    public function bootFilament(): void
    {
        Filament::serving(function () {
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
