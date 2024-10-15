<footer class="bg-gray-900 lg:pt-8" aria-labelledby="footerHeading">
    <h2 id="footerHeading" class="sr-only">{{ __('global.footer.title') }}</h2>
    <div class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="py-12 lg:grid lg:grid-cols-3 lg:gap-8 lg:py-16">
            <div class="space-y-3">
                <x-brand class="h-12 w-auto text-white sm:h-16" />
                <p class="inline-flex flex-wrap items-center text-gray-400 text-sm">
                    <a href="https://github.com/caneco/laravel-country-logomarks" class="font-medium text-gray-300 underline">
                        Laravel Country Logomarks
                    </a>
                    <span class="ml-1.5">{{ __('global.by') }} Caneco</span>
                    <img
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
                        <x-footer-link :title="__('global.navigation.about')" :url="route('about')" />
                        <x-footer-link :title="__('global.navigation.podcasts')" url="#" soon />
                        <x-footer-link :title="__('global.navigation.jobs')" url="#" soon />
                        <x-footer-link :title="__('global.navigation.sponsors')" :url="route('sponsors')" />
                        <x-footer-link
                            :title="__('global.navigation.branding')"
                            url="https://github.com/caneco/laravel-country-logomarks/blob/main/src/cm/README.md"
                        />
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white">
                        {{ __('global.footer.legal') }}
                    </h3>
                    <ul class="mt-6 space-y-3">
                        <x-footer-link :title="__('global.navigation.terms')" :url="route('terms')" />
                        <x-footer-link :title="__('global.navigation.privacy')" :url="route('privacy')" />
                        <x-footer-link :title="__('global.navigation.rules')" :url="route('rules')" />
                        <x-footer-link :title="__('global.navigation.faq')" :url="route('faq')" />
                    </ul>
                </div>
            </div>
            <div class="mt-12 lg:mt-0">
                <div class="sm:max-w-lg lg:max-w-none">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-white">
                        {{ __('global.joins_us.title') }}
                    </h3>
                    <p class="mt-6 text-sm text-gray-300">
                        {{ __('global.joins_us.description') }}
                    </p>
                </div>
                <div class="mt-6 flex items-center text-sm font-medium space-x-4 sm:space-x-6">
                    <x-link href="{{ route('discord') }}" class="inline-flex items-center gap-2 text-gray-300 hover:text-white">
                        <x-icon.discord class="size-5 text-[#5865F2]" aria-hidden="true" />
                        Discord
                    </x-link>
                    <x-link href="{{ route('telegram') }}" class="inline-flex items-center gap-2 text-gray-300 hover:text-white">
                        <x-icon.telegram class="size-5 text-[#34AADF]" aria-hidden="true" />
                        Telegram
                    </x-link>
                    <x-link href="{{ route('whatsapp') }}" class="inline-flex items-center gap-2 text-gray-300 hover:text-white">
                        <x-icon.whatsapp class="size-5 text-[#28D146]" aria-hidden="true" />
                        WhatsApp
                    </x-link>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10 py-6 sm:flex sm:items-center sm:justify-between lg:py-8">
            <p class="text-center text-sm leading-6 text-gray-400 lg:text-left">
                {{ __('global.footer.copyright', ['date' => date('Y')]) }}
            </p>
            <div class="mt-4 flex items-center justify-center space-x-4 sm:mt-0 lg:justify-start">
                <x-link href="{{ route('twitter') }}" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">Twitter</span>
                    <x-icon.twitter class="size-5" aria-hidden="true" />
                </x-link>

                <x-link href="{{ route('facebook') }}" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">Facebook</span>
                    <x-icon.facebook class="size-6" aria-hidden="true" />
                </x-link>

                <x-link href="{{ route('linkedin') }}" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">LinkedIn</span>
                    <x-icon.linkedin class="size-6" aria-hidden="true" />
                </x-link>

                <x-link href="{{ route('github') }}" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">GitHub</span>
                    <x-icon.github class="size-6" aria-hidden="true" />
                </x-link>

                <x-link href="{{ route('youtube') }}" class="text-gray-400 hover:text-gray-300">
                    <span class="sr-only">YouTube</span>
                    <x-icon.youtube class="size-6" aria-hidden="true" />
                </x-link>
            </div>
        </div>
    </div>
</footer>
