<div>
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200 dark:border-white/20"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="bg-gray-50 px-2 text-gray-500 dark:text-gray-400 dark:bg-gray-900">
                {{ __('pages/auth.continue') }}
            </span>
        </div>
    </div>

    <div class="mt-6">
        <div>
            <a href="{{ route('social.auth', ['provider' => 'github']) }}" class="w-full gap-2 inline-flex justify-center py-2 px-4 bg-white border-0 ring-1 ring-gray-200 dark:ring-white/20 rounded-lg shadow-xs text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 hover:bg-white/50 dark:hover:bg-white/10 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-500 dark:bg-gray-800 dark:focus:ring-offset-gray-900">
                <span class="sr-only">{{ __('pages/auth.continue_with', ['social' => 'Github']) }}</span>
                <x-icon.github class="size-5" aria-hidden="true" />
                Github
            </a>
        </div>
    </div>
</div>
