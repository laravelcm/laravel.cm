<x-form-slider-over
    :title="$discussion->id ? $discussion->title : __('pages/discussion.new_discussion')"
    action="save"
>
    <div class="space-y-4">
        <div class="text-sm leading-6">
            <p class="text-gray-500 dark:text-gray-400">{{ __('global.rule_advise') }}</p>
            <x-link :href="route('rules')" class="inline-flex items-center gap-1.5 text-primary-500 hover:text-primary-600 hover:underline">
                {{ __('global.read_rules') }}
                <x-untitledui-arrow-block-right class="size-4" stroke-width="1.5" aria-hidden="true" />
            </x-link>
        </div>

        {{ $this->form }}

    </div>
</x-form-slider-over>
