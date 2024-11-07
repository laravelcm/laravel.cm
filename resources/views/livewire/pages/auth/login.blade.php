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
{{-- <x-app-layout :title="__('pages/auth.login.page_title')"> --}}
    <div>
        <x-container class="flex min-h-full items-center justify-center py-16 sm:pt-24">
            <div class="w-full max-w-md space-y-8">
                <div>
                    <h2 class="text-center font-heading text-3xl font-extrabold text-gray-900 dark:text-white">
                        {{ __('pages/auth.login.title') }}
                    </h2>
                </div>
                <form class="space-y-6" wire:submit.prevent="login">
                    @csrf
                    <div class="space-y-4">
                        <!-- Email Input -->
                        <div class="space-y-1">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('validation.attributes.email') }}
                            </label>
                            <x-text-input 
                                type="email" 
                                id="email" 
                                wire:model="form.email" 
                                name="email" 
                                required 
                                placeholder="{{ __('validation.attributes.email') }}" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            />
                            @error('form.email') 
                                <span class="text-sm text-red-500">{{ $message }}</span> 
                            @enderror
                        </div>
                
                        <!-- Password Input -->
                        <div class="space-y-1">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('validation.attributes.password') }}
                            </label>
                            <x-text-input 
                                type="password" 
                                id="password" 
                                wire:model="form.password" 
                                name="password" 
                                required 
                                placeholder="{{ __('validation.attributes.password') }}" 
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            />
                            @error('form.password') 
                                <span class="text-sm text-red-500">{{ $message }}</span> 
                            @enderror
                        </div>
                    </div>
                
                    <div class="flex items-center justify-between">
                        <!-- Remember Me Checkbox -->
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="remember_me" 
                                wire:model="form.remember"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            />
                            <label for="remember_me" class="ml-2 block text-sm text-gray-500 dark:text-gray-400">
                                {{ __('pages/auth.login.remember_me') }}
                            </label>
                        </div>
                
                        <!-- Forgot Password Link -->
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                                {{ __('pages/auth.login.forgot_password') }}
                            </a>
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
    
{{-- </x-app-layout> --}}


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




