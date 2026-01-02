<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Account;

use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Livewire\Component;

final class Password extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var User $user */
        $user = auth()->user();

        $rules = [
            'password' => [
                'required',
                'string',
                'confirmed',
                PasswordRule::min(8)
                    ->mixedCase()
                    ->symbols()
                    ->letters()
                    ->numbers()
                    ->uncompromised(),
            ],
            'password_confirmation' => 'required|string',
        ];

        if ($user->hasPassword()) {
            $rules['current_password'] = 'required|string|current_password';
        }

        return $rules;
    }

    public function changePassword(): void
    {
        $this->validate();

        /** @var User $user */
        $user = auth()->user();

        $user->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset();

        Flux::toast(
            text: __('notifications.user.password_changed'),
            variant: 'success',
        );
    }

    public function render(): View
    {
        return view('livewire.pages.account.password')
            ->title(__('global.navigation.password'));
    }
}
