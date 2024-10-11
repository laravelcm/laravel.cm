<div class="group w-full max-w-lg cursor-pointer lg:max-w-xs" @click="$dispatch('toggle-spotlight')">
    <label for="search" class="sr-only">{{ __('global.search') }}</label>
    <div class="relative">
        <div class="w-full rounded-lg border border-gray-200 bg-white py-2 pl-4 pr-12 text-sm leading-5 text-gray-400 group-hover:bg-white/50 dark:text-gray-500 dark:group-hover:bg-gray-800/10 dark:border-gray-700">
            {{ __('global.search_placeholder') }}
        </div>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex py-1.5 pr-2">
            <kbd class="inline-flex items-center rounded border border-gray-200 px-2 font-sans text-sm font-medium text-gray-400 dark:text-gray-500 dark:border-gray-700">
                ⌘K
            </kbd>
        </div>
    </div>
</div>
