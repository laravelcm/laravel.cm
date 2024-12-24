<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property Form $form
 * @property User $user
 */
final class Preferences extends Component implements HasForms
{
    use InteractsWithForms;

    public string $theme = 'light';

    public ?array $data = [];

    #[Computed]
    public function user(): User
    {
        return Auth::user(); // @phpstan-ignore-line
    }

    public function mount(): void
    {
        $this->theme = get_current_theme();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('setting')
                    ->label(__('global.language'))
                    ->in(config('lcm.supported_locales'))
                    ->required()
                    ->options([
                        'fr' => __('global.french'),
                        'en' => __('global.english'),
                    ]),
            ])
            ->statePath('data')
            ->model(Auth::user());
    }

    public function save(): void
    {
        $this->validate();

        $this->user->settings(['locale' => data_get($this->form->getState(), 'setting')]);

        Notification::make()
            ->success()
            ->title(__('notifications.user.profile_updated'))
            ->duration(3500)
            ->send();

        $this->redirectRoute('settings', navigate: true);
    }

    public function changeTheme(string $value): void
    {
        $this->user->settings(['theme' => $value]);

        $this->redirectRoute('settings');
    }

    public function render(): View
    {
        return view('livewire.components.user.preferences');
    }
}
