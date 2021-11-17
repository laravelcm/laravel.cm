<?php

namespace App\Providers;

use App\View\Composers\ChannelsComposer;
use App\View\Composers\InactiveDiscussionsComposer;
use App\View\Composers\ModeratorsComposer;
use App\View\Composers\TopContributorsComposer;
use App\View\Composers\TopMembersComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBladeDirective();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Str::macro('readDuration', function (...$text) {
            $totalWords = str_word_count(implode(' ', $text));
            $minutesToRead = round($totalWords / 200);

            return (int) max(1, $minutesToRead);
        });

        $this->bootViewsComposer();
    }

    public function registerBladeDirective()
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

    public function bootViewsComposer()
    {
        View::composer('forum._channels', ChannelsComposer::class);
        View::composer('forum._top-members', TopMembersComposer::class);
        View::composer('forum._moderators', ModeratorsComposer::class);
        View::composer('discussions._contributions', TopContributorsComposer::class);
        View::composer('discussions._contributions', InactiveDiscussionsComposer::class);
    }
}
