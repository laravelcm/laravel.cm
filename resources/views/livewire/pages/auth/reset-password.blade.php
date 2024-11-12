<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRules;

new class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', PasswordRules::min(8)
            ->uncompromised()
            ->numbers()
            ->mixedCase()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    <div class="flex min-h-full items-center justify-center py-16 sm:py-24">
        <div class="w-full max-w-md">

            <x-status-message class="mb-5" />

            <x-validation-errors class="mb-5"/>

            <h2 class="text-center font-heading text-3xl font-bold text-gray-900 sm:text-left">
                {{ __('pages/auth.reset.page_title') }}
            </h2>

            <form wire:submit="resetPassword" class="mt-8 space-y-6">

                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            id="email-address"
                            name="email"
                            wire:model="email"
                            autocomplete="email"
                            required="true"
                            aria-label="{{ __('validation.attributes.email') }}"
                            :placeholder="__('validation.attributes.email')"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="password"
                            id="password"
                            name="password"
                            wire:model="password"
                            required="true"
                            aria-label="{{ __('validation.attributes.password') }}"
                            :placeholder="__('validation.attributes.password')"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            wire:model="password_confirmation"
                            required="true"
                            aria-label="{{ __('validation.attributes.password_confirmation') }}"
                            :placeholder="__('validation.attributes.password_confirmation')"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <x-buttons.submit>
                        {{ __('pages/auth.reset.submit') }}
                    </x-buttons.submit>
                </div>
            </form>
        </div>
    </div>

    <x-join-sponsors :title="__('global.sponsor_thanks')" />
</div>
