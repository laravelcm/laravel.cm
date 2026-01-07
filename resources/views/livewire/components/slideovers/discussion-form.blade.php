<x-form-slider-over
    :title="$discussion->id ? $discussion->title : __('pages/discussion.new_discussion')"
    action="save"
>
    <div class="space-y-6">
        <div class="text-sm leading-6">
            <p class="text-gray-500 dark:text-gray-400">{{ __('global.rule_advise') }}</p>
            <x-link :href="route('rules')" class="inline-flex items-center gap-1.5 text-primary-500 hover:text-primary-600 hover:underline">
                {{ __('global.read_rules') }}
                <x-untitledui-arrow-block-right class="size-4" stroke-width="1.5" aria-hidden="true" />
            </x-link>
        </div>

        <div class="flex flex-col gap-6">
            <flux:input
                wire:model.live.debounce="form.title"
                :label="__('validation.attributes.title')"
                :placeholder="__('validation.attributes.title')"
                :description:trailing="__('pages/discussion.min_discussion_length')"
                :badge="__('validation.hints.required')"
                required
            />

            <flux:pillbox
                wire:model="form.tags"
                :placeholder="__('Select tags (1-3)')"
                :label="__('Tags')"
                :badge="__('validation.hints.required')"
                multiple
            >
                @foreach ($this->availableTags as $tag)
                    <flux:pillbox.option value="{{ $tag->id }}">{{ $tag->name }}</flux:pillbox.option>
                @endforeach
            </flux:pillbox>

            <div class="space-y-2">
                <flux:radio.group
                    wire:model="form.locale"
                    :label="__('validation.attributes.locale')"
                    variant="segmented"
                    size="sm"
                    class="w-48"
                >
                    <flux:radio value="fr" label="Français" />
                    <flux:radio value="en" label="English" />
                </flux:radio.group>
                <flux:description>{{ __('global.locale_help') }}</flux:description>
            </div>

            <div class="space-y-2">
                <flux:field>
                    <flux:label :badge="__('validation.hints.required')">
                        {{ __('validation.attributes.content') }}
                    </flux:label>

                    <livewire:markdown-editor
                        wire:model="form.body"
                        :placeholder="__('Démarrer votre discussion...')"
                        :rows="10"
                    />

                    <flux:error name="form.body" />
                </flux:field>

                <x-torchlight />
            </div>
        </div>
    </div>
</x-form-slider-over>
