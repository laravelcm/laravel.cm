<button
    type="button"
    @click="$dispatch('toggle-spotlight')"
    class="inline-flex items-center gap-4 relative rounded-lg ring-1 ring-gray-200 bg-white p-1.5 text-sm leading-5 text-gray-400 dark:text-gray-500 dark:bg-gray-800 dark:ring-white/20 lg:py-2 lg:px-3"
>
    <span class="sr-only">{{ __('global.search') }}</span>
    <div class="lg:hidden">
        <x-untitledui-search-sm class="size-5" aria-hidden="true" />
    </div>
    <div class="hidden items-center pr-7 lg:flex">
        {{ __('global.search_placeholder') }}
        <div class="pointer-events-none absolute inset-y-0 right-0 flex p-1.5">
            <kbd class="inline-flex items-center rounded border border-gray-200 p-1 text-sm font-medium text-gray-400 dark:text-gray-500 dark:border-gray-700">
                ⌘K
            </kbd>
        </div>
    </div>
</button>
