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
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Facades\FilamentIcon;
use Filament\Tables;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
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
        $this->bootMacros();
        $this->bootViewsComposer();
        $this->bootEloquentMorphs();
        $this->bootFilament();
        $this->bootBindings();

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
        View::composer('partials._contributions', TopContributorsComposer::class);
        View::composer('partials._contributions', InactiveDiscussionsComposer::class);
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

    public function bootFilament(): void
    {
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

    public function bootBindings(): void
    {
        Route::bind(
            key: 'username',
            binder: fn (string $username): User => User::findByUsername($username)
        );
    }

    public function registerLocaleDate(): void
    {
        date_default_timezone_set('Africa/Douala');
        setlocale(LC_TIME, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');
        setlocale(LC_ALL, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');

        Carbon::setLocale('fr');
    }
}
