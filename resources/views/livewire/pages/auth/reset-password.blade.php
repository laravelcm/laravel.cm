<x-layouts.auth-card>
    <div class="w-full max-w-sm space-y-6">
        <flux:heading level="2" class="text-center font-heading" size="xl">
            {{ __('pages/auth.reset.page_title') }}
        </flux:heading>

        <form wire:submit="resetPassword" class="flex flex-col gap-6">
            <flux:input
                :label="__('validation.attributes.email')"
                :placeholder="__('validation.attributes.email')"
                type="email"
                wire:model="email"
                required
            />

            <flux:input
                :label="__('validation.attributes.password')"
                :description:trailing="__('validation.hints.password')"
                type="password"
                placeholder="*******"
                wire:model="password"
                required
            />

            <flux:input
                :label="__('validation.attributes.password_confirmation')"
                type="password"
                placeholder="*******"
                wire:model="password_confirmation"
                required
            />

            <div class="mt-4 flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="border-0">
                    {{ __('pages/auth.reset.submit') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.auth-card>
