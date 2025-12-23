<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use App\Models\User;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property Schema $form
 * @property User $user
 */
final class Preferences extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'theme' => $this->user->setting('theme', 'light'),
            'locale' => $this->user->setting('locale', config('app.locale')),
        ]);
    }

    #[Computed]
    public function user(): User
    {
        return Auth::user(); // @phpstan-ignore-line
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                ToggleButtons::make('theme')
                    ->label('Theme')
                    ->options([
                        'light' => 'Light',
                        'dark' => 'Dark',
                    ])
                    ->icons([
                        'light' => 'phosphor-sun-duotone',
                        'dark' => 'phosphor-moon-duotone',
                    ])
                    ->grouped(),
                Select::make('locale')
                    ->label(__('global.language'))
                    ->options([
                        'fr' => __('global.french'),
                        'en' => __('global.english'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $this->validate();

        $this->user->settings($this->form->getState());

        $this->dispatch('theme-changed', get_current_theme());

        Notification::make()
            ->success()
            ->title(__('notifications.user.profile_updated'))
            ->duration(3500)
            ->send();
    }

    public function render(): View
    {
        return view('livewire.components.user.preferences');
    }
}
