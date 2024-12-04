<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class ChangeLocale extends Component
{
    public string $selectedLang;

    public function mount(): void
    {
        $this->selectedLang = app()->getLocale();
    }

    public function changeLang(string $lang): void
    {
        $user = Auth::user();

        if ($user) {
            $settings = $user->settings;
            $settings['locale'] = $lang;
            $user->settings = $settings;
            $user->save();
        }

        app()->setLocale($lang);
        $this->dispatch('localeChanged');
    }

    public function render(): View
    {
        return view('livewire.components.change-locale');
    }
}
