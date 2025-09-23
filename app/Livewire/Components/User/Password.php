<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Livewire\Component;

/**
 * @property \Filament\Schemas\Schema $form
 */
final class Password extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('current_password')
                    ->label(__('validation.attributes.current_password'))
                    ->password()
                    ->currentPassword()
                    ->required()
                    ->visible(fn (): bool => Auth::user()?->hasPassword() ?? false),
                TextInput::make('password')
                    ->label(__('validation.attributes.password'))
                    ->helperText(__('pages/account.settings.password_helpText'))
                    ->password()
                    ->revealable()
                    ->required()
                    ->rules(fn (): array => [
                        RulesPassword::min(8)
                            ->mixedCase()
                            ->symbols()
                            ->letters()
                            ->numbers()
                            ->uncompromised(),
                    ])
                    ->confirmed(),
                TextInput::make('password_confirmation')
                    ->label(__('validation.attributes.password_confirmation'))
                    ->password()
                    ->revealable()
                    ->required(),
            ])
            ->statePath('data')
            ->model(Auth::user());
    }

    public function changePassword(): void
    {
        $this->validate();

        // @phpstan-ignore-next-line
        Auth::user()->update([
            'password' => Hash::make(
                value: data_get($this->form->getState(), 'password')
            ),
        ]);

        Notification::make()
            ->success()
            ->title(__('notifications.user.password_changed'))
            ->duration(3500)
            ->send();
    }

    public function render(): View
    {
        return view('livewire.components.user.password');
    }
}
