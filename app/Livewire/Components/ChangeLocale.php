<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Pluralizer;
use Livewire\Attributes\Computed;
use Livewire\Component;

final class ChangeLocale extends Component
{
    public string $currentLocale;

    public function mount(): void
    {
        $this->currentLocale = app()->getLocale();
    }

    public function changeLocale(): void
    {
        $locale = $this->currentLocale === 'fr' ? 'en' : 'fr';

        if (Auth::check()) {
            Auth::user()?->settings(['locale' => $locale]);
        }

        $this->currentLocale = $locale;
        app()->setLocale($locale);
        session()->put('locale_lang', $locale);

        Pluralizer::useLanguage($this->currentLocale === 'fr' ? 'french' : 'english');

        $this->redirectRoute('home', navigate: true);
    }

    #[Computed]
    public function locale(): string
    {
        return $this->currentLocale === 'fr' ? 'English' : 'Français';
    }

    public function render(): View
    {
        return view('livewire.components.change-locale');
    }
}
