@title('Créer un compte')

@extends('layouts.default')

@section('body')

    <div class="w-full mx-auto flex items-center justify-between py-6 sm:py-9 sm:max-w-4xl">
        <div class="hidden lg:block lg:w-90">
            <h3 class="text-lg leading-6 font-semibold font-sans text-skin-inverted">
                {{ __('Ouvrez votre esprit pour découvrir de nouveaux horizons.') }}
            </h3>
            <dl class="mt-6 space-y-4">
                <div class="relative">
                    <dt>
                        <svg class="absolute h-6 w-6" fill="none" viewBox="0 0 24 24">
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
                    </dt>
                    <dd class="mt-2 ml-9 text-base text-skin-base">
                        <span class="text-skin-inverted">{{ __('Podcast') }}.</span>
                        <span class="font-normal">
                            {{ __('Suivez des podcasts sur différentes thématiques avec des freelances, développeurs, entrepreneurs etc.') }}
                        </span>
                    </dd>
                </div>
                <div class="relative">
                    <dt>
                        <svg class="absolute h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path d="M12.14 8.647H.938A.937.937 0 0 0 0 9.584v7.453c0 .518.42.938.938.938h2.484v2.487c0 .402.473.617.776.354l3.267-2.841h4.676c.517 0 .937-.42.937-.938V9.584a.937.937 0 0 0-.937-.937z" fill="#86BEEC"/>
                            <path d="M12.14 8.647h-5.6V18.78l.925-.805h4.676c.517 0 .937-.42.937-.938V9.584a.937.937 0 0 0-.937-.937z" fill="#2681FF"/>
                            <path d="M7.594 12.631H2.812a.703.703 0 0 1 0-1.406h4.782a.703.703 0 0 1 0 1.406zm2.672 2.813H2.812a.703.703 0 0 1 0-1.407h7.454a.703.703 0 1 1 0 1.407z" fill="#00429C"/>
                            <path d="M11.86 3.069h11.203c.517 0 .937.42.937.937v7.453c0 .518-.42.938-.938.938h-2.484v2.487a.469.469 0 0 1-.776.353l-3.267-2.84h-4.676a.937.937 0 0 1-.937-.938V4.006c0-.518.42-.937.937-.937z" fill="#00DDC1"/>
                            <path d="M23.063 3.069H17.46v10.133l2.34 2.035a.469.469 0 0 0 .777-.353v-2.487h2.485c.517 0 .937-.42.937-.938V4.006a.937.937 0 0 0-.938-.937z" fill="#00B4BC"/>
                            <path d="M18.516 7.053h-4.782a.703.703 0 0 1 0-1.406h4.782a.703.703 0 0 1 0 1.406zm2.672 2.812h-7.454a.703.703 0 0 1 0-1.406h7.454a.703.703 0 0 1 0 1.406z" fill="#00A88F"/>
                            <path d="M8.297 11.928a.703.703 0 0 0-.703-.703H6.539v1.406h1.055a.703.703 0 0 0 .703-.703zm1.969 2.109H6.539v1.407h3.727a.703.703 0 1 0 0-1.407z" fill="#002659"/>
                            <path d="M19.219 6.35a.703.703 0 0 0-.703-.703H17.46v1.406h1.055a.703.703 0 0 0 .703-.703zm1.969 2.11H17.46v1.405h3.727a.703.703 0 0 0 0-1.406z" fill="#008575"/>
                        </svg>
                    </dt>
                    <dd class="mt-2 ml-9 text-base text-skin-base">
                        <span class="text-skin-inverted">{{ __('Discussions') }}.</span>
                        <span class="font-normal">
                            {{ __('Participez a des discussions et débats ouverts avec plusieurs autres participants.') }}
                        </span>
                    </dd>
                </div>
                <div class="relative">
                    <dt>
                        <svg class="absolute h-6 w-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g clip-path="url(#clip0)">
                                <path d="M18.992 1.571v20.858c0 .868-.704 1.571-1.571 1.571H1.985a1.57 1.57 0 0 1-1.57-1.57V1.57C.415.702 1.117 0 1.985 0H17.42a1.57 1.57 0 0 1 1.571 1.57z" fill="#424C59"/>
                                <path d="M18.992 1.57v2.467H.414V1.571A1.57 1.57 0 0 1 1.985 0h15.436c.867 0 1.571.703 1.571 1.57z" fill="#EAEAEA"/>
                                <path d="M2.917 2.788a.809.809 0 1 0 0-1.618.809.809 0 0 0 0 1.618z" fill="#F9572B"/>
                                <path d="M5.64 2.788a.809.809 0 1 0 0-1.618.809.809 0 0 0 0 1.618z" fill="#FCC63D"/>
                                <path d="M8.364 2.788a.809.809 0 1 0 0-1.618.809.809 0 0 0 0 1.618zm10.566 9.3a4.656 4.656 0 1 0 0-9.312 4.656 4.656 0 0 0 0 9.312z" fill="#45B8C4"/>
                                <path d="M12.462 7.29h-8.16a.368.368 0 1 1 0-.735h8.16a.368.368 0 1 1 0 .735z" fill="#FCC63D"/>
                                <path d="M2.66 7.29c-.336 0-.496-.437-.233-.651.26-.212.662.022.594.356a.371.371 0 0 1-.36.295z" fill="#fff"/>
                                <path d="M12.462 11.398h-8.16a.368.368 0 1 1 0-.736h8.16a.367.367 0 1 1 0 .736z" fill="#FCC63D"/>
                                <path d="M2.66 11.398a.371.371 0 0 1-.346-.245.37.37 0 0 1 .109-.404c.246-.208.636-.005.603.317a.372.372 0 0 1-.365.332zm13.11 2.052h-2.303a.368.368 0 1 1 0-.734h2.303a.368.368 0 0 1 0 .735z" fill="#fff"/>
                                <path d="M12.241 13.451H7.953a.368.368 0 1 1 0-.735h4.288a.367.367 0 1 1 0 .735z" fill="#F9572B"/>
                                <path d="M6.728 13.451H4.302a.368.368 0 1 1 0-.735h2.426a.368.368 0 1 1 0 .735zm-4.068 0c-.33 0-.491-.424-.243-.643.248-.218.65-.008.608.321a.372.372 0 0 1-.364.322z" fill="#fff"/>
                                <path d="M10.257 15.505H4.302a.368.368 0 1 1 0-.736h5.955a.368.368 0 1 1 0 .736z" fill="#FCC63D"/>
                                <path d="M2.66 15.505a.371.371 0 0 1-.34-.227.37.37 0 0 1 .12-.435c.268-.199.655.05.578.377a.371.371 0 0 1-.357.285z" fill="#fff"/>
                                <path d="M13.932 17.558h-1.127a.367.367 0 1 1 0-.735h1.127a.368.368 0 1 1 0 .735z" fill="#F9572B"/>
                                <path d="M11.58 17.558H8.32a.368.368 0 1 1 0-.735h3.26a.368.368 0 1 1 0 .735z" fill="#FCC63D"/>
                                <path d="M7.096 17.558H4.302a.368.368 0 1 1 0-.735h2.794a.368.368 0 1 1 0 .735zm-4.436 0c-.33 0-.491-.422-.244-.642.248-.22.651-.009.61.32a.371.371 0 0 1-.365.322zm12.963 2.054H10.38a.368.368 0 1 1 0-.735h5.244a.368.368 0 0 1 0 .735z" fill="#fff"/>
                                <path d="M9.154 19.612H4.302a.368.368 0 1 1 0-.735h4.852a.368.368 0 1 1 0 .735z" fill="#F9572B"/>
                                <path d="M2.66 19.612c-.328 0-.49-.419-.247-.64.243-.22.647-.02.613.308a.372.372 0 0 1-.365.332z" fill="#fff"/>
                                <path d="M6.728 21.666H4.302a.368.368 0 1 1 0-.736h2.426a.368.368 0 1 1 0 .736z" fill="#F9572B"/>
                                <path d="M2.66 21.666a.371.371 0 0 1-.346-.244.37.37 0 0 1 .133-.423c.264-.186.64.05.574.371a.372.372 0 0 1-.36.296z" fill="#fff"/>
                                <path d="M6.14 9.344H4.302a.368.368 0 1 1 0-.735H6.14a.368.368 0 1 1 0 .735z" fill="#F9572B"/>
                                <path d="M10.992 9.344H7.463a.368.368 0 1 1 0-.735h3.529a.368.368 0 0 1 0 .735zm-8.332 0a.371.371 0 0 1-.342-.236.37.37 0 0 1 .116-.422c.261-.203.654.034.587.362a.372.372 0 0 1-.36.296zm16.05.551c-.1 0-.196-.04-.266-.113L16.68 7.944a.368.368 0 0 1 .53-.51l1.412 1.47 1.967-3.738a.368.368 0 1 1 .651.342l-2.205 4.19a.367.367 0 0 1-.326.197z" fill="#fff"/>
                            </g>
                            <defs>
                                <clipPath id="clip0">
                                    <path fill="#fff" d="M0 0h24v24H0z"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </dt>
                    <dd class="mt-2 ml-9 text-base text-skin-base">
                        <span class="text-skin-inverted">{{ __('Code Snippets') }}.</span>
                        <span class="font-normal">
                            {{ __("Partagez des codes sources de différents langages pour venir en aide a d’autres développeurs.") }}
                        </span>
                    </dd>
                </div>
                <div class="relative">
                    <dt>
                        <svg class="absolute h-6 w-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g clip-path="url(#clip0)">
                                <path d="M23.772 12.96a2.14 2.14 0 0 0 0-1.92l-.314-.624a.721.721 0 0 1-.07-.437l.107-.69a2.139 2.139 0 0 0-.594-1.826l-.49-.495a.72.72 0 0 1-.202-.395l-.112-.689a2.14 2.14 0 0 0-1.109-1.543l-.604-.357a.72.72 0 0 1-.349-.333l-.32-.62c-.3-.585-.913-1.018-1.6-1.129l-.689-.112a.72.72 0 0 1-.394-.2l-.495-.492A2.14 2.14 0 0 0 14.71.504l-.69.107a.72.72 0 0 1-.437-.07L12.96.228a2.14 2.14 0 0 0-1.92 0l-.623.315A.722.722 0 0 1 9.98.61L9.29.504a2.139 2.139 0 0 0-1.827.594l-.495.491a.72.72 0 0 1-.394.201l-.69.112c-.686.111-1.3.544-1.6 1.13l-.319.62a.72.72 0 0 1-.313.313l-.62.319c-.586.3-1.018.914-1.13 1.6l-.111.69a.72.72 0 0 1-.201.394l-.492.495A2.14 2.14 0 0 0 .505 9.29l.106.69a.72.72 0 0 1-.069.436l-.314.623a2.14 2.14 0 0 0 0 1.92l.314.624a.72.72 0 0 1 .07.437l-.107.69a2.14 2.14 0 0 0 .593 1.826l.492.495a.72.72 0 0 1 .2.395l.113.689c.11.686.544 1.3 1.129 1.6l.62.32a.72.72 0 0 1 .313.313l.32.62c.3.585.913 1.018 1.6 1.129l.689.112c.15.024.286.094.394.2l.495.492a2.14 2.14 0 0 0 1.827.594l.69-.107c.15-.023.301 0 .437.07l.623.314a2.132 2.132 0 0 0 1.92 0l.623-.315a.722.722 0 0 1 .438-.069l.689.107a2.14 2.14 0 0 0 1.827-.594l.495-.491a.72.72 0 0 1 .394-.201l.689-.112a2.139 2.139 0 0 0 1.544-1.11l.356-.604a.72.72 0 0 1 .333-.349l.62-.319a2.139 2.139 0 0 0 1.13-1.554l.111-.688a.72.72 0 0 1 .201-.395c.008-.007.504-.554.504-.554a2.14 2.14 0 0 0 .581-1.815l-.106-.689a.72.72 0 0 1 .069-.437l.314-.623z" fill="url(#paint0_linear)"/>
                                <path d="M12 3.515c-4.658 0-8.485 3.828-8.485 8.485 0 4.659 3.828 8.485 8.485 8.485 4.658 0 8.485-3.827 8.485-8.485 0-4.658-3.828-8.485-8.485-8.485zm4.901 6.546l-1.406 5.626a.703.703 0 0 1-.682.532H9.187a.703.703 0 0 1-.682-.532L7.1 10.06a.703.703 0 0 1 1.265-.56c.192.282.888 1.095 1.525 1.095.117 0 .478-.271.85-1.11.333-.75.557-1.718.557-2.406a.703.703 0 1 1 1.406 0c0 .688.224 1.655.558 2.407.371.838.732 1.109.849 1.109.656 0 1.37-.864 1.525-1.095a.703.703 0 0 1 1.266.562z" fill="url(#paint1_linear)"/>
                            </g>
                            <defs>
                                <linearGradient id="paint0_linear" x1="12" y1="24" x2="12" gradientUnits="userSpaceOnUse">
                                    <stop offset="1" stop-color="#FD5900" />
                                    <stop offset="1" stop-color="#FFDE00"/>
                                </linearGradient>
                                <linearGradient id="paint1_linear" x1="12" y1="20.485" x2="12" y2="3.515" gradientUnits="userSpaceOnUse">
                                    <stop offset="1" stop-color="#FFE59A"/>
                                    <stop offset="1" stop-color="#FFFFD5"/>
                                </linearGradient>
                                <clipPath id="clip0">
                                    <path fill="#fff" d="M0 0h24v24H0z"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </dt>
                    <dd class="mt-2 ml-9 text-base text-skin-base">
                        <span class="text-skin-inverted">{{ __('Premium') }}.</span>
                        <span class="font-normal">
                            {{ __('Devenez premium, supporter la communauté et accéder à des contenus et codes sources privés.') }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
        <div class="mx-auto max-w-md lg:mx-0 space-y-8">
            <div class="space-y-3">
                <h2 class="text-center text-3xl font-extrabold text-skin-inverted font-sans">
                    {{ __('Rejoindre Laravel Cameroun') }}
                </h2>
                <div class="flex justify-center -space-x-2 py-1 overflow-hidden">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixqx=8uCHNjpfsv&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixqx=8uCHNjpfsv&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.25&w=256&h=256&q=80" alt="">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixqx=8uCHNjpfsv&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixqx=8uCHNjpfsv&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixqx=8uCHNjpfsv&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixqx=8uCHNjpfsv&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixqx=8uCHNjpfsv&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80" alt="">
                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80" alt="">
                </div>
                <p class="text-center text-sm text-skin-base font-normal">
                    {{ __("Rejoignez plus de 200 développeurs et designers. Parce qu’il y’a pas que le code dans la vie.") }}
                </p>
            </div>
            <div>

                <x-status-message />

                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="space-y-3">
                        <x-input id="name" name="name" autocomplete="name" required placeholder="{{ __('Nom complet') }}" aria-label="{{ __('Nom complet') }}" />
                        <x-email id="email" name="email" autocomplete="email" required placeholder="{{ __('Adresse E-mail') }}" aria-label="{{ __('Adresse E-mail') }}" />
                        <x-input id="username" name="username" autocomplete="current-password" required placeholder="{{ __('Pseudo') }}" aria-label="{{ __('Pseudo') }}" />
                        <x-password id="password" name="password" autocomplete="current-password" required placeholder="{{ __('Mot de passe (min. 6 caratères)') }}" aria-label="{{ __('Mot de passe') }}" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="opt_in" name="opt_in" type="checkbox" class="h-4 w-4 bg-skin-input text-green-600 focus:ring-green-500 border-skin-input rounded">
                            <label for="opt_in" class="ml-2 block text-sm text-skin-base font-normal">
                                {{ __('Je veux recevoir la newsletter') }}
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <x-heroicon-s-lock-closed class="h-5 w-5 text-green-500 group-hover:text-green-400" />
                            </span>
                            {{ __('Créer mon compte') }}
                        </button>
                    </div>
                </form>
            </div>

            @include('partials._socials-link')
        </div>
    </div>

@stop
