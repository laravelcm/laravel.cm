<x-app-layout>
    <x-container>
        <div class="mx-auto max-w-xl py-16 sm:py-24">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-wide text-primary-600">
                    {{ __('global.error_title') }}
                    @yield('code')
                </p>
                <h1 class="font-heading mt-2 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl dark:text-white">
                    @yield('message')
                </h1>
                <p class="mt-2 text-lg text-gray-500 dark:text-gray-400">
                    {{ __('global.error_description') }}
                </p>
            </div>
            <div class="mt-12">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                    {{ __('global.popular_pages') }}
                </h2>
                <ul role="list" class="mt-4 divide-y divide-gray-200 dark:divide-white/20 border-b border-t border-gray-200 dark:border-white/20">
                    <li class="relative flex items-start space-x-4 py-6">
                        <div class="shrink-0">
                            <span class="flex size-12 items-center justify-center rounded-lg bg-primary-50 ring-1 ring-primary-300">
                                <x-heroicon-o-book-open class="size-6 text-primary-700" aria-hidden="true" />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-medium text-gray-900 dark:text-white">
                                <span class="rounded-lg focus-within:ring-2 focus-within:ring-primary-500 focus-within:ring-offset-2">
                                    <x-link :href="route('forum.index')" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ __('global.navigation.forum') }}
                                    </x-link>
                                </span>
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400">
                                {{ __('global.forum_description') }}
                            </p>
                        </div>
                        <div class="shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                        </div>
                    </li>

                    <li class="relative flex items-start space-x-4 py-6">
                        <div class="shrink-0">
                            <span class="flex size-12 items-center justify-center rounded-lg bg-primary-50 ring-1 ring-primary-300">
                                <x-heroicon-o-rss class="size-6 text-primary-700" aria-hidden="true" />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-medium text-gray-900 dark:text-white">
                                <span class="rounded-lg focus-within:ring-2 focus-within:ring-primary-500 focus-within:ring-offset-2">
                                    <x-link :href="route('articles')" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ __('global.navigation.articles') }}
                                    </x-link>
                                </span>
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400">
                                {{ __('global.articles_description') }}
                            </p>
                        </div>
                        <div class="shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                        </div>
                    </li>

                    <li class="relative flex items-start space-x-4 py-6">
                        <div class="shrink-0">
                            <span class="flex size-12 items-center justify-center rounded-lg bg-primary-50 ring-1 ring-primary-300">
                                <x-untitledui-bookmark class="size-6 text-primary-700" aria-hidden="true" />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-medium text-gray-900 dark:text-white">
                                <span class="rounded-sm focus-within:ring-2 focus-within:ring-primary-500 focus-within:ring-offset-2">
                                    <x-link :href="route('rules')" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ __('global.navigation.rules') }}
                                    </x-link>
                                </span>
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400">
                                {{ __('global.rules_description') }}
                            </p>
                        </div>
                        <div class="shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                        </div>
                    </li>

                    <li class="relative items-start space-x-4 py-6 hidden">
                        <div class="shrink-0">
                            <span class="flex size-12 items-center justify-center rounded-lg bg-primary-50 ring-1 ring-primary-300">
                                <x-heroicon-o-microphone class="size-6 text-primary-700" aria-hidden="true" />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-medium text-gray-900 dark:text-white">
                                <span class="rounded-lg focus-within:ring-2 focus-within:ring-primary-500 focus-within:ring-offset-2">
                                    <x-link href="#" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ __('global.navigation.podcasts') }}
                                    </x-link>
                                </span>
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400">
                                {{ __('global.podcasts_description') }}
                            </p>
                        </div>
                        <div class="shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                        </div>
                    </li>
                </ul>
                <div class="mt-8">
                    <x-link :href="route('home')" class="font-medium text-primary-600 hover:text-primary-500">
                        {{ __('global.back_home') }}
                        <span aria-hidden="true">&rarr;</span>
                    </x-link>
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout>
