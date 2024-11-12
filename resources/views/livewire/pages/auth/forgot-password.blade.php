<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>


<div>
    <div class="flex min-h-full items-center justify-center py-16 sm:py-24">
        <div class="w-full max-w-md">
            <div>
                <x-status-message class="mb-5" />

                <x-validation-errors class="mb-5"/>

                <h2 class="text-center font-heading text-3xl font-extrabold text-gray-900 dark:text-white sm:text-left">
                    {{ __('pages/auth.forgot.page_title') }}
                </h2>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('pages/auth.forgot.description') }}
                </div>
            </div>
                                
            <form class="mt-8" wire:submit="sendPasswordResetLink">

                <div class="block">
                    <x-filament-forms::field-wrapper.label for="email">
                        {{ __('validation.attributes.email') }}
                    </x-filament-forms::field-wrapper.label>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            id="email"
                            name="email"
                            wire:model="email"
                            autocomplete="email"
                            required="true"
                            :value="old('email')"
                            autofocus="true"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <x-buttons.submit class="relative w-full">
                        {{ __('pages/auth.forgot.title') }}
                    </x-buttons.submit>
                </div>
            </form>
        </div>
    </div>

    <x-join-sponsors :title="__('global.sponsor_thanks')" />
</div>
