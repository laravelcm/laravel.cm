<x-filament::modal width="5xl" id="launch" :close-by-escaping="false">
    <x-slot name="trigger">
        <button type="button" class="inline-flex items-center text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white focus:outline-hidden">
            <span class="sr-only">{{ __('global.open_navigation') }}</span>
            <x-untitledui-plus class="size-5" aria-hidden="true" />
        </button>
    </x-slot>

    <div class="py-6 grid grid-cols-3 gap-4">
        @can('create', \App\Models\Thread::class)
            <button
                type="button"
                class="group relative inline-flex items-start p-4 rounded-xl hover:bg-gray-50 gap-4 text-left dark:hover:bg-gray-800 transition-all duration-200 ease-in-out"
                onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.thread-form' })"
            >
                <span class="inline-flex items-center justify-center size-10 shrink-0 rounded-full bg-primary-600 text-white">
                    <x-untitledui-help-circle class="size-5" aria-hidden="true" />
                </span>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">
                        {{ __('global.launch_modal.forum_action') }}
                    </p>
                    <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('global.launch_modal.forum_description') }}
                    </p>
                </div>
            </button>
        @endcan

        @can('create', \App\Models\Article::class)
            <button
                type="button"
                class="group relative inline-flex items-start p-4 rounded-xl hover:bg-gray-50 gap-4 text-left dark:hover:bg-gray-800 transition-all duration-200 ease-in-out"
                onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.article-form' })"
            >
                <span class="inline-flex items-center justify-center size-10 shrink-0 rounded-full bg-primary-600 text-white">
                    <x-untitledui-file-06 class="size-5" aria-hidden="true" />
                </span>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">
                        {{ __('global.launch_modal.article_action') }}
                    </p>
                    <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('global.launch_modal.article_description') }}
                    </p>
                </div>
            </button>
        @endcan

        @can('create', \App\Models\Discussion::class)
            <button
                type="button"
                class="group relative inline-flex items-start p-4 rounded-xl hover:bg-gray-50 gap-4 text-left dark:hover:bg-gray-800 transition-all duration-200 ease-in-out"
                onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.discussion-form' })"
            >
                <span class="inline-flex items-center justify-center size-10 shrink-0 rounded-full bg-primary-600 text-white">
                    <x-untitledui-message-text-square class="size-5" aria-hidden="true" />
                </span>
                <div>
                    <p class="font-medium text-gray-900 dark:text-white">
                        {{ __('global.launch_modal.discussion_action') }}
                    </p>
                    <p class="mt-1.5 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('global.launch_modal.discussion_description') }}
                    </p>
                </div>
            </button>
        @endcan
    </div>

    <x-slot name="footer">
        <x-buttons.default type="button" @click="close">
            {{ __('actions.cancel') }}
        </x-buttons.default>
    </x-slot>
</x-filament::modal>
