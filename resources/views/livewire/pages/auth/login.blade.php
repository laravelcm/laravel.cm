<x-layouts.auth-card>
    <div class="w-full max-w-sm space-y-8">
        <div class="space-y-6">
            <flux:heading level="2" class="text-center font-heading" size="xl">
                {{ __('pages/auth.login.title') }}
            </flux:heading>

            @include('partials._socials-link')

            <flux:separator :text="__('pages/auth.continue')" />
        </div>

        <form wire:submit="login" class="flex flex-col gap-6">
            <flux:input
                :label="__('validation.attributes.email')"
                type="email"
                wire:model="form.email"
                placeholder="email@gmail.com"
            />

            <flux:field>
                <div class="mb-3 flex justify-between">
                    <flux:label>{{ __('validation.attributes.password') }}</flux:label>

                    <flux:link :href="route('password.request')" variant="subtle" class="text-sm" wire:navigate>
                        {{ __('pages/auth.login.forgot_password') }}
                    </flux:link>
                </div>

                <flux:input type="password" placeholder="*******" wire:model="form.password" />
            </flux:field>

            <flux:checkbox :label="__('pages/auth.login.remember_me')" wire:model="form.remember" />

            <flux:button variant="primary" type="submit" class="w-full border-0">
                {{ __('pages/auth.login.submit') }}
            </flux:button>
        </form>

        <flux:subheading class="text-center">
            {{ __('pages/auth.login.first') }} <flux:link :href="route('register')" wire:navigate>{{ __('pages/auth.register.page_title') }}</flux:link>
        </flux:subheading>
    </div>
</x-layouts.auth-card>
