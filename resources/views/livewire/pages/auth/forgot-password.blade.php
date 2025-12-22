<x-layouts.auth-card>
    <div class="w-full max-w-sm space-y-8">
        <div>
            <flux:heading level="2" class="font-heading" size="xl">
                {{ __('pages/auth.forgot.page_title') }}
            </flux:heading>
            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                {{ __('pages/auth.forgot.description') }}
            </div>
        </div>

        <form wire:submit="sendPasswordResetLink">
            <flux:input
                :label="__('validation.attributes.email')"
                type="email"
                wire:model="email"
                autocomplete="email"
                placeholder="email@gmail.com"
                :value="old('email')"
                autofocus="true"
                required
            />

            <div class="mt-4 flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full border-0">
                    {{ __('pages/auth.forgot.title') }}
                </flux:button>
            </div>
        </form>

        <flux:link :href="route('login')" class="inline-flex text-sm" wire:navigate>
            {{ __('pages/auth.forgot.go_back') }} →
        </flux:link>
    </div>
</x-layouts.auth-card>
