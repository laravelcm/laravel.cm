<?php

declare(strict_types=1);

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-status-message class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>



{{-- <x-app-layout :title="__('pages/auth.login.page_title')">
    <x-container class="flex min-h-full items-center justify-center py-16 sm:pt-24">
        <div class="w-full max-w-md space-y-8">
            <div>
                <h2 class="text-center font-heading text-3xl font-extrabold text-gray-900 dark:text-white">
                    {{ __('pages/auth.login.title') }}
                </h2>
            </div>
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            id="email-address"
                            name="email"
                            autocomplete="email"
                            required="true"
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
</x-app-layout> --}}




