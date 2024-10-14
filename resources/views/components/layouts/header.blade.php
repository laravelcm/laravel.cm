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
                                    <div class="flex items-center gap-2">
                                        <div class="shrink-0">
                                            <x-user.avatar
                                                :user="\Illuminate\Support\Facades\Auth::user()"
                                                class="size-8"
                                            />
                                        </div>
                                        <div class="leading-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ \Illuminate\Support\Facades\Auth::user()->name }}
                                            </div>
                                            <div class="text-sm text-gray-400 dark:text-gray-500">
                                                {{ \Illuminate\Support\Facades\Auth::user()->email }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex flex-col space-y-4">
                                        <x-nav.item
                                            :href="route('profile')"
                                            :title="__('Mon profil')"
                                        />
                                        <x-nav.item
                                            :href="route('user.settings')"
                                            :title="__('Paramètres')"
                                        />
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="group flex w-full items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white"
                                                role="menuitem"
                                                tabindex="-1"
                                                id="logout-mobile"
                                            >
                                                {{ __('global.logout') }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="flex flex-col space-y-4">
                                        <x-nav.item
                                            :href="route('login')"
                                            :title="__('pages/auth.login.page_title')"
                                        />
                                        <x-nav.item
                                            :href="route('register')"
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
