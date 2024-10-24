<x-form-slider-over
    :title="$thread->id ? $thread->title : __('pages/forum.new_thread')"
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

        {{ $this->form }}
    </div>
</x-form-slider-over>
