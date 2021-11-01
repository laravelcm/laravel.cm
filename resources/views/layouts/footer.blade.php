<footer class="bg-skin-footer" aria-labelledby="footerHeading">
    <h2 id="footerHeading" class="sr-only">{{ __('Footer') }}</h2>
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="py-12 lg:py-16 xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="space-y-4 xl:col-span-1">
                <img class="h-12 w-auto sm:h-16 logo-white" src="{{ asset('/images/laravelcm.svg') }}" alt="Laravel.cm">
                <img class="h-12 w-auto sm:h-16 logo-dark" src="{{ asset('/images/laravelcm-white.svg') }}" alt="Laravel.cm">
                <p class="inline-flex items-center flex-wrap text-sm text-skin-base font-sans">
                    <a href="https://github.com/caneco/laravel-country-logomarks" class="underline text-skin-inverted font-medium">Laravel Country Logomarks</a>
                    <span class="ml-1.5">{{ __('par') }} Caneco</span>
                    <img class="ml-2 h-6 w-6 rounded-full" src="https://avatars.githubusercontent.com/u/502041" alt="Caneco profile">
                </p>
            </div>
            <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
                <div class="md:grid md:grid-cols-2 md:gap-4">
                    <div>
                        <h3 class="text-sm font-semibold text-skin-muted tracking-wider uppercase font-sans">
                            {{ __('Ressources') }}
                        </h3>
                        <ul class="mt-4 space-y-4">

                            <li>
                                <a href="{{ route('about') }}" class="text-base text-skin-base hover:text-skin-menu-hover font-normal">
                                    {{ __('A propos') }}
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-base text-skin-base hover:text-skin-menu-hover font-normal">
                                    {{ __('Podcasts') }}
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-base text-skin-base hover:text-skin-menu-hover font-normal">
                                    {{ __('Tags') }}
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-base text-skin-base hover:text-skin-menu-hover font-normal">
                                    {{ __('Jobs') }}
                                </a>
                            </li>

                            <li>
                                <a href="#" class="text-base text-skin-base hover:text-skin-menu-hover font-normal">
                                    {{ __('Sponsors') }}
                                </a>
                            </li>

                            <li>
                                <a href="https://github.com/caneco/laravel-country-logomarks/blob/main/src/cm/README.md" class="text-base text-skin-base hover:text-skin-menu-hover font-normal">
                                    {{ __('Branding') }}
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="mt-12 md:mt-0">
                        <h3 class="text-sm font-semibold text-skin-muted tracking-wider uppercase font-sans">
                            {{ __('Légal') }}
                        </h3>
                        <ul class="mt-4 space-y-4">

                            <li>
                                <a href="{{ route('terms') }}" class="text-base text-skin-base hover:text-skin-menu-hover font-normal">
                                    {{ __('Conditions d’utilisation') }}
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('privacy') }}" class="text-base text-skin-base hover:text-skin-menu-hover font-normal">
                                    {{ __('Confidentialité') }}
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('rules') }}" class="text-base text-skin-base hover:text-skin-menu-hover font-normal">
                                    {{ __('Code de conduite') }}
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('faq') }}" class="text-base text-skin-base hover:text-skin-menu-hover font-normal">
                                    {{ __('FAQ') }}
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-skin-muted tracking-wider uppercase font-sans">
                        {{ __('Rejoignez nous') }}
                    </h3>
                    <p class="mt-4 text-base text-skin-base font-normal">
                        {{ __('Rejoignez notre newsletter recevez des tutoriels, articles et podcasts sur le design et la programmation web.') }}
                    </p>
                    <form aria-labelledby="newsletter-headline" action="https://laravelcm.us4.list-manage.com/subscribe/post?u=0642d391e4785535c232a8c66&id=6ff87af677" method="POST" id="mc-embedded-subscribe-form" class="mt-4 sm:flex" name="mc-embedded-subscribe-form" target="_blank" novalidate>
                        <div class="w-full">
                            <x-email id="mce-EMAIL" name="EMAIL" autocomplete="email" required placeholder="{{ __('Entrer votre adresse email') }}" aria-label="{{ __('Adresse E-mail') }}" class="w-full block" />
                            <input type="hidden" name="b_0642d391e4785535c232a8c66_6ff87af677" tabindex="-1" value="">
                        </div>
                        <div class="mt-3 rounded-md sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                            <x-button type="submit" class="block w-full">
                                {{__('S\'inscrire')}}
                            </x-button>
                        </div>
                    </form>
                    <p class="mt-6 text-base text-skin-base font-normal">
                        {{ __('Ou intégrez nos différentes plateformes de communication') }}
                    </p>
                    <div class="mt-4 sm:flex sm:items-center sm:space-x-4">
                        <a href="{{ route('slack') }}" class="inline-flex items-center px-4 py-2 text-base text-skin-base font-medium font-sans bg-skin-body hover:bg-skin-card-muted rounded-md">
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
                            Slack
                        </a>
                        <a href="{{ route('telegram') }}" class="inline-flex items-center mt-4 sm:mt-0 px-4 py-2 text-base text-skin-base font-medium font-sans bg-skin-body hover:bg-skin-card-muted rounded-md">
                            <svg class="h-5 w-5 mr-2" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M10 20c5.523 0 10-4.477 10-10S15.523 0 10 0 0 4.477 0 10s4.477 10 10 10z" fill="#34AADF"/>
                                <path d="M4.162 9.913s5-2.052 6.734-2.774c.665-.29 2.919-1.214 2.919-1.214s1.04-.405.954.578c-.03.404-.26 1.82-.492 3.352-.346 2.168-.722 4.538-.722 4.538s-.058.665-.55.78c-.49.116-1.3-.404-1.444-.52-.116-.087-2.168-1.387-2.92-2.023-.202-.173-.433-.52.03-.925 1.04-.954 2.283-2.139 3.034-2.89.347-.347.694-1.156-.751-.173a246.647 246.647 0 01-4.075 2.745s-.463.29-1.33.03-1.879-.608-1.879-.608-.693-.433.492-.896z" fill="#fff"/>
                            </svg>
                            Telegram
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-t border-skin-light py-6 sm:flex sm:items-center sm:justify-between lg:py-8">
            <p class="text-base leading-6 font-normal text-skin-muted">
                © 2018 - {{ date('Y') }} Laravel Cameroun. Tous droits réservés.
            </p>
            <div class="mt-4 flex space-x-6 md:mt-0">
                <a href="{{ route('twitter') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">Twitter</span>
                    <x-icon.twitter class="h-6 w-6" />
                </a>

                <a href="{{ route('facebook') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">Facebook</span>
                    <x-icon.facebook class="h-6 w-6" />
                </a>

                <a href="{{ route('linkedin') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">LinkedIn</span>
                    <x-icon.linkedin class="h-6 w-6" />
                </a>

                <a href="{{ route('github') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">GitHub</span>
                    <x-icon.github class="h-6 w-6" />
                </a>

                <a href="{{ route('youtube') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">YouTube</span>
                    <x-icon.youtube class="h-6 w-6" />
                </a>

            </div>
        </div>
    </div>
</footer>
