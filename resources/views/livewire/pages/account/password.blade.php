<x-layouts.account>
    <form wire:submit="changePassword">
        <div class="space-y-10">
            <div>
                <flux:heading size="lg">{{ __('global.navigation.password') }}</flux:heading>
                <flux:subheading class="mt-1">
                    {{ __('pages/account.settings.password_description') }}
                </flux:subheading>
            </div>

            <div class="line-y">
                <div class="bg-dotted p-2">
                    <div class="grid gap-6 rounded-lg ring-1 ring-gray-200 dark:ring-white/10 bg-white dark:bg-line-black p-6">
                        @if (auth()->user()?->hasPassword())
                            <flux:input
                                wire:model="current_password"
                                :label="__('validation.attributes.current_password')"
                                :badge="__('validation.hints.required')"
                                type="password"
                                required
                            >
                                <x-slot name="icon">
                                    <x-untitledui-lock-keyhole-circle class="size-5" aria-hidden="true" />
                                </x-slot>
                            </flux:input>
                        @endif

                        <flux:field>
                            <flux:input
                                wire:model="password"
                                :label="__('validation.attributes.password')"
                                :badge="__('validation.hints.required')"
                                type="password"
                                required
                            >
                                <x-slot name="icon">
                                    <x-untitledui-lock-unlocked class="size-5" aria-hidden="true" />
                                </x-slot>
                            </flux:input>

                            <flux:description>
                                {{ __('pages/account.settings.password_helpText') }}
                            </flux:description>

                            <flux:error name="password" />
                        </flux:field>

                        <flux:input
                            wire:model="password_confirmation"
                            :label="__('validation.attributes.password_confirmation')"
                            :badge="__('validation.hints.required')"
                            type="password"
                            required
                        >
                            <x-slot name="icon">
                                <x-untitledui-lock-unlocked class="size-5" aria-hidden="true" />
                            </x-slot>
                        </flux:input>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-10">
            <flux:button type="submit" variant="primary" class="border-0">
                {{ __('actions.save') }}
            </flux:button>
        </div>
    </form>
</x-layouts.account>
