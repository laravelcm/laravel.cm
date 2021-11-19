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
use App\View\Composers\TopContributorsComposer;
use App\View\Composers\TopMembersComposer;
use Illuminate\Database\Eloquent\Relations\Relation;
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
        date_default_timezone_set('Africa/Douala');

        $this->bootMacros();
        $this->bootViewsComposer();
        $this->bootEloquentMorphs();

        ReplyResource::withoutWrapping();
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

    public function bootMacros()
    {
        Str::macro('readDuration', function (...$text) {
            $totalWords = str_word_count(implode(' ', $text));
            $minutesToRead = round($totalWords / 200);

            return (int) max(1, $minutesToRead);
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

    public function bootEloquentMorphs()
    {
        Relation::morphMap([
            'article' => Article::class,
            'discussion' => Discussion::class,
            'thread' => Thread::class,
            'reply' => Reply::class,
            'user' => User::class,
        ]);
    }
}
