<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Validation\Rules\Password;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $username = '';
    public string $password = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::min(8)
            ->uncompromised()
            ->numbers()
            ->mixedCase()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(User::create($validated)));

        session()->flash('status', __('pages/auth.register.email_verification_status'));
    }
}; ?>
<div>
    <x-container class="py-12 sm:py-16 lg:pt-20">
        <div class="lg:grid lg:gap-12 lg:grid-cols-2">
            <div class="hidden items-center justify-center lg:flex">
                <div>
                    <h3 class="text-lg font-semibold leading-6 text-gray-700 dark:text-gray-300">
                        {{ __('pages/auth.register.advantages.heading') }}
                    </h3>
                    <dl class="mt-10 grid gap-6 grid-cols-2">
                        <x-site-feature
                            :title="__('pages/auth.register.advantages.podcast')"
                            :description="__('pages/auth.register.advantages.podcast_description')"
                        >
                            <x-slot:icon>
                                <x-icon.podcast class="size-8" aria-hidden="true" />
                            </x-slot:icon>
                        </x-site-feature>

                        <x-site-feature
                            :title="__('pages/auth.register.advantages.discussion')"
                            :description="__('pages/auth.register.advantages.discussion_description')"
                        >
                            <x-slot:icon>
                                <x-icon.discussion class="size-8" aria-hidden="true" />
                            </x-slot:icon>
                        </x-site-feature>

                        <x-site-feature
                            :title="__('pages/auth.register.advantages.snippet')"
                            :description="__('pages/auth.register.advantages.snippet_description')"
                        >
                            <x-slot:icon>
                                <x-icon.code-snippet class="size-8" aria-hidden="true" />
                            </x-slot:icon>
                        </x-site-feature>

                        <x-site-feature
                            :title="__('pages/auth.register.advantages.premium')"
                            :description="__('pages/auth.register.advantages.premium_description')"
                        >
                            <x-slot:icon>
                                <x-icon.premium class="size-8" aria-hidden="true" />
                            </x-slot:icon>
                        </x-site-feature>
                    </dl>

                    <div class="mt-16 relative text-sm space-y-4 max-w-lg mx-auto">
                        <svg class="absolute left-0 top-0 size-7 -translate-x-8 -translate-y-2 rotate-12 transform text-green-600" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                        </svg>
                        <p class="relative text-gray-600 dark:text-gray-400">
                            {{ __('pages/auth.register.advantages.quote') }}
                        </p>
                        <p class="mt-2 text-gray-900 dark:text-white">
                            <span class="italic text-gray-400 dark:text-gray-500">"The Pragmatic Programmer"</span> {{ __('pages/auth.register.advantages.quote_authors') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-md space-y-8">
                <div class="space-y-3 text-center">
                    <h2 class="font-heading text-3xl font-extrabold text-gray-900 dark:text-white">
                        {{ __('pages/auth.register.join_us') }}
                    </h2>
                    <x-profile-users />
                    <p class="leading-6 text-gray-500 dark:text-gray-400">
                        {{ __('pages/auth.register.joins_description') }}
                    </p>
                </div>

                <div>
                    <x-status-message />
                    
                    <x-validation-errors />

                    <form wire:submit="register" class="space-y-6">
                        <div class="space-y-3">
                            <x-filament::input.wrapper>
                                <x-filament::input
                                    type="text"
                                    id="name"
                                    wire:model="name"
                                    required
                                    autocomplete="name"
                                    aria-label="{{ __('validation.attributes.name') }}"
                                    :placeholder="__('validation.attributes.name')"
                                />
                            </x-filament::input.wrapper>

                            <x-filament::input.wrapper>
                                <x-filament::input
                                    type="email"
                                    id="email"
                                    wire:model="email"
                                    required
                                    autocomplete="email"
                                    aria-label="{{ __('validation.attributes.email') }}"
                                    :placeholder="__('validation.attributes.email')"
                                />
                            </x-filament::input.wrapper>

                            <x-filament::input.wrapper>
                                <x-filament::input
                                    type="text"
                                    id="username"
                                    wire:model="username"
                                    required
                                    autocomplete="username"
                                    aria-label="{{ __('validation.attributes.username') }}"
                                    :placeholder="__('validation.attributes.username')"
                                />
                            </x-filament::input.wrapper>

                            <x-filament::input.wrapper>
                                <x-filament::input
                                    type="password"
                                    id="password"
                                    wire:model="password"
                                    required
                                    aria-label="{{ __('validation.attributes.password') }}"
                                    :placeholder="__('pages/auth.register.password_placeholder')"
                                />
                            </x-filament::input.wrapper>
                        </div>

                        <div>
                            <x-buttons.primary type="submit" class="group w-full relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <x-untitledui-lock class="size-5 text-green-500 group-hover:text-green-600" aria-hidden="true" />
                                </span>
                                {{ __('pages/auth.register.submit') }}
                            </x-buttons.primary>
                        </div>
                    </form>
                </div>

                @include('partials._socials-link')
            </div>
        </div>
    </x-container>

    <x-join-sponsors :title="__('global.sponsor_thanks')" />
</div>