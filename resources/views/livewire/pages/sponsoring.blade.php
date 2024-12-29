<x-container class="py-12">
    <div class="pb-12 lg:grid lg:grid-cols-10 lg:gap-20">
        <div class="space-y-4 lg:col-span-7">
            <!-- Success session flash -->
            <x-status-message />

            <!-- Error session flash -->
            <x-error-message />

            <div class="space-y-10">
                <h1 class="font-heading text-2xl font-bold text-gray-900 dark:text-white lg:text-4xl">
                    {{ __('pages/sponsoring.title') }}
                </h1>
                <div class="relative flex items-center space-x-5">
                    <div class="shrink-0">
                        <x-brand.icon class="block h-12 w-auto sm:h-14" aria-hidden="true" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="focus:outline-none">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('global.site_name') }}</p>
                            <div class="mt-2 flex items-center space-x-4">
                                <a href="https://x.com/laravelcd" class="text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-500">
                                    <span class="sr-only">Twitter</span>
                                    <x-icon.twitter class="size-5" aria-hidden="true" />
                                </a>

                                <a href="https://facebook.com/laravelcd" class="text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-500">
                                    <span class="sr-only">Facebook</span>
                                    <x-icon.facebook class="size-5" aria-hidden="true" />
                                </a>

                                <a href="https://www.linkedin.com/company/laravel-cameroun" class="text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-500">
                                    <span class="sr-only">LinkedIn</span>
                                    <x-icon.linkedin class="size-5" aria-hidden="true" />
                                </a>

                                <a href="https://github.com/laravelcd" class="text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-500">
                                    <span class="sr-only">Github</span>
                                    <x-icon.github class="size-5" aria-hidden="true" />
                                </a>

                                <a href="https://www.youtube.com/channel/UCbQPQ8q31uQmuKtyRnATLSw" class="text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-500">
                                    <span class="sr-only">YouTube</span>
                                    <x-icon.youtube class="size-5" aria-hidden="true" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="prose prose-green mx-auto overflow-x-hidden dark:prose-invert lg:max-w-4xl">
                    <p>{!! __('pages/sponsoring.paragraphes.one') !!}</p>
                    <p>{{ __('pages/sponsoring.paragraphes.two') }}</p>
                    <p>{{ __('pages/sponsoring.paragraphes.three') }}</p>
                    <p>{{ __('pages/sponsoring.paragraphes.four') }}</p>
                    <p>{{ __('pages/sponsoring.paragraphes.five') }}</p>
                </div>
                <div class="border-t border-gray-200 dark:border-white/10 pt-12">
                    <h4 class="font-heading text-lg font-medium text-gray-900 dark:text-white lg:text-xl">Sponsors</h4>
                    <div class="mt-4 flex flex-wrap items-center gap-6">
                        <a href="https://laravelshopper.dev" target="_blank" class="flex items-center">
                            <img
                                class="h-10 dark:hidden"
                                src="{{ asset('/images/sponsors/shopper-logo.svg') }}"
                                alt="Laravel Shopper"
                            />
                            <img
                                class="hidden h-10 dark:block"
                                src="{{ asset('/images/sponsors/shopper-logo-light.svg') }}"
                                alt="Laravel Shopper"
                            />
                        </a>
                        <a href="https://gdg.community.dev/gdg-douala" target="_blank" class="flex items-center">
                            <x-icon.gdg class="h-6 text-gray-900 dark:text-white" aria-hidden="true" />
                        </a>
                        <a href="https://notchpay.co" target="_blank" class="flex items-center">
                            <x-icon.notchpay class="h-6 w-auto text-gray-900 dark:text-white" aria-hidden="true" />
                        </a>
                        <a href="https://sharuco.lndev.me" target="_blank" class="flex items-center">
                            <x-icon.sharuco class="h-5 w-auto text-gray-900 dark:text-white" aria-hidden="true" />
                            <span class="ml-1 text-xl font-bold text-gray-900 dark:text-white">Sharuco</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-10 lg:col-span-3 lg:mt-0">
            <x-sticky-content class="space-y-8 divide-y divide-gray-200 dark:divide-white/10">
                <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-white/10">
                    <div class="flex flex-wrap items-center bg-gray-100 dark:bg-gray-900 px-4 py-2 text-gray-500 dark:text-gray-400">
                        @auth
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('pages/sponsoring.support_as') }}</span>
                            <span class="ml-3 inline-flex items-center gap-2 text-sm">
                                <x-user.avatar
                                    :user="Auth::user()"
                                    class="size-5"
                                    span="-right-1 -top-1 w-3.5 h-3.5 ring-1"
                                />
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ Auth::user()->username() }}
                                </span>
                            </span>
                        @else
                            <span>
                                {{ __('pages/sponsoring.support') }}
                                <x-link :href="route('login')" class="font-medium text-primary-500 underline">
                                    {{ __('pages/auth.login.page_title') }}
                                </x-link>
                            </span>
                        @endauth
                    </div>
                    @auth
                        <div class="flex items-center border-t border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 p-4">
                            <p class="flex-1 text-sm leading-5 text-gray-500 dark:text-gray-400">
                                {{ __('pages/sponsoring.support_badge') }}
                            </p>
                        </div>
                    @endauth
                </div>

                <livewire:components.sponsor-subscription />
            </x-sticky-content>
        </div>
    </div>
</x-container>
