<x-layouts.auth-card>
    <div class="w-full max-w-sm space-y-8">
        <div class="space-y-6">
            <flux:heading level="2" class="text-center font-heading" size="xl">
                {{ __('pages/auth.register.page_title') }}
            </flux:heading>

            @include('partials._socials-link')

            <flux:separator :text="__('pages/auth.continue')" />
        </div>

        <form wire:submit="register" class="flex flex-col gap-6">
            <flux:input
                :label="__('validation.attributes.name')"
                type="text"
                wire:model="form.name"
                placeholder="John Doe"
            />

            <flux:input
                :label="__('validation.attributes.email')"
                type="email"
                wire:model="form.email"
                placeholder="email@gmail.com"
            />

            <flux:input
                :label="__('validation.attributes.username')"
                :description="__('validation.hints.username')"
                type="text"
                wire:model="form.username"
                placeholder="john.doe"
            />

            <flux:input
                :label="__('validation.attributes.password')"
                :description:trailing="__('validation.hints.password')"
                type="password"
                placeholder="*******"
                wire:model="form.password"
            />

            <flux:button variant="primary" type="submit" class="w-full border-0">
                {{ __('pages/auth.register.submit') }}
            </flux:button>
        </form>

        <flux:subheading class="text-center">
            {{ __('pages/auth.register.already') }} <flux:link :href="route('login')" wire:navigate>{{ __('pages/auth.login.page_title') }}</flux:link>
        </flux:subheading>
    </div>

    <x-slot:content>
        <div>
            <flux:heading level="3" class="font-heading" size="xl">
                {{ __('pages/auth.register.join_us') }}
            </flux:heading>

            <flux:text class="mt-2 max-w-md" size="lg">
                {{ __('pages/auth.register.joins_description') }}
            </flux:text>

            <div class="mt-6">
                <flux:avatar.group>
                    @foreach ($this->users as $user)
                        <flux:avatar :src="$user->profile_photo_url" size="sm" alt="{{ $user->username }} avatar" circle />
                    @endforeach
                </flux:avatar.group>
            </div>
        </div>

        <dl class="relative mt-14 grid gap-px grid-cols-2 bg-white rounded-lg border border-dotted border-gray-300 dark:border-white/20 dark:bg-gray-800">
            <x-phosphor-plus
                class="absolute z-20 top-1/2 left-1/2 transform ml-px -translate-x-1/2 -translate-y-1/2 text-gray-400 size-4"
                aria-hidden="true"
            />
            <x-site-feature
                :title="__('pages/auth.register.advantages.podcast')"
                :description="__('pages/auth.register.advantages.podcast_description')"
                class="border-b border-dotted border-gray-300 dark:border-white/20"
            >
                <x-slot:icon>
                    <x-icon.podcast class="size-8" aria-hidden="true" />
                </x-slot:icon>
            </x-site-feature>

            <x-site-feature
                :title="__('pages/auth.register.advantages.discussion')"
                :description="__('pages/auth.register.advantages.discussion_description')"
                class="border-b border-l border-dotted border-gray-300 dark:border-white/20"
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
                class="border-l border-dotted border-gray-300 dark:border-white/20"
            >
                <x-slot:icon>
                    <x-icon.premium class="size-8" aria-hidden="true" />
                </x-slot:icon>
            </x-site-feature>
        </dl>
    </x-slot:content>
</x-layouts.auth-card>
