<div class="space-y-4">
    <flux:button class="w-full">
        <x-slot name="icon">
            <x-icon.google class="size-5" aria-hidden="true" />
        </x-slot>

        {{ __('pages/auth.continue_with', ['social' => 'Google']) }}
    </flux:button>

    <flux:button class="w-full" :href="route('social.auth', ['provider' => 'github'])">
        <x-slot name="icon">
            <x-icon.github class="size-5" aria-hidden="true" />
        </x-slot>

        {{ __('pages/auth.continue_with', ['social' => 'Github']) }}
    </flux:button>
</div>
