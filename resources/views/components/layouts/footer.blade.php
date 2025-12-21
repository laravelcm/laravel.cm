<footer class="bg-gray-900 border-t border-dotted border-gray-700 dark:border-white/10" aria-labelledby="footerHeading">
    <h2 id="footerHeading" class="sr-only">{{ __('global.footer.title') }}</h2>
    <x-container class="relative z-10">
        <div class="py-12 sm:py-16 lg:grid lg:grid-cols-3 lg:gap-8 lg:py-20 xl:pt-24">
            <div class="space-y-3">
                <x-brand class="h-12 w-auto text-white sm:h-16" aria-hidden="true" />
                <p class="inline-flex flex-wrap items-center text-gray-400 text-sm">
                    <a href="https://github.com/caneco/laravel-country-logomarks" target="_blank" class="font-medium text-gray-300 underline">
                        Laravel Country Logomarks
                    </a>
                    <span class="ml-1.5">{{ __('global.by') }} Caneco</span>
                    <img
                        loading="lazy"
                        class="ml-2 size-6 rounded-full"
                        src="https://avatars.githubusercontent.com/u/502041"
                        alt="Caneco avatar"
                    />
                </p>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-8 lg:mt-0">
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white">
                        {{ __('global.footer.resources') }}
                    </h3>
                    <ul class="mt-6 space-y-3">
                        <x-footer-link :title="__('global.navigation.about')" :href="route('about')" />
                        <x-footer-link :title="__('global.navigation.sponsors')" :href="route('sponsors')" />
                        <x-footer-link
                            :title="__('global.navigation.branding')"
                            href="https://github.com/caneco/laravel-country-logomarks/blob/main/src/cm/README.md"
                        />
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white">
                        {{ __('global.footer.legal') }}
                    </h3>
                    <ul class="mt-6 space-y-3">
                        <x-footer-link :title="__('global.navigation.terms')" :href="route('terms')" />
                        <x-footer-link :title="__('global.navigation.privacy')" :href="route('privacy')" />
                        <x-footer-link :title="__('global.navigation.rules')" :href="route('rules')" />
                    </ul>
                </div>
            </div>
            <div class="mt-12 lg:mt-0">
                <div class="sm:max-w-lg lg:max-w-none">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white">
                        {{ __('global.joins_us.title') }}
                    </h3>
                    <p class="mt-6 text-sm text-gray-400">
                        {{ __('global.joins_us.description') }}
                    </p>
                </div>
                <div class="mt-8 space-y-8">
                    <div class="flex items-center text-sm font-medium space-x-4 sm:space-x-6">
                        <a href="https://discord.gg/KNp6brbyVD?utm_source=laravel.cm" target="_blank" class="inline-flex items-center gap-2 text-gray-400 hover:text-white">
                            <x-icon.discord class="size-5 text-[#5865F2]" aria-hidden="true" />
                            Discord
                        </a>
                        <a href="https://t.me/laravelcameroun?utm_source=laravel.cm" target="_blank" class="inline-flex items-center gap-2 text-gray-400 hover:text-white">
                            <x-icon.telegram class="size-5 text-[#34AADF]" aria-hidden="true" />
                            Telegram
                        </a>
                    </div>
                    <livewire:components.change-locale />
                </div>
            </div>
        </div>
        <div
            class="relative pb-12 text-gray-500"
            x-data="{ spotlight: { x: 0, y: 0 } }"
            @mousemove="const rect = $el.getBoundingClientRect(); spotlight = { x: $event.clientX - rect.left, y: $event.clientY - rect.top }"
        >
            <div
                class="w-full"
                x-bind:style="
                    'mask-image: radial-gradient(circle at ' +
                        spotlight.x +
                        'px ' +
                        spotlight.y +
                        'px, black 0%, transparent 150px); -webkit-mask-image: radial-gradient(circle at ' +
                        spotlight.x +
                        'px ' +
                        spotlight.y +
                        'px, black 0%, transparent 600px);'
                "
                style="mask-image: radial-gradient(circle at 160px 378.609375px, black 0%, transparent 150px); -webkit-mask-image: radial-gradient(circle at 160px 378.609375px, black 0%, transparent 600px);"
            >
                <x-icon.community class="size-full" aria-hidden="true" />
            </div>
        </div>
        <div class="border-t border-white/5 py-6 sm:flex sm:items-center sm:justify-between lg:py-8">
            <p class="text-center text-sm leading-6 text-gray-400 lg:text-left">
                {{ __('global.footer.copyright', ['date' => date('Y')]) }}
            </p>
            <div class="mt-4 flex items-center justify-center space-x-4 sm:mt-0 lg:justify-start">
                <a href="https://github.com/laravelcm?utm_source=laravel.cm" target="_blank" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">GitHub</span>
                    <x-icon.github class="size-6" aria-hidden="true" />
                </a>

                <a href="https://twitter.com/laravelcm?utm_source=laravel.cm" target="_blank" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">Twitter</span>
                    <x-icon.twitter class="size-5" aria-hidden="true" />
                </a>

                <a href="https://facebook.com/laravelcm?utm_source=laravel.cm" target="_blank" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">Facebook</span>
                    <x-icon.facebook class="size-6" aria-hidden="true" />
                </a>

                <a href="https://www.linkedin.com/company/laravel-cameroun?utm_source=laravel.cm" target="_blank" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">LinkedIn</span>
                    <x-icon.linkedin class="size-6" aria-hidden="true" />
                </a>

                <a href="https://www.youtube.com/channel/UCbQPQ8q31uQmuKtyRnATLSw?utm_source=laravel.cm" target="_blank" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">YouTube</span>
                    <x-icon.youtube class="size-6" aria-hidden="true" />
                </a>
            </div>
        </div>
    </x-container>
</footer>
