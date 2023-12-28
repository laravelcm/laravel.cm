<footer class="bg-skin-footer" aria-labelledby="footerHeading">
    <h2 id="footerHeading" class="sr-only">{{ __('Footer') }}</h2>
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="py-12 lg:py-16 lg:grid lg:grid-cols-3 lg:gap-8">
            <div class="space-y-4">
                <img class="h-12 w-auto sm:h-16 logo-white" src="{{ asset('/images/laravelcm.svg') }}" alt="Laravel.cm">
                <img class="h-12 w-auto sm:h-16 logo-dark" src="{{ asset('/images/laravelcm-white.svg') }}" alt="Laravel.cm">
                <p class="inline-flex items-center flex-wrap text-sm text-skin-base">
                    <a href="https://github.com/caneco/laravel-country-logomarks" class="underline text-skin-inverted font-medium">
                        {{ __('Laravel Country Logomarks') }}
                    </a>
                    <span class="ml-1.5">{{ __('par') }} Caneco</span>
                    <img class="ml-2 h-6 w-6 rounded-full" src="https://avatars.githubusercontent.com/u/502041" alt="Caneco profile">
                </p>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-8 lg:mt-0">
                <div>
                    <h3 class="text-sm font-semibold text-skin-muted tracking-wider uppercase">
                        {{ __('Ressources') }}
                    </h3>
                    <ul class="mt-4 space-y-4">
                        <x-footer-link :title="__('A propos')" :url="route('about')" />
                        <x-footer-link :title="__('Podcasts')" url="#" soon />
                        <x-footer-link :title="__('Jobs')" url="#" soon />
                        <x-footer-link :title="__('Sponsors')" :url="route('sponsors')" />
                        <x-footer-link :title="__('Branding')" url="https://github.com/caneco/laravel-country-logomarks/blob/main/src/cm/README.md" />

                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-skin-muted tracking-wider uppercase">
                        {{ __('Légal') }}
                    </h3>
                    <ul class="mt-4 space-y-4">
                        <x-footer-link :title="__('Conditions d’utilisation')" :url="route('terms')" />
                        <x-footer-link :title="__('Confidentialité')" :url="route('privacy')" />
                        <x-footer-link :title="__('Code de conduite')" :url="route('rules')" />
                        <x-footer-link :title="__('FAQ')" :url="route('faq')" />
                    </ul>
                </div>
            </div>
            <div class="mt-12 lg:mt-0">
                <div class="sm:max-w-lg lg:max-w-none">
                    <h3 class="text-sm font-semibold text-skin-muted tracking-wider uppercase">
                        {{ __('Rejoignez nous') }}
                    </h3>
                    <p class="mt-4 text-base text-skin-base">
                        {{ __('Rejoignez notre newsletter recevez des tutoriels, articles et podcasts sur le design et la programmation web.') }}
                    </p>
                    <form aria-labelledby="newsletter-headline" action="https://laravelcm.us4.list-manage.com/subscribe/post?u=0642d391e4785535c232a8c66&id=6ff87af677" method="POST" id="mc-embedded-subscribe-form" class="mt-4 sm:flex" name="mc-embedded-subscribe-form" target="_blank" novalidate>
                        <div class="w-full">
                            <x-email id="mce-EMAIL" name="EMAIL" autocomplete="email" required placeholder="{{ __('Entrer votre adresse email') }}" aria-label="{{ __('Adresse E-mail') }}" class="w-full block" />
                            <input type="hidden" name="b_0642d391e4785535c232a8c66_6ff87af677" tabindex="-1" value="">
                        </div>
                        <div class="mt-3 rounded-md sm:mt-0 sm:ml-3 sm:shrink-0">
                            <x-button type="submit" class="block w-full">
                                {{__('S\'inscrire')}}
                            </x-button>
                        </div>
                    </form>
                </div>
                <p class="mt-6 text-base text-skin-base">
                    {{ __('Ou intégrez nos différentes plateformes de communication') }}
                </p>
                <div class="mt-4 sm:flex sm:items-center sm:space-x-4">
                    <a href="{{ route('discord') }}" class="inline-flex items-center px-4 py-2 text-base text-skin-base font-medium bg-skin-body hover:bg-skin-card-muted rounded-md">
                        <svg class="h-5 w-5 mr-2" fill="#5865F2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 146 146">
                            <path d="M107.75 125.001s-4.5-5.375-8.25-10.125c16.375-4.625 22.625-14.875 22.625-14.875-5.125 3.375-10 5.75-14.375 7.375-6.25 2.625-12.25 4.375-18.125 5.375-12 2.25-23 1.625-32.375-.125-7.125-1.375-13.25-3.375-18.375-5.375-2.875-1.125-6-2.5-9.125-4.25-.375-.25-.75-.375-1.125-.625-.25-.125-.375-.25-.5-.375-2.25-1.25-3.5-2.125-3.5-2.125s6 10 21.875 14.75c-3.75 4.75-8.375 10.375-8.375 10.375-27.625-.875-38.125-19-38.125-19 0-40.25 18-72.875 18-72.875 18-13.5 35.125-13.125 35.125-13.125l1.25 1.5c-22.5 6.5-32.875 16.375-32.875 16.375s2.75-1.5 7.375-3.625c13.375-5.875 24-7.5 28.375-7.875.75-.125 1.375-.25 2.125-.25 7.625-1 16.25-1.25 25.25-.25 11.875 1.375 24.625 4.875 37.625 12 0 0-9.875-9.375-31.125-15.875l1.75-2S110 19.626 128 33.126c0 0 18 32.625 18 72.875 0 0-10.625 18.125-38.25 19zM49.625 66.626c-7.125 0-12.75 6.25-12.75 13.875s5.75 13.875 12.75 13.875c7.125 0 12.75-6.25 12.75-13.875.125-7.625-5.625-13.875-12.75-13.875zm45.625 0c-7.125 0-12.75 6.25-12.75 13.875s5.75 13.875 12.75 13.875c7.125 0 12.75-6.25 12.75-13.875s-5.625-13.875-12.75-13.875z" fill-rule="nonzero"></path>
                        </svg>
                        {{ __('Discord') }}
                    </a>
                    <a href="{{ route('slack') }}" class="inline-flex items-center px-4 py-2 text-base text-skin-base font-medium bg-skin-body hover:bg-skin-card-muted rounded-md">
                        <svg class="h-5 w-5 mr-2" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <g clip-path="url(#clip0)" fill-rule="evenodd" clip-rule="evenodd">
                                <path d="M7.333 0a2 2 0 100 4h2V2a2.001 2.001 0 00-2-2zm0 5.333H2a2 2 0 000 4h5.333a2 2 0 100-4z" fill="#36C5F0"/>
                                <path d="M20 7.333a2 2 0 00-4 0v2h2a2 2 0 002-2zm-5.333 0V2a2 2 0 00-4 0v5.333a2 2 0 104 0z" fill="#2EB67D"/>
                                <path d="M12.666 20a2 2 0 100-3.999h-2v2c-.001 1.102.895 1.998 2 2zm0-5.334H18a2 2 0 000-4h-5.333a2 2 0 000 4z" fill="#ECB22E"/>
                                <path d="M0 12.666a2 2 0 004 0v-2H2a2 2 0 00-2 2zm5.333 0V18a2 2 0 104 0v-5.332a2 2 0 00-4-.002z" fill="#E01E5A"/>
                            </g>
                            <defs>
                                <clipPath id="clip0">
                                    <path fill="#fff" d="M0 0h20v20H0z"/>
                                </clipPath>
                            </defs>
                        </svg>
                        {{ __('Slack') }}
                    </a>
                    <a href="{{ route('telegram') }}" class="inline-flex items-center mt-4 sm:mt-0 px-4 py-2 text-base text-skin-base font-medium bg-skin-body hover:bg-skin-card-muted rounded-md">
                        <svg class="h-5 w-5 mr-2" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M10 20c5.523 0 10-4.477 10-10S15.523 0 10 0 0 4.477 0 10s4.477 10 10 10z" fill="#34AADF"/>
                            <path d="M4.162 9.913s5-2.052 6.734-2.774c.665-.29 2.919-1.214 2.919-1.214s1.04-.405.954.578c-.03.404-.26 1.82-.492 3.352-.346 2.168-.722 4.538-.722 4.538s-.058.665-.55.78c-.49.116-1.3-.404-1.444-.52-.116-.087-2.168-1.387-2.92-2.023-.202-.173-.433-.52.03-.925 1.04-.954 2.283-2.139 3.034-2.89.347-.347.694-1.156-.751-.173a246.647 246.647 0 01-4.075 2.745s-.463.29-1.33.03-1.879-.608-1.879-.608-.693-.433.492-.896z" fill="#fff"/>
                        </svg>
                        {{ __('Telegram') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-skin-base py-6 sm:flex sm:items-center sm:justify-between lg:py-8">
            <p class="text-base text-center leading-6 text-skin-muted lg:text-left">
                {{ __('© 2018 - :date Laravel Cameroun. Tous droits réservés.', ['date' => date('Y')]) }}
            </p>
            <div class="mt-4 flex justify-center space-x-6 sm:mt-0 lg:justify-start">
                <a href="{{ route('twitter') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">{{ __('Twitter') }}</span>
                    <x-icon.twitter class="h-6 w-6" />
                </a>

                <a href="{{ route('facebook') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">{{ __('Facebook') }}</span>
                    <x-icon.facebook class="h-6 w-6" />
                </a>

                <a href="{{ route('linkedin') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">{{ __('LinkedIn') }}</span>
                    <x-icon.linkedin class="h-6 w-6" />
                </a>

                <a href="{{ route('github') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">{{ __('GitHub') }}</span>
                    <x-icon.github class="h-6 w-6" />
                </a>

                <a href="{{ route('youtube') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">{{ __('YouTube') }}</span>
                    <x-icon.youtube class="h-6 w-6" />
                </a>
            </div>
        </div>
    </div>
</footer>
