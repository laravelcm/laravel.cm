<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class Locale extends Component
{
    public string $selectedLang;

    public function mount(): void
    {
        $this->selectedLang = app()->getLocale();
    }

    public function changeLang(string $lang): RedirectResponse|Redirector
    {
        $user = Auth::user();
        if ($user) {
            $settings = $user->settings;
            $settings['default_lang'] = $lang;
            $user->settings = $settings;
            $user->save();
        }
        app()->setLocale($lang);

        return redirect()->to(url()->current());
    }

    public function render(): View
    {
        return view('livewire.components.locale');
    }
}
