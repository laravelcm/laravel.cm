<div @keydown.escape.stop="open = false;" @click.outside="open = false;" class="relative">
    <div>
        <button
            type="button"
            class="flex rounded-full bg-skin-menu text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            id="user-menu-button"
            x-ref="button"
            @click="open =! open"
            aria-expanded="false"
            aria-haspopup="true"
            x-bind:aria-expanded="open.toString()"
        >
            <span class="sr-only">{{ __('global.open_navigation') }}</span>
            <x-user.avatar :user="Auth::user()" class="size-8" />
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
        class="absolute right-0 mt-2 w-60 origin-top-right divide-y divide-skin-light rounded-md bg-skin-menu py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        x-ref="menu"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="user-menu-button"
        tabindex="-1"
        @keydown.tab="open = false"
        @keydown.enter.prevent="open = false;"
        @keyup.space.prevent="open = false;"
        style="display: none"
    >
        <div class="px-3.5 py-3" role="none">
            <p class="text-xs font-normal text-gray-500 dark:text-gray-400" role="none">Connecté en tant que</p>
            <p class="truncate text-sm font-medium text-gray-900" role="none">
                {{ Auth::user()->email }}
            </p>
        </div>

        @if (Auth::user()->hasRole(['admin', 'moderator']))
            <div class="px-3.5 py-1.5" role="none">
                <a
                    href="{{ route('filament.admin.pages.dashboard') }}"
                    class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                    role="menuitem"
                    tabindex="-1"
                    id="user-menu-item-0"
                >
                    <x-untitledui-monitor
                        class="mr-3 size-5 flex-none text-skin-muted group-hover:text-primary-600"
                    />
                    Administration
                </a>
            </div>
        @endif

        @feature('job_profile')
            <div class="px-3.5 py-2" role="none">
                <div class="flex items-center justify-between">
                    <h5 class="text-sm leading-5 text-gray-500 dark:text-gray-400">Profil Développeur</h5>
                    <span
                        class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-800"
                    >
                        <svg class="mr-1.5 h-2 w-2 text-orange-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                        </svg>
                        Off
                    </span>
                </div>
                <div class="5 py-1">
                    <a
                        href="#"
                        class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >
                        <x-icon.user-edit
                            class="mr-3 size-5 flex-none text-skin-muted group-hover:text-primary-600"
                        />
                        Mon compte
                    </a>
                    <a
                        href="#"
                        class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >
                        <x-icon.file-attachment
                            class="mr-3 size-5 flex-none text-skin-muted group-hover:text-primary-600"
                        />
                        Mes candidatures
                    </a>
                    <a
                        href="#"
                        class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >
                        <x-icon.clipboard-document
                            class="mr-3 size-5 flex-none text-skin-muted group-hover:text-primary-600"
                        />
                        Mes compétences
                    </a>
                    <a
                        href="#"
                        class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >
                        <x-icon.adjustments
                            class="mr-3 size-5 flex-none text-skin-muted group-hover:text-primary-600"
                        />
                        Préférences
                    </a>
                </div>
                <div class="my-2 rounded-md border border-skin-base px-3 py-2.5">
                    <h6 class="inline-flex items-center text-sm font-medium leading-5 text-gray-700 dark:text-gray-300">
                        Profil incomplet !
                        <svg
                            class="ml-1.5 size-4 text-sky-500"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </h6>
                    <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">
                        Nous avons besoin de plus d'informations pour vous mettre en relation avec les entreprises.
                    </p>
                    <a
                        href="#"
                        class="mt-3 inline-block w-full rounded-md border border-skin-base px-1.5 py-2 text-center text-sm font-medium leading-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-300"
                    >
                        Compléter mon profil
                    </a>
                </div>
            </div>
        @endfeature

        <div class="px-3.5 py-1.5" role="none">
            <a
                href="{{ route('dashboard') }}"
                class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                role="menuitem"
                tabindex="-1"
                id="user-menu-item-0"
            >
                <x-untitledui-grid class="mr-3 size-5 flex-none text-skin-muted group-hover:text-primary-600" />
                Tableau de bord
            </a>
            <a
                href="{{ route('profile') }}"
                class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                role="menuitem"
                tabindex="-1"
                id="user-menu-item-1"
            >
                <x-untitledui-user-circle
                    class="mr-3 size-5 flex-none text-skin-muted group-hover:text-primary-600"
                />
                Mon profil
            </a>
            <a
                href="{{ route('user.settings') }}"
                class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                role="menuitem"
                tabindex="-1"
                id="user-menu-item-2"
            >
                <x-untitledui-sliders class="mr-3 size-5 flex-none text-skin-muted group-hover:text-primary-600" />
                Paramètres
            </a>
            <form method="POST" action="{{ route('logout') }}" role="form">
                @csrf
                <button
                    type="submit"
                    class="group flex w-full items-center py-1.5 text-left text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                    role="menuitem"
                    tabindex="-1"
                    id="logout"
                >
                    <x-icon.logout class="mr-3 size-5 flex-none text-skin-muted group-hover:text-primary-600" />
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</div>
