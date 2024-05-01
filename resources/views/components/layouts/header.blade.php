<nav
    x-data="{ open: false, flyoutMenu: false }"
    {{ $attributes->twMerge(['class' => 'relative z-10 bg-skin-menu/50 backdrop-blur-sm']) }}
>
    <div class="mx-auto max-w-7xl px-2 sm:px-4">
        <div class="flex h-16 justify-between">
            <div class="flex px-2 lg:px-0">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('home') }}">
                        <x-application-icon class="block h-8 w-auto sm:h-9" />
                    </a>
                </div>
                <div class="hidden font-sans lg:ml-10 lg:flex lg:items-center lg:space-x-6">
                    <a
                        href="{{ route('forum.index') }}"
                        class="{{ active(['forum', 'forum*'], 'text-skin-primary hover:text-skin-primary-hover', 'text-skin-menu hover:text-skin-menu-hover') }} inline-flex items-center px-1 text-sm font-medium"
                    >
                        Forum
                    </a>
                    <a
                        href="{{ route('articles') }}"
                        class="{{ active(['articles', 'articles*'], 'text-skin-primary hover:text-skin-primary-hover', 'text-skin-menu hover:text-skin-menu-hover') }} inline-flex items-center px-1 text-sm font-medium"
                    >
                        Articles
                    </a>
                    <a
                        href="{{ route('discussions.index') }}"
                        class="{{ active(['discussions', 'discussions*'], 'text-skin-primary hover:text-skin-primary-hover', 'text-skin-menu hover:text-skin-menu-hover') }} inline-flex items-center px-1 text-sm font-medium"
                    >
                        Discussions
                    </a>
                    <div class="relative mt-1.5 px-1">
                        <button
                            @click="flyoutMenu =! flyoutMenu"
                            type="button"
                            class="group inline-flex items-center rounded-md font-medium text-skin-menu hover:text-skin-menu-hover focus:outline-none focus:ring-0"
                            :class="{ 'text-skin-menu-hover': flyoutMenu, 'text-skin-menu': !(flyoutMenu) }"
                        >
                            <x-untitledui-dots-horizontal class="h-5 w-5" />
                        </button>
                        <div
                            x-show="flyoutMenu"
                            x-transition:enter="transition duration-200 ease-out"
                            x-transition:enter-start="translate-y-1 opacity-0"
                            x-transition:enter-end="translate-y-0 opacity-100"
                            x-transition:leave="transition duration-150 ease-in"
                            x-transition:leave-start="translate-y-0 opacity-100"
                            x-transition:leave-end="translate-y-1 opacity-0"
                            class="absolute z-10 -ml-4 mt-3 w-screen max-w-md transform lg:left-1/2 lg:ml-0 lg:max-w-3xl lg:-translate-x-1/2"
                            x-ref="panel"
                            @click.outside="flyoutMenu = false"
                            style="display: none"
                        >
                            <div class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="relative grid gap-6 bg-skin-card px-5 py-6 sm:gap-8 sm:p-8 lg:grid-cols-2">
                                    <a
                                        href="https://snippets.laravel.cm"
                                        class="-m-3 flex items-start rounded-lg p-3 hover:bg-skin-card-muted"
                                    >
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-green-500 text-white sm:h-12 sm:w-12"
                                        >
                                            <x-untitledui-brackets class="h-6 w-6" />
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-sans text-base font-medium text-skin-inverted">Snippets</p>
                                            <p class="mt-1 text-sm font-normal text-skin-base">
                                                Créer et partagez des codes sources publiquement accessibles par tous.
                                            </p>
                                        </div>
                                    </a>

                                    <a
                                        href="{{ route('rules') }}"
                                        class="-m-3 flex items-start rounded-lg p-3 hover:bg-skin-card-muted"
                                    >
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-green-500 text-white sm:h-12 sm:w-12"
                                        >
                                            <x-untitledui-book-open class="h-6 w-6" />
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-sans text-base font-medium text-skin-inverted">Guides</p>
                                            <p class="mt-1 text-sm font-normal text-skin-base">
                                                Découvrez le code de conduite pour l’utilisation du site.
                                            </p>
                                        </div>
                                    </a>

                                    <a href="#" class="-m-3 flex items-start rounded-lg p-3 hover:bg-skin-card-muted">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-green-500 text-white sm:h-12 sm:w-12"
                                        >
                                            <x-untitledui-microphone class="h-6 w-6" />
                                        </div>
                                        <div class="ml-4">
                                            <p
                                                class="inline-flex items-center font-sans text-base font-medium text-skin-inverted"
                                            >
                                                Podcasts
                                                <x-soon />
                                            </p>
                                            <p class="mt-1 text-sm font-normal text-skin-base">
                                                Toutes les discussions sur le développement de Laravel et PHP.
                                            </p>
                                        </div>
                                    </a>

                                    <a href="#" class="-m-3 flex items-start rounded-lg p-3 hover:bg-skin-card-muted">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-green-500 text-white sm:h-12 sm:w-12"
                                        >
                                            <x-untitledui-check-verified-02 class="h-6 w-6" />
                                        </div>
                                        <div class="ml-4">
                                            <p
                                                class="inline-flex items-center font-sans text-base font-medium text-skin-inverted"
                                            >
                                                Badges
                                                <x-soon />
                                            </p>
                                            <p class="mt-1 text-sm font-normal text-skin-base">
                                                Obtenez des badges et débloquez différentes fonctionnalités.
                                            </p>
                                        </div>
                                    </a>

                                    <a href="#" class="-m-3 flex items-start rounded-lg p-3 hover:bg-skin-card-muted">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-gradient-to-br from-flag-yellow to-flag-red text-white sm:h-12 sm:w-12"
                                        >
                                            <svg
                                                class="h-6 w-6"
                                                fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M23 9.04c0-1.249-1.051-2.27-2.335-2.27-1.285 0-2.336 1.021-2.336 2.27 0 .703.35 1.36.888 1.77l-3.083 2.29-2.99-3.857c.724-.386 1.215-1.135 1.215-1.975C14.359 6.021 13.308 5 12.023 5 10.74 5 9.688 6.021 9.688 7.27c0 .839.467 1.588 1.191 1.974L7.633 13.1 4.76 10.832c.537-.408.91-1.066.91-1.793 0-1.248-1.05-2.269-2.335-2.269C2.051 6.77 1 7.791 1 9.04c0 1.111.817 2.042 1.915 2.223l1.121 5.696v2.36c0 .386.304.681.7.681h14.527c.397 0 .7-.295.7-.68v-2.36l1.122-5.697C22.183 11.082 23 10.151 23 9.04zm-2.335-.908c.513 0 .934.408.934.907 0 .5-.42.908-.934.908s-.935-.408-.935-.908c0-.499.42-.907.934-.907zM12 6.339c.514 0 .934.408.934.908 0 .499-.42.907-.934.907s-.934-.408-.934-.907c0-.5.42-.908.934-.908zm-4.18 8.396a.727.727 0 0 0 .467-.25l3.69-4.47 3.456 4.448c.117.136.28.25.467.272a.683.683 0 0 0 .514-.136l3.036-2.247-.77 3.858H5.32l-.747-3.79 2.733 2.156c.14.114.327.182.514.16zM2.4 9.04c0-.499.42-.907.934-.907s.935.408.935.907c0 .5-.42.908-.935.908-.513 0-.934-.408-.934-.908zm3.036 9.6v-1.067h13.126v1.066H5.437z"
                                                />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-sans text-base font-medium text-yellow-500">
                                                Devenez Premium
                                            </p>
                                            <p class="mt-1 text-sm font-normal text-skin-base">
                                                Devenez prémium et soutenez la production de contenu du site.
                                            </p>
                                        </div>
                                    </a>

                                    <a href="#" class="-m-3 flex items-start rounded-lg p-3 hover:bg-skin-card-muted">
                                        <div
                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-green-500 text-white sm:h-12 sm:w-12"
                                        >
                                            <x-heroicon-o-briefcase class="h-6 w-6" />
                                        </div>
                                        <div class="ml-4">
                                            <p
                                                class="inline-flex items-center font-sans text-base font-medium text-skin-inverted"
                                            >
                                                Jobs
                                                <x-soon />
                                            </p>
                                            <p class="mt-1 text-sm font-normal text-skin-base">
                                                Les offres pour développeurs PHP & Laravel dans la zone CEMAC.
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-1 items-center justify-center px-2 lg:ml-6 lg:justify-end">
                @include('partials._search')
            </div>
            <div class="flex items-center lg:hidden">
                <!-- Mobile menu button -->
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-md p-2 text-skin-muted hover:text-skin-base focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500"
                    aria-controls="mobile-menu"
                    @click="open = !open"
                    aria-expanded="false"
                    x-bind:aria-expanded="open.toString()"
                >
                    <span class="sr-only">Open main menu</span>
                    <svg
                        class="block h-6 w-6"
                        :class="{ 'hidden': open, 'block': !(open) }"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                    <svg
                        class="hidden h-6 w-6"
                        :class="{ 'block': open, 'hidden': !(open) }"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:ml-6 lg:flex lg:items-center">
                @auth
                    <a
                        href="{{ route('notifications') }}"
                        class="relative shrink-0 rounded-full p-1 text-skin-muted hover:bg-skin-body hover:text-skin-base focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                    >
                        <span class="sr-only">Voir les notifications</span>
                        <x-untitledui-bell class="h-5 w-5" />
                        <livewire:notification-indicator />
                    </a>

                    <!-- Add actions dropdown -->
                    <div
                        x-data="{ open: false }"
                        @keydown.escape.stop="open = false;"
                        @click.outside="open = false;"
                        class="relative ml-4 shrink-0"
                    >
                        <div>
                            <button
                                type="button"
                                class="shrink-0 rounded-full p-1 text-skin-muted hover:bg-skin-card hover:text-skin-base focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                                x-ref="button"
                                @click="open =! open"
                            >
                                <x-untitledui-plus class="h-5 w-5" />
                            </button>
                        </div>

                        <div
                            x-show="open"
                            x-transition:enter="transition duration-100 ease-out"
                            x-transition:enter-start="scale-95 transform opacity-0"
                            x-transition:enter-end="scale-100 transform opacity-100"
                            x-transition:leave="transition duration-75 ease-in"
                            x-transition:leave-start="scale-100 transform opacity-100"
                            x-transition:leave-end="scale-95 transform opacity-0"
                            class="absolute right-0 mt-2 w-56 origin-top divide-y divide-skin-light rounded-md bg-skin-menu py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            x-ref="menu-items"
                            role="menu"
                            aria-orientation="vertical"
                            aria-labelledby="menu-button"
                            tabindex="-1"
                            @keydown.tab="open = false"
                            @keydown.enter.prevent="open = false;"
                            @keyup.space.prevent="open = false;"
                            style="display: none"
                        >
                            <div class="py-1" role="none">
                                <a
                                    href="{{ route('articles.new') }}"
                                    class="flex items-center px-3 py-1.5 text-sm font-normal text-skin-base hover:bg-skin-primary hover:text-white"
                                    role="menuitem"
                                    tabindex="-1"
                                >
                                    Nouvel article
                                </a>
                                <a
                                    href="{{ route('forum.new') }}"
                                    class="flex items-center px-3 py-1.5 text-sm font-normal text-skin-base hover:bg-skin-primary hover:text-white"
                                    role="menuitem"
                                    tabindex="-1"
                                >
                                    Nouveau sujet
                                </a>
                                <a
                                    href="{{ route('discussions.new') }}"
                                    class="flex items-center px-3 py-1.5 text-sm font-normal text-skin-base hover:bg-skin-primary hover:text-white"
                                    role="menuitem"
                                    tabindex="-1"
                                >
                                    Nouvelle discussion
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile dropdown -->
                    <x-dropdown-profile />
                @else
                    <div class="relative flex items-center space-x-6 font-sans">
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center text-sm font-medium text-skin-menu hover:text-skin-menu-hover"
                        >
                            Se connecter
                        </a>
                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center text-sm font-medium text-flag-green"
                        >
                            Créer un compte
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div x-show="open" class="font-sans lg:hidden" id="mobile-menu" style="display: none">
        <div class="space-y-1 pb-3 pt-2">
            <a
                href="{{ route('forum.index') }}"
                class="hover:border-skin {{ active(['forum', 'forum*'], 'bg-green-50 border-green-500 text-skin-primary', 'text-skin-menu hover:text-skin-menu-hover') }} block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium hover:bg-skin-card-muted"
            >
                Forum
            </a>
            <a
                href="{{ route('articles') }}"
                class="hover:border-skin {{ active(['articles', 'articles*'], 'bg-green-50 border-green-500 text-skin-primary', 'text-skin-menu hover:text-skin-menu-hover') }} block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium hover:bg-skin-card-muted"
            >
                Articles
            </a>
            <a
                href="{{ route('discussions.index') }}"
                class="hover:border-skin {{ active(['discussions', 'discussions*'], 'bg-green-50 border-green-500 text-skin-primary', 'text-skin-menu hover:text-skin-menu-hover') }} block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium hover:bg-skin-card-muted"
            >
                Discussions
            </a>
        </div>
        <div class="border-skin-light border-t px-3 py-4">
            <h4 class="text-sm font-medium uppercase leading-5 tracking-wide text-skin-muted">Autres</h4>
            <div class="mt-5 space-y-6">
                <a href="https://snippets.laravel.cm" class="flex items-center text-skin-base">
                    <x-untitledui-brackets class="mr-2 h-6 w-6" />
                    Snippets
                </a>

                <a href="{{ route('rules') }}" class="flex items-center text-skin-base">
                    <x-untitledui-bookmark class="-ml-1 mr-3 h-6 w-6" />
                    Guides
                </a>

                <a href="#" class="flex items-center text-skin-base">
                    <x-untitledui-microphone class="mr-2 h-6 w-6" />
                    Podcasts
                    <x-soon />
                </a>

                <a href="#" class="flex items-center text-skin-base">
                    <x-untitledui-check-verified-02 class="mr-2 h-6 w-6" />
                    Badges
                    <x-soon />
                </a>

                <a href="#" class="flex items-center text-yellow-500 hover:text-yellow-600">
                    <svg
                        class="mr-2 h-6 w-6"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M23 9.04c0-1.249-1.051-2.27-2.335-2.27-1.285 0-2.336 1.021-2.336 2.27 0 .703.35 1.36.888 1.77l-3.083 2.29-2.99-3.857c.724-.386 1.215-1.135 1.215-1.975C14.359 6.021 13.308 5 12.023 5 10.74 5 9.688 6.021 9.688 7.27c0 .839.467 1.588 1.191 1.974L7.633 13.1 4.76 10.832c.537-.408.91-1.066.91-1.793 0-1.248-1.05-2.269-2.335-2.269C2.051 6.77 1 7.791 1 9.04c0 1.111.817 2.042 1.915 2.223l1.121 5.696v2.36c0 .386.304.681.7.681h14.527c.397 0 .7-.295.7-.68v-2.36l1.122-5.697C22.183 11.082 23 10.151 23 9.04zm-2.335-.908c.513 0 .934.408.934.907 0 .5-.42.908-.934.908s-.935-.408-.935-.908c0-.499.42-.907.934-.907zM12 6.339c.514 0 .934.408.934.908 0 .499-.42.907-.934.907s-.934-.408-.934-.907c0-.5.42-.908.934-.908zm-4.18 8.396a.727.727 0 0 0 .467-.25l3.69-4.47 3.456 4.448c.117.136.28.25.467.272a.683.683 0 0 0 .514-.136l3.036-2.247-.77 3.858H5.32l-.747-3.79 2.733 2.156c.14.114.327.182.514.16zM2.4 9.04c0-.499.42-.907.934-.907s.935.408.935.907c0 .5-.42.908-.935.908-.513 0-.934-.408-.934-.908zm3.036 9.6v-1.067h13.126v1.066H5.437z"
                        />
                    </svg>
                    Devenez Prémium
                    <x-soon />
                </a>

                <a href="#" class="flex items-center text-skin-base">
                    <x-heroicon-o-briefcase class="-ml-1 mr-3 h-6 w-6" />
                    Jobs
                    <x-soon />
                </a>
            </div>
        </div>
        <div class="border-skin-light border-t pb-3 pt-4">
            @auth
                <div class="flex items-center px-4">
                    <div class="shrink-0">
                        <img
                            class="h-10 w-10 rounded-full"
                            src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}"
                        />
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-skin-inverted">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-skin-muted">{{ Auth::user()->email }}</div>
                    </div>
                    <button
                        class="ml-auto shrink-0 rounded-full bg-skin-card p-1 text-skin-muted hover:text-skin-base focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    >
                        <span class="sr-only">Voir les notifications</span>
                        <x-untitledui-bell class="h-6 w-6" />
                    </button>
                </div>
                <div class="mt-3 space-y-1">
                    <a
                        href="{{ route('profile') }}"
                        class="block px-4 py-2 text-base font-medium text-skin-menu hover:text-skin-menu-hover"
                    >
                        Mon profil
                    </a>
                    <a
                        href="{{ route('user.settings') }}"
                        class="block px-4 py-2 text-base font-medium text-skin-menu hover:text-skin-menu-hover"
                    >
                        Paramètres
                    </a>
                    <div class="px-4 py-2" role="form">
                        <form method="POST" action="{{ route('logout') }}" role="form">
                            @csrf
                            <button
                                type="submit"
                                class="group flex w-full items-center text-base font-medium text-skin-base hover:text-skin-menu-hover"
                                role="menuitem"
                                tabindex="-1"
                                id="logout-mobile"
                            >
                                Se déconnecter
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="space-y-1">
                    <a
                        href="{{ route('login') }}"
                        class="block px-4 py-2 text-base font-medium text-skin-menu hover:text-skin-menu-hover"
                    >
                        Se connecter
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-flag-green">
                        Créer un compte
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
