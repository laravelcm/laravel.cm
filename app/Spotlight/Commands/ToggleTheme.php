<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Livewire\Components\Spotlight;
use App\Spotlight\SpotlightCommand;
use Illuminate\Support\Facades\Auth;

final class ToggleTheme extends SpotlightCommand
{
    protected ?string $icon = 'heroicon-o-sun';

    protected ?string $group = 'commands';

    protected array $synonyms = ['theme', 'dark', 'light', 'sombre', 'clair', 'mode'];

    public function getName(): string
    {
        return __('command-palette.commands.toggle_theme');
    }

    public function execute(Spotlight $spotlight): void
    {
        $user = Auth::user();

        if ($user) {
            $currentTheme = $user->setting('theme', 'light');
            $newTheme = $currentTheme === 'dark' ? 'light' : 'dark';

            $user->fill(['settings' => array_merge($user->settings ?? [], ['theme' => $newTheme])]);
            $user->save();

            $spotlight->dispatch('theme-changed', $newTheme);
        } else {
            $spotlight->dispatch('theme-changed', 'toggle');
        }
    }

    public function getUrl(): string
    {
        return '';
    }
}
