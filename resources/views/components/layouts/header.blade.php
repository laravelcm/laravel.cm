<header {{ $attributes->twMerge(['class' => 'relative z-10 backdrop-blur-sm bg-white lg:bg-transparent']) }}>
    <x-container>
        <nav class="flex h-16 items-center justify-between">
            <div class="flex flex-1 items-center">
                <div class="flex shrink-0 items-center">
                    <x-link href="{{ route('home') }}">
                        <x-brand.icon class="block h-8 w-auto sm:h-9" aria-hidden="true" />
                    </x-link>
                </div>
                <div class="hidden ml-10 items-center gap-6 lg:flex">
                    @include('partials._navigation')
                </div>
            </div>

            <div
                x-data="{ open: false }"
                @keydown.window.escape="open = false"
                class="flex items-center gap-4"
            >
                @include('partials._search')

                <!-- Large screen authenticate links -->
                <div class="hidden items-center gap-6 lg:flex">
                    @guest
                        <x-nav.item
                            :href="route('login')"
                            :title="__('pages/auth.login.page_title')"
                        />
                        <x-nav.item
                            :href="route('register')"
                            :title="__('pages/auth.register.page_title')"
                        />
                    @else
                        <x-nav.item :href="route('notifications')">
                            <x-slot:title>
                                <span class="sr-only">{{ __('global.view_notifications') }}</span>
                                <x-untitledui-bell class="size-5" aria-hidden="true" />
                                <livewire:notification-indicator />
                            </x-slot:title>
                        </x-nav.item>

                        <!-- Actions dropdown -->
                        <div
                            x-data="{ open: false }"
                            @keydown.escape.stop="open = false;"
                            @click.outside="open = false;"
                            class="relative ml-4 shrink-0"
                        >
                            <div>
                                <button
                                    type="button"
                                    class="shrink-0 rounded-full p-1 text-gray-400 hover:bg-gray-50 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-900"
                                    x-ref="button"
                                    @click="open =! open"
                                >
                                    <x-untitledui-plus class="size-5" aria-hidden="true" />
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
                                x-ref="menu"
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
                                        class="flex items-center px-3 py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:bg-skin-primary hover:text-white"
                                        role="menuitem"
                                        tabindex="-1"
                                    >
                                        Nouvel article
                                    </a>
                                    <a
                                        href="{{ route('forum.new') }}"
                                        class="flex items-center px-3 py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:bg-skin-primary hover:text-white"
                                        role="menuitem"
                                        tabindex="-1"
                                    >
                                        Nouveau sujet
                                    </a>
                                    <a
                                        href="{{ route('discussions.new') }}"
                                        class="flex items-center px-3 py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:bg-skin-primary hover:text-white"
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
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center py-2 text-gray-400 hover:text-gray-500 dark:text-gray-400 focus:outline-none"
                        aria-controls="mobile-menu"
                        @click="open = !open"
                        aria-expanded="false"
                        x-bind:aria-expanded="open.toString()"
                    >
                        <span class="sr-only">{{ __('global.open_navigation') }}</span>
                        <x-untitledui-menu-02 class="size-6" aria-hidden="true" />
                    </button>

                    <div
                        x-show="open"
                        x-transition:enter="duration-200 ease-out"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="duration-100 ease-in"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute inset-x-0 top-0 origin-top-right transform p-2 transition"
                        x-ref="panel"
                        @click.away="open = false"
                        style="display: none"
                    >
                        <div class="divide-y-2 divide-gray-50 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:ring-white/10">
                            <div class="p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <x-brand class="h-9 w-auto text-gray-900 dark:text-white" aria-hidden="true" />
                                    </div>
                                    <div class="-mr-2">
                                        <button
                                            type="button"
                                            class="relative inline-flex items-center justify-center rounded-lg bg-white p-2 text-gray-400 dark:text-gray-500 dark:hover:text-gray-400 dark:hover:bg-gray-800 hover:bg-gray-50 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500"
                                            @click="open = false;"
                                        >
                                            <span class="absolute -inset-0.5"></span>
                                            <span class="sr-only">{{ __('global.close_navigation') }}</span>
                                            <x-untitledui-x class="size-6" aria-hidden="true" />
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-5 flex flex-col space-y-4">
                                    @include('partials._navigation')
                                </div>
                            </div>
                            <div class="p-4">
                                @auth
                                    <div class="flex items-center px-4">
                                        <div class="shrink-0">
                                            <img
                                                class="size-10 rounded-full"
                                                src="{{ Auth::user()->profile_photo_url }}"
                                                alt="{{ Auth::user()->name }}"
                                            />
                                        </div>
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ Auth::user()->name }}
                                            </div>
                                            <div class="text-sm text-gray-400 dark:text-gray-500">
                                                {{ Auth::user()->email }}
                                            </div>
                                        </div>
                                        <button
                                            class="ml-auto shrink-0 rounded-full bg-skin-card p-1 text-skin-muted hover:text-gray-500 dark:text-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                        >
                                            <span class="sr-only">{{ __('global.view_notifications') }}</span>
                                            <x-untitledui-bell class="size-6" aria-hidden="true" />
                                        </button>
                                    </div>
                                    <div class="mt-3 space-y-1">
                                        <x-nav.item
                                            :href="route('profile')"
                                            class="block px-4 py-2 font-medium text-gray-500 hover:text-gray-700"
                                        >
                                            Mon profil
                                        </x-nav.item>
                                        <a
                                            href="{{ route('user.settings') }}"
                                            class="block px-4 py-2 font-medium text-gray-500 hover:text-gray-700"
                                        >
                                            Paramètres
                                        </a>
                                        <div class="px-4 py-2" role="form">
                                            <form method="POST" action="{{ route('logout') }}" role="form">
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="group flex w-full items-center font-medium text-gray-500 hover:text-gray-400 dark:text-gray-400 dark:hover:text-white"
                                                    role="menuitem"
                                                    tabindex="-1"
                                                    id="logout-mobile"
                                                >
                                                    {{ __('global.logout') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col space-y-4">
                                        <x-nav.item
                                            :href="route('login')"
                                            :title="__('pages/auth.login.page_title')"
                                        />
                                        <x-nav.item
                                            href="{{ route('register') }}"
                                            :title="__('pages/auth.register.page_title')"
                                        />
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </x-container>
</header>
