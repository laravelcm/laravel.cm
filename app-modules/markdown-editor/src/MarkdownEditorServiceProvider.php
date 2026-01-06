<?php

declare(strict_types=1);

namespace Laravelcm\MarkdownEditor;

use Illuminate\Support\ServiceProvider;
use Laravelcm\MarkdownEditor\Livewire\MarkdownEditor;
use Livewire\Livewire;

final class MarkdownEditorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'markdown-editor');

        Livewire::component('markdown-editor', MarkdownEditor::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/markdown-editor.php' => config_path('markdown-editor.php'),
            ], 'markdown-editor-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/markdown-editor'),
            ], 'markdown-editor-views');

            $this->publishes([
                __DIR__.'/../resources/js' => resource_path('js/vendor/markdown-editor'),
            ], 'markdown-editor-assets');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/markdown-editor.php', 'markdown-editor');
    }
}
