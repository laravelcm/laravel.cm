<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Livewire\Component;

/**
 * @property Form $form
 */
final class Password extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('current_password')
                    ->label(__('validation.attributes.current_password'))
                    ->password()
                    ->currentPassword()
                    ->required()
                    ->visible(fn (): bool => Auth::user()?->hasPassword()), // @phpstan-ignore-line
                Forms\Components\TextInput::make('password')
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
                Forms\Components\TextInput::make('password_confirmation')
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
