@props([
    'content' => null,
])

<div class="flex min-h-screen overflow-hidden">
    <div class="flex-1 flex justify-center items-center">
        <div class="p-1 bg-gray-100 dark:bg-gray-800 line-y">
            <div class="line-l"></div>
            <div class="line-r"></div>

            <div class="bg-white ring-1 ring-gray-200 dark:ring-white/10 dark:bg-line-black p-8 rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>

    <div class="relative flex-1 p-4 overflow-hidden max-lg:hidden">
        <img
            class="absolute h-32 z-20 right-20 top-32 -translate-y-1/2 md:translate-x-6 animate-cube"
            src="https://picperf.io/https://laravel-news.com/images/cube.svg"
            alt="Cube"
        />

        <div class="ring-1 rounded-xl ring-gray-200 bg-gray-100 p-1 size-full dark:bg-gray-800 dark:ring-white/20">
            <div class="relative bg-white dark:bg-line-black ring-1 ring-gray-200 dark:ring-white/10 rounded-lg text-gray-700 dark:text-white flex flex-col flex-1 size-full items-start justify-end p-10">
                @if ($content)
                    <div class="mb-14">
                        {{ $content }}
                    </div>
                @endif

                <div>
                    <x-link href="/" class="group flex items-center gap-3">
                        <x-brand class="h-12 w-auto text-gray-800 dark:text-white" aria-hidden="true" />
                    </x-link>

                    <p class="mt-6 italic text-lg">
                        {{ __('global.site_description') }}
                    </p>

                    <div class="mt-10 flex items-center gap-3">
                        <flux:avatar src="https://avatars.githubusercontent.com/u/14105989?v=4" circle />

                        <div class="flex flex-col justify-center">
                            <p class="text-lg font-medium">Arthur Monney</p>
                            <p class="text-gray-400 text-base/5">Créateur de Laravel Cameroun</p>
                        </div>
                    </div>

                    <div class="mt-10 flex items-center gap-6">
                        <x-link :href="route('terms')" class="text-sm text-gray-700 dark:text-gray-300 dark:hover:text-white hover:text-gray-900 hover:underline hover:decoration-dotted">
                            {{ __('global.navigation.terms') }}
                        </x-link>
                        <x-link :href="route('privacy')" class="text-sm text-gray-700 dark:text-gray-300 dark:hover:text-white hover:text-gray-900 hover:underline hover:decoration-dotted">
                            {{ __('global.navigation.privacy') }}
                        </x-link>
                        <x-link :href="route('rules')" class="text-sm text-gray-700 dark:text-gray-300 dark:hover:text-white hover:text-gray-900 hover:underline hover:decoration-dotted">
                            {{ __('global.navigation.rules') }}
                        </x-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
