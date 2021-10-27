<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
}
