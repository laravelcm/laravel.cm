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
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                    </svg>
                </a>

                <a href="{{ route('facebook') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">Facebook</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                    </svg>
                </a>

                <a href="{{ route('linkedin') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">LinkedIn</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19 0H5a5 5 0 00-5 5v14a5 5 0 005 5h14a5 5 0 005-5V5a5 5 0 00-5-5zM8 19H5V8h3v11zM6.5 6.732c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zM20 19h-3v-5.604c0-3.368-4-3.113-4 0V19h-3V8h3v1.765c1.396-2.586 7-2.777 7 2.476V19z"/>
                    </svg>
                </a>

                <a href="{{ route('github') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">GitHub</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path>
                    </svg>
                </a>

                <a href="{{ route('youtube') }}" class="text-skin-muted hover:text-skin-base">
                    <span class="sr-only">YouTube</span>
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0C.488 3.45.029 5.804 0 12c.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0C23.512 20.55 23.971 18.196 24 12c-.029-6.185-.484-8.549-4.385-8.816zM9 16V8l8 3.993L9 16z"/>
                    </svg>
                </a>

            </div>
        </div>
    </div>
</footer>
