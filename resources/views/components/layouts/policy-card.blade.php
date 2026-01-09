<div class="section-gradient isolate">
    <x-container class="px-0 line-x py-24 lg:py-32  grid gap-12 lg:grid-cols-4">
        <div class="hidden lg:block">
            <x-sticky-content>
                <nav class="px-4 space-y-2">
                    @foreach (['terms', 'privacy', 'rules'] as $route)
                        <x-link
                            :href="route($route)"
                            @class([
                                'flex items-center gap-2 text-sm font-medium hover:underline hover:decoration-1 hover:decoration-dotted',
                                'text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' => ! request()->routeIs($route),
                                'text-primary-600 dark:text-primary-500' => request()->routeIs($route),
                            ])
                        >
                            {{ __("global.navigation.{$route}") }}
                        </x-link>
                    @endforeach
                </nav>
            </x-sticky-content>
        </div>
        <div class="px-4 lg:col-span-3 lg:border-x lg:border-line">
            {{ $slot }}
        </div>
    </x-container>
</div>
