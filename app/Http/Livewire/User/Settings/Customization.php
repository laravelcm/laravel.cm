<?php

namespace App\Http\Livewire\User\Settings;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Customization extends Component
{
    public string $theme = 'theme-light';

    public function mount()
    {
        $this->theme = Auth::user()->setting('theme', 'theme-light');
    }

    public function updatedTheme($value)
    {
        Auth::user()->settings(['theme' => $value]);

        $this->redirectRoute('user.customization');
    }

    public function render()
    {
        return view('livewire.user.settings.customization');
    }
}
