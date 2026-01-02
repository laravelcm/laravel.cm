<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Account;

use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Preferences extends Component
{
    public string $theme = '';

    public string $locale = '';

    public function mount(): void
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var string $appLocale */
        $appLocale = config('app.locale') ?: 'fr';

        /** @var string $theme */
        $theme = $user->setting('theme', 'light');

        /** @var string $locale */
        $locale = $user->setting('locale', $appLocale);

        $this->theme = $theme;
        $this->locale = $locale;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'theme' => ['required', 'string', 'in:light,dark,system'],
            'locale' => ['required', 'string', 'in:fr,en'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        /** @var User $user */
        $user = auth()->user();

        $user->settings([
            'theme' => $this->theme,
            'locale' => $this->locale,
        ]);

        $this->dispatch('theme-changed', $this->theme);

        Flux::toast(
            text: __('notifications.user.profile_updated'),
            variant: 'success',
        );
    }

    public function render(): View
    {
        return view('livewire.pages.account.preferences')
            ->title(__('global.navigation.preferences'));
    }
}
