<x-form-slider-over
    :title="$thread->id ? $thread->title : __('pages/forum.new_thread')"
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

        <div class="rounded-xl bg-sky-50 p-4 ring-1 ring-inset ring-sky-200 dark:bg-sky-800/20 dark:ring-sky-700">
            <div class="flex items-center gap-2">
                <x-untitledui-alert-circle class="size-5 text-sky-400" aria-hidden="true" />
                <h3 class="text-sm font-medium text-sky-800 dark:text-sky-400">
                    {{ __('pages/forum.info.title') }}
                </h3>
            </div>
            <p class="mt-1 text-sm text-sky-700 dark:text-sky-300">
                {{ __('pages/forum.info.description') }}
            </p>
        </div>

        <div class="flex flex-col gap-6">
            <flux:input
                wire:model.live.debounce="form.title"
                :label="__('validation.attributes.title')"
                :placeholder="__('validation.attributes.title')"
                :description:trailing="__('pages/forum.min_thread_length')"
                :badge="__('validation.hints.required')"
                required
            />

            <flux:pillbox
                wire:model="form.channels"
                :placeholder="__('Select channels (1-3)')"
                :label="__('Channels')"
                :badge="__('validation.hints.required')"
                multiple
            >
                @foreach ($this->availableChannels as $channel)
                    <flux:pillbox.option value="{{ $channel->id }}">{{ $channel->name }}</flux:pillbox.option>
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
                <x-markdown-editor
                    wire:model="form.body"
                    :label="__('validation.attributes.content')"
                    :badge="__('validation.hints.required')"
                    :toolbarItems="[
                        ['bold', 'italic'],
                        ['ul', 'ol'],
                        ['link'],
                        ['code', 'codeblock'],
                    ]"
                />

                <x-torchlight />
            </div>
        </div>
    </div>
</x-form-slider-over>
