<?php

declare(strict_types=1);

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <x-container class="flex min-h-full items-center justify-center py-16 sm:pt-24">
        <div class="w-full max-w-md space-y-8">
            <div>
                <x-validation-errors />

                <h2 class="text-center font-heading text-3xl font-extrabold text-gray-900 dark:text-white">
                    {{ __('pages/auth.login.title') }}
                </h2>
            </div>
            <form class="space-y-6" wire:submit="login">
                @csrf
                <div class="space-y-4">
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            id="email-address"
                            name="email"
                            autocomplete="email"
                            required="true"
                            wire:model="form.email"
                            aria-label="{{ __('validation.attributes.email') }}"
                            :placeholder="__('validation.attributes.email')"
                        />
                    </x-filament::input.wrapper>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="password"
                            id="password"
                            name="password"
                            required="true"
                            wire:model="form.password" 
                            aria-label="{{ __('validation.attributes.password') }}"
                            :placeholder="__('validation.attributes.password')"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <label class="inline-flex items-center gap-2 cursor-pointer text-sm text-gray-500 dark:text-gray-400">
                            <x-filament::input.checkbox id="remember_me" name="remember_me" />
                            {{ __('pages/auth.login.remember_me') }}
                        </label>
                    </div>

                    <div class="text-sm">
                        <x-link
                            :href="route('password.request')"
                            class="font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white"
                        >
                            {{ __('pages/auth.login.forgot_password') }}
                        </x-link>
                    </div>
                </div>

                <div>
                    <x-buttons.primary type="submit" class="group relative w-full">
                        <span class="absolute pointer-events-none inset-y-0 left-0 flex items-center pl-3">
                            <x-untitledui-lock class="size-5 text-green-500 group-hover:text-green-600" aria-hidden="true" />
                        </span>
                        {{ __('pages/auth.login.submit') }}
                    </x-buttons.primary>
                </div>
            </form>

            @include('partials._socials-link')
        </div>
    </x-container>

    <x-join-sponsors :title="__('global.sponsor_thanks')" />
</div>
