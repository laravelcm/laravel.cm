@extends('layouts.default')

@section('body')

    <div class="relative flex items-top justify-center min-h-full py-12 sm:py-24 sm:items-center">
        <div>
            <div class="flex justify-center sm:justify-start">
                <img class="h-16 w-auto sm:h-20 logo-white" src="{{ asset('/images/laravelcm.svg') }}" alt="Laravel.cm">
                <img class="h-16 w-auto sm:h-20 logo-dark" src="{{ asset('/images/laravelcm-white.svg') }}" alt="Laravel.cm">
            </div>

            <div class="mt-8 bg-skin-card overflow-hidden shadow rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold">
                                <a href="https://laravel.com/docs" class="underline text-skin-inverted font-sans">{{ __('Articles') }}</a>
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-skin-base text-sm font-normal">
                                {{ __("Tous les articles et une newsletter regroupant toutes les dernières et les plus importantes nouvelles de l'écosystème Laravel, y compris les articles sur le design et d'autres topics.") }}
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-skin-base md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" viewBox="0 0 24 24" class="w-8 h-8">
                                <path d="M12.14 8.647H.938A.937.937 0 0 0 0 9.584v7.453c0 .518.42.938.938.938h2.484v2.487c0 .402.473.617.776.354l3.267-2.841h4.676c.517 0 .937-.42.937-.938V9.584a.937.937 0 0 0-.937-.937z" fill="#86BEEC"/>
                                <path d="M12.14 8.647h-5.6V18.78l.925-.805h4.676c.517 0 .937-.42.937-.938V9.584a.937.937 0 0 0-.937-.937z" fill="#2681FF"/>
                                <path d="M7.594 12.631H2.812a.703.703 0 0 1 0-1.406h4.782a.703.703 0 0 1 0 1.406zm2.672 2.813H2.812a.703.703 0 0 1 0-1.407h7.454a.703.703 0 1 1 0 1.407z" fill="#00429C"/>
                                <path d="M11.86 3.069h11.203c.517 0 .937.42.937.937v7.453c0 .518-.42.938-.938.938h-2.484v2.487a.469.469 0 0 1-.776.353l-3.267-2.84h-4.676a.937.937 0 0 1-.937-.938V4.006c0-.518.42-.937.937-.937z" fill="#00DDC1"/>
                                <path d="M23.063 3.069H17.46v10.133l2.34 2.035a.469.469 0 0 0 .777-.353v-2.487h2.485c.517 0 .937-.42.937-.938V4.006a.937.937 0 0 0-.938-.937z" fill="#00B4BC"/>
                                <path d="M18.516 7.053h-4.782a.703.703 0 0 1 0-1.406h4.782a.703.703 0 0 1 0 1.406zm2.672 2.812h-7.454a.703.703 0 0 1 0-1.406h7.454a.703.703 0 0 1 0 1.406z" fill="#00A88F"/>
                                <path d="M8.297 11.928a.703.703 0 0 0-.703-.703H6.539v1.406h1.055a.703.703 0 0 0 .703-.703zm1.969 2.109H6.539v1.407h3.727a.703.703 0 1 0 0-1.407z" fill="#002659"/>
                                <path d="M19.219 6.35a.703.703 0 0 0-.703-.703H17.46v1.406h1.055a.703.703 0 0 0 .703-.703zm1.969 2.11H17.46v1.405h3.727a.703.703 0 0 0 0-1.406z" fill="#008575"/>
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold">
                                <a href="https://laracasts.com" class="underline text-skin-inverted font-sans">{{ __('Discussions') }}</a>
                            </div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-skin-base text-sm font-normal">
                                {{ __("Découvrez différents sujets de discussion ouvert à tous pour un meilleur échange sur des thématiques et interrogations qui peuvent faire avancer l'ecosystème Tech au Cameroun.") }}
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-skin-base">
                        <div class="flex items-center">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24">
                                <g clip-path="url(#clip0)">
                                    <path d="M2.972 17.992H1.554A1.554 1.554 0 0 1 0 16.438v-2.041c0-.858.696-1.554 1.554-1.554h1.418v5.149zm18.056-5.149h1.418c.858 0 1.554.696 1.554 1.554v2.04c0 .86-.696 1.555-1.554 1.555h-1.418v-5.149z" fill="#FFD88F"/>
                                    <path d="M21.513 18a.835.835 0 0 1-.834-.837v-6.786c0-4.8-3.894-8.705-8.68-8.705s-8.68 3.905-8.68 8.705v6.786a.835.835 0 1 1-1.667 0v-6.786C1.652 4.655 6.294 0 11.999 0c5.706 0 10.348 4.655 10.348 10.377v6.786a.835.835 0 0 1-.834.836z" fill="#B5E8E0"/>
                                    <path d="M3.534 19.955a1.892 1.892 0 0 1-1.892-1.892v-5.292a1.892 1.892 0 1 1 3.783 0v5.292a1.892 1.892 0 0 1-1.891 1.892z" fill="#59A1A5"/>
                                    <path d="M3.534 10.88c-.353 0-.683.096-.966.265.554.33.926.934.926 1.626v5.292a1.89 1.89 0 0 1-.926 1.627 1.892 1.892 0 0 0 2.858-1.627v-5.292a1.892 1.892 0 0 0-1.892-1.892z" fill="#419296"/>
                                    <path d="M20.455 19.955a1.892 1.892 0 0 1-1.892-1.892v-5.292a1.892 1.892 0 0 1 3.784 0v5.292a1.892 1.892 0 0 1-1.892 1.892z" fill="#59A1A5"/>
                                    <path d="M20.455 10.88c-.353 0-.683.096-.966.265.554.33.926.934.926 1.626v5.292a1.89 1.89 0 0 1-.926 1.627 1.892 1.892 0 0 0 2.858-1.627v-5.292a1.892 1.892 0 0 0-1.892-1.892z" fill="#419296"/>
                                    <path d="M10.995 19.893v2.55h2.01v-2.55c-.454.176-.49.182-1.005.182-.516 0-.55-.006-1.005-.182z" fill="#59A1A5"/>
                                    <path d="M9.47 22.443h5.06a.779.779 0 1 1 0 1.557H9.47a.779.779 0 0 1 0-1.557zM12 20.367a5.202 5.202 0 0 1-3.692-1.525 5.202 5.202 0 0 1-1.547-3.714v-2.467c0-.466.379-.845.844-.845h8.79c.465 0 .844.38.844.845v2.414c0 2.901-2.337 5.276-5.208 5.292H12zm-4.395-7.826a.12.12 0 0 0-.12.12v2.467c0 1.209.474 2.345 1.334 3.2a4.483 4.483 0 0 0 3.18 1.315h.027c2.475-.015 4.489-2.064 4.489-4.569v-2.413a.12.12 0 0 0-.12-.12h-8.79z" fill="#B5E8E0"/>
                                    <path d="M12 18.352a3.224 3.224 0 0 1-3.224-3.224V9.974a3.224 3.224 0 1 1 6.448 0v5.154A3.224 3.224 0 0 1 12 18.352z" fill="#FFD88F"/>
                                    <path d="M12 6.75c-.336 0-.66.052-.966.148a3.225 3.225 0 0 1 2.258 3.076v5.154c0 1.444-.95 2.666-2.258 3.076a3.224 3.224 0 0 0 4.19-3.076V9.974A3.224 3.224 0 0 0 12 6.751z" fill="#FFC963"/>
                                    <path d="M12.032 15.005c.597 0 .598-.928 0-.928s-.598.928 0 .928zm0 1.865c.597 0 .598-.928 0-.928s-.598.928 0 .928zm1.425-.917c.597 0 .598-.929 0-.929-.597 0-.598.929 0 .929z" fill="#FF9E5E"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0">
                                        <path fill="#fff" d="M0 0h24v24H0z"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-skin-inverted font-sans">{{ __('Podcasts') }}</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-skin-base text-sm font-normal">
                                {{ __("Le podcast vous apporte des nouvelles et des discussions sur le développement Laravel et PHP, Mobile (Android & iOS), l'entrepreuneriat, le Design graphique/UI/UX. La saison 1 consistera en des interviews avec des acteurs majeurs de notre écosystème.") }}
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-skin-base dark:border-gray-700 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" viewBox="0 0 24 24" class="w-8 h-8">
                                <g clip-path="url(#clip0)">
                                    <path d="M23.772 12.96a2.14 2.14 0 0 0 0-1.92l-.314-.624a.721.721 0 0 1-.07-.437l.107-.69a2.139 2.139 0 0 0-.594-1.826l-.49-.495a.72.72 0 0 1-.202-.395l-.112-.689a2.14 2.14 0 0 0-1.109-1.543l-.604-.357a.72.72 0 0 1-.349-.333l-.32-.62c-.3-.585-.913-1.018-1.6-1.129l-.689-.112a.72.72 0 0 1-.394-.2l-.495-.492A2.14 2.14 0 0 0 14.71.504l-.69.107a.72.72 0 0 1-.437-.07L12.96.228a2.14 2.14 0 0 0-1.92 0l-.623.315A.722.722 0 0 1 9.98.61L9.29.504a2.139 2.139 0 0 0-1.827.594l-.495.491a.72.72 0 0 1-.394.201l-.69.112c-.686.111-1.3.544-1.6 1.13l-.319.62a.72.72 0 0 1-.313.313l-.62.319c-.586.3-1.018.914-1.13 1.6l-.111.69a.72.72 0 0 1-.201.394l-.492.495A2.14 2.14 0 0 0 .505 9.29l.106.69a.72.72 0 0 1-.069.436l-.314.623a2.14 2.14 0 0 0 0 1.92l.314.624a.72.72 0 0 1 .07.437l-.107.69a2.14 2.14 0 0 0 .593 1.826l.492.495a.72.72 0 0 1 .2.395l.113.689c.11.686.544 1.3 1.129 1.6l.62.32a.72.72 0 0 1 .313.313l.32.62c.3.585.913 1.018 1.6 1.129l.689.112c.15.024.286.094.394.2l.495.492a2.14 2.14 0 0 0 1.827.594l.69-.107c.15-.023.301 0 .437.07l.623.314a2.132 2.132 0 0 0 1.92 0l.623-.315a.722.722 0 0 1 .438-.069l.689.107a2.14 2.14 0 0 0 1.827-.594l.495-.491a.72.72 0 0 1 .394-.201l.689-.112a2.139 2.139 0 0 0 1.544-1.11l.356-.604a.72.72 0 0 1 .333-.349l.62-.319a2.139 2.139 0 0 0 1.13-1.554l.111-.688a.72.72 0 0 1 .201-.395c.008-.007.504-.554.504-.554a2.14 2.14 0 0 0 .581-1.815l-.106-.689a.72.72 0 0 1 .069-.437l.314-.623z" fill="url(#paint0_linear)"/>
                                    <path d="M12 3.515c-4.658 0-8.485 3.828-8.485 8.485 0 4.659 3.828 8.485 8.485 8.485 4.658 0 8.485-3.827 8.485-8.485 0-4.658-3.828-8.485-8.485-8.485zm4.901 6.546l-1.406 5.626a.703.703 0 0 1-.682.532H9.187a.703.703 0 0 1-.682-.532L7.1 10.06a.703.703 0 0 1 1.265-.56c.192.282.888 1.095 1.525 1.095.117 0 .478-.271.85-1.11.333-.75.557-1.718.557-2.406a.703.703 0 1 1 1.406 0c0 .688.224 1.655.558 2.407.371.838.732 1.109.849 1.109.656 0 1.37-.864 1.525-1.095a.703.703 0 0 1 1.266.562z" fill="url(#paint1_linear)"/>
                                </g>
                                <defs>
                                    <linearGradient id="paint0_linear" x1="12" y1="24" x2="12" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FD5900"/>
                                        <stop offset="1" stop-color="#FFDE00"/>
                                    </linearGradient>
                                    <linearGradient id="paint1_linear" x1="12" y1="20.485" x2="12" y2="3.515" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#FFE59A"/>
                                        <stop offset="1" stop-color="#FFFFD5"/>
                                    </linearGradient>
                                    <clipPath id="clip0">
                                        <path fill="#fff" d="M0 0h24v24H0z"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-skin-inverted font-sans">{{ __('Premium') }}</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-skin-base text-sm font-normal">
                                {{ __("Devenez prémium et ayez accès à des ressources privées, des codes sources des tutoriels et la possibilité d'avoir accés à des promotions sur les formations à venir. Et aussi vous aidez la communauté à maintenir le site en activité et disponible 😊") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-skin-base sm:text-left">
                    <div class="flex items-center">
                        <x-heroicon-o-heart class="w-5 h-5 text-skin-muted" />

                        <a href="https://github.com/sponsors/sense" class="ml-1 underline">
                            {{ __('Devenir Sponsor') }}
                        </a>
                    </div>
                </div>

                <div class="ml-4 text-center text-sm text-skin-base sm:text-right sm:ml-0">
                    Laravel Cameroun 2018 - {{ date('Y') }}
                </div>
            </div>
        </div>
    </div>

@stop
