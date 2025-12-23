<div class="py-16 lg:py-32 overflow-hidden section-gradient isolate">
    <x-container class="relative grid gap-12 lg:grid-cols-4">
        <div class="hidden lg:block">
            <nav class="space-y-3">
                <x-link
                    :href="route('terms')"
                    @class([
                        'flex items-center text-sm font-medium hover:underline hover:decoration-1 hover:decoration-dotted',
                        'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' => ! request()->routeIs('terms'),
                        'text-primary-600 dark:text-primary-500' => request()->routeIs('terms'),
                    ])
                >
                    {{ __('global.navigation.terms') }}
                </x-link>
                <x-link
                    :href="route('privacy')"
                    @class([
                        'flex items-center text-sm font-medium hover:underline hover:decoration-1 hover:decoration-dotted',
                        'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' => ! request()->routeIs('privacy'),
                        'text-primary-600 dark:text-primary-500' => request()->routeIs('privacy'),
                    ])
                >
                    {{ __('global.navigation.privacy') }}
                </x-link>
                <x-link
                    :href="route('rules')"
                    @class([
                        'flex items-center text-sm font-medium hover:underline hover:decoration-1 hover:decoration-dotted',
                        'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' => ! request()->routeIs('rules'),
                        'text-primary-600 dark:text-primary-500' => request()->routeIs('rules'),
                    ])
                >
                    {{ __('global.navigation.rules') }}
                </x-link>
            </nav>
        </div>
        <div class="lg:col-span-3 border-x border-line">
            {{ $slot }}
        </div>
    </x-container>
</div>
