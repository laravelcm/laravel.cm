<div class="py-8">
    <div>
        <p class="font-medium text-center text-gray-900 dark:text-white lg:text-lg">
            {{ __('pages/sponsoring.current_support') }}
        </p>
        <div class="mt-6 flex items-center justify-center flex-wrap gap-1 mx-auto max-w-3xl">
            @foreach ($this->sponsors as $sponsor)
                <x-sponsor-profile :$sponsor />
            @endforeach
        </div>
        <div class="mt-10 flex items-center justify-center gap-4">
            <flux:modal.trigger name="sponsoring">
                <flux:button variant="primary" class="border-0">
                    {{ __('pages/sponsoring.sponsor') }}
                </flux:button>
            </flux:modal.trigger>
            <flux:button href="https://github.com/sponsors/mckenziearts">
                <x-slot name="icon">
                    <x-icon.github class="size-5" aria-hidden="true" />
                </x-slot>
                {{ __('pages/sponsoring.sponsor_github') }}
            </flux:button>
        </div>
    </div>

    <!-- Sponsoring Modal -->
    <flux:modal name="sponsoring" class="w-full sm:max-w-2xl">
        <div class="absolute inset-x-0 bottom-0 h-1/3 z-0">
            <x-grid-background class="pattern-mask text-gray-300/50 dark:text-white/10" aria-hidden="true" />
        </div>
        <div class="space-y-6 relative">
            <div>
                <flux:heading size="lg">{{ __('pages/sponsoring.title') }}</flux:heading>
            </div>
            <form wire:submit="submit">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-x-6">
                    <flux:input
                        :label="__('validation.attributes.name')"
                        wire:model="form.name"
                        placeholder="John Doe"
                    />
                    <flux:input
                        :label="__('validation.attributes.email')"
                        type="email"
                        wire:model="form.email"
                        placeholder="email@gmail.com"
                    />
                    <flux:radio.group
                        wire:model="form.profile"
                        variant="segmented"
                        :label="__('pages/sponsoring.sponsor_form.profile')"
                    >
                        <flux:radio value="developer">
                            <x-slot name="icon">
                                <x-phosphor-dev-to-logo-duotone class="size-5" aria-hidden="true" />
                            </x-slot>
                            {{ __('validation.attributes.freelance') }}
                        </flux:radio>
                        <flux:radio value="company">
                            <x-slot name="icon">
                                <x-phosphor-buildings-duotone class="size-5" aria-hidden="true" />
                            </x-slot>
                            {{ __('validation.attributes.company') }}
                        </flux:radio>
                    </flux:radio.group>
                    <flux:input
                        :label="__('global.website')"
                        wire:model="form.website"
                    >
                        <x-slot name="icon">
                            <x-heroicon-m-globe-alt class="size-5" aria-hidden="true" />
                        </x-slot>
                    </flux:input>
                    <flux:field>
                        <flux:label>{{ __('validation.attributes.amount') }}</flux:label>
                        <flux:input.group>
                            <flux:select wire:model="form.currency" class="max-w-fit">
                                <flux:select.option value="xaf">XAF</flux:select.option>
                                <flux:select.option value="eur">EUR</flux:select.option>
                                <flux:select.option value="usd">USD</flux:select.option>
                            </flux:select>

                            <flux:input wire:model="form.amount" />
                        </flux:input.group>

                        <flux:error name="form.amount" />
                    </flux:field>
                </div>
                <div class="flex gap-4">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button>{{ __('actions.cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary" class="border-0">
                        {{ __('pages/sponsoring.sponsor') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
