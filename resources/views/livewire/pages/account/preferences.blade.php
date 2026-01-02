<x-layouts.account>
    <form wire:submit="save">
        <div class="space-y-10">
            <div>
                <flux:heading size="lg">{{ __('pages/account.settings.preferences_title') }}</flux:heading>
                <flux:subheading class="mt-1">
                    {{ __('pages/account.settings.preferences_description') }}
                </flux:subheading>
            </div>

            <div class="line-y">
                <div class="bg-dotted p-2">
                    <div class="grid gap-6 rounded-lg ring-1 ring-gray-200 dark:ring-white/10 bg-white dark:bg-line-black p-6">
                        <flux:field>
                            <flux:label>{{ __('Theme') }}</flux:label>

                            <div class="max-w-xs">
                                <flux:radio.group
                                    wire:model="theme"
                                    variant="segmented"
                                    x-data
                                    x-init="$watch('$wire.theme', value => $flux.appearance = value)"
                                >
                                    <flux:radio value="light" icon="sun">Light</flux:radio>
                                    <flux:radio value="dark" icon="moon">Dark</flux:radio>
                                    <flux:radio value="system" icon="computer-desktop">System</flux:radio>
                                </flux:radio.group>
                            </div>

                            <flux:error name="theme" />
                        </flux:field>

                        <flux:select
                            wire:model="locale"
                            :label="__('global.language')"
                            :badge="__('validation.hints.required')"
                            variant="listbox"
                            required
                        >
                            <flux:select.option value="fr">{{ __('global.french') }}</flux:select.option>
                            <flux:select.option value="en">{{ __('global.english') }}</flux:select.option>
                        </flux:select>
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
