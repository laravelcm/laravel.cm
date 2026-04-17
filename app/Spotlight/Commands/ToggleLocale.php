<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Livewire\Components\Spotlight;
use App\Spotlight\SpotlightCommand;
use Illuminate\Support\Facades\Auth;

final class ToggleLocale extends SpotlightCommand
{
    protected ?string $icon = 'heroicon-o-language';

    protected ?string $group = 'commands';

    protected array $synonyms = ['locale', 'language', 'langue', 'français', 'french', 'english', 'anglais'];

    public function getName(): string
    {
        return __('command-palette.commands.toggle_locale');
    }

    public function execute(Spotlight $spotlight): void
    {
        /** @var array<int, string> $supportedLocales */
        $supportedLocales = config('lcm.supported_locales', ['fr', 'en']);

        $currentLocale = app()->getLocale();
        $newLocale = $currentLocale === 'fr' ? 'en' : 'fr';

        if (! in_array($newLocale, $supportedLocales, true)) {
            return;
        }

        Auth::user()?->settings(['locale' => $newLocale]);
        session()->put('locale', $newLocale);

        $spotlight->redirect(safe_previous_url(), navigate: true);
    }
}
