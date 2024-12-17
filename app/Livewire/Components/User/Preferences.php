<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property User $user
 */
final class Preferences extends Component
{
    public string $theme = 'light';

    #[Computed]
    public function user(): User
    {
        return Auth::user(); // @phpstan-ignore-line
    }

    public function mount(): void
    {
        $this->theme = get_current_theme();
    }

    public function updatedTheme(string $value): void
    {
        $this->user->settings(['theme' => $value]);

        $this->redirectRoute('settings', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.components.user.preferences');
    }
}
