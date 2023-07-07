<?php

declare(strict_types=1);

namespace App\Http\Livewire\User\Settings;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class Customization extends Component
{
    public string $theme = 'theme-light';

    public function mount(): void
    {
        $this->theme = Auth::user()->setting('theme', 'theme-light'); // @phpstan-ignore-line
    }

    public function updatedTheme(string $value): void
    {
        Auth::user()->settings(['theme' => $value]); // @phpstan-ignore-line

        $this->redirectRoute('user.customization');
    }

    public function render(): View
    {
        return view('livewire.user.settings.customization');
    }
}
