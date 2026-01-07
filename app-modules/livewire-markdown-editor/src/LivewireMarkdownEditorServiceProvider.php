<?php

declare(strict_types=1);

namespace Mckenziearts\LivewireMarkdownEditor;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Mckenziearts\LivewireMarkdownEditor\Livewire\MarkdownEditor;

final class LivewireMarkdownEditorServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'livewire-markdown-editor');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'livewire-markdown-editor');

        Livewire::component('markdown-editor', MarkdownEditor::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/livewire-markdown-editor.php' => config_path('livewire-markdown-editor.php'),
            ], 'livewire-markdown-editor-config');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/markdown-editor'),
            ], 'livewire-markdown-editor-views');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/livewire-markdown-editor.php', 'livewire-markdown-editor');
    }
}
