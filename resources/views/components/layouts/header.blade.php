<header
    x-data="{ scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 50)"
    :class="scrolled ? 'bg-white/80 backdrop-blur-lg dark:bg-gray-900/80' : 'bg-transparent backdrop-blur-none'"
    class="fixed inset-x-0 z-30 border-b border-dotted border-gray-200 dark:border-white/10 transition-all duration-300 ease-in-out"
>
    <div class="hidden items-center justify-center py-1.5 bg-primary-700 text-white text-sm xl:text-base">
        <x-link
            :href="route('sponsors')"
            class="group inline-flex items-center"
        >
            <span class="rounded-full bg-flag-green px-2 py-0.5 text-xs font-semibold uppercase leading-5 tracking-wide text-white">
                ⚡️ {{ __('pages/home.sponsor.title') }}
            </span>
            <span class="ml-4 hidden text-sm sm:block">
                {{ __('pages/home.sponsor.description') }}
            </span>
            <span class="ml-4 text-sm sm:hidden">
                {{ __('pages/home.sponsor.description_small') }}
            </span>
            <x-heroicon-s-chevron-right class="ml-2 size-5 text-white transition-all duration-300 ease-in-out group-hover:translate-x-1" aria-hidden="true" />
        </x-link>
    </div>
    <x-container>
        @if (isHolidayWeek())
            <div class="relative">
                <div class="absolute z-0 lg:left-1/4">
                    <img loading="lazy" src="{{ asset('images/decoration.gif') }}" class="w-auto h-10" alt="Christmas decoration">
                </div>
                <div class="absolute z-0 lg:right-12">
                    <img loading="lazy" src="{{ asset('images/decoration.gif') }}" class="w-auto h-10" alt="Christmas decoration">
                </div>
            </div>
        @endif

        <nav class="flex z-10 h-16 items-center justify-between">
            <div class="flex flex-1 items-center">
                <div class="flex shrink-0 items-center">
                    <x-link :href="route('home')" class="inline-flex items-center gap-1">
                        <x-brand.icon class="block h-7 w-auto sm:h-8" aria-hidden="true" />
                        @if (isHolidayWeek())
                            <div class="relative flex flex-col text-center group">
                                <x-icon.christmas-town class="w-auto h-8" aria-hidden="true" />
                                <span class="text-[11px] leading-3 font-mono font-medium opacity-0 transform transition-all duration-300 ease-in-out translate-y-1.5 text-gray-700 group-hover:translate-y-0 group-hover:opacity-100 dark:text-white">
                                    {{ __('global.holidays') }}
                                </span>
                            </div>
                        @endif
                    </x-link>
                </div>
                <div class="hidden ml-10 items-center gap-6 lg:flex">
                    @include('partials._navigation')
                </div>
            </div>

            <div x-data="{ open: false }" class="flex items-center gap-6">
                <!-- @ToDo: Replace with the command palette modal search -->
                <div class="hidden">
                    @include('partials._search')
                </div>

                <!-- Large screen authenticate links -->
                <div class="hidden items-center gap-6 lg:flex">
                    @guest
                        <x-nav.item
                            :href="route('login')"
                            :title="__('pages/auth.login.page_title')"
                        />
                        <x-buttons.primary :href="route('register')">
                            {{ __('pages/auth.register.page_title') }}
                        </x-buttons.primary>
                    @else
                        <x-nav.item :href="route('notifications')">
                            <x-slot:title>
                                <span class="sr-only">{{ __('global.view_notifications') }}</span>
                                <x-untitledui-bell class="size-5" aria-hidden="true" />
                                <livewire:components.notification-indicator />
                            </x-slot:title>
                        </x-nav.item>

                        <!-- @ToDo: Remove this component after added command palette modal search -->
                        <div class="hidden">
                            <x-launch-content />
                        </div>

                        <livewire:components.user-dropdown />
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center py-2 text-gray-400 hover:text-gray-500 dark:text-gray-400 focus:outline-hidden"
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
                        <div class="divide-y-2 divide-gray-50 rounded-xl bg-white shadow-md ring-1 ring-black/5 dark:bg-gray-800 dark:divide-white/10 dark:ring-white/10">
                            <div class="p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <x-brand class="h-9 w-auto text-gray-900 dark:text-white" aria-hidden="true" />
                                    </div>
                                    <div class="-mr-2">
                                        <button
                                            type="button"
                                            class="relative inline-flex items-center justify-center rounded-lg bg-white p-2 text-gray-400 dark:text-gray-500 dark:bg-gray-900 dark:hover:text-gray-400 dark:hover:bg-gray-800 hover:bg-gray-50 hover:text-gray-500 focus:outline-hidden focus:ring-2 focus:ring-inset focus:ring-primary-500"
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
                                    @php
                                        $user = \Illuminate\Support\Facades\Auth::user();
                                    @endphp

                                    <div class="flex items-center gap-2">
                                        <div class="shrink-0">
                                            <x-user.avatar :user="$user" class="size-8" />
                                        </div>
                                        <div class="leading-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $user->name }}
                                            </div>
                                            <div class="text-sm text-gray-400 dark:text-gray-500">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-6 flex flex-col space-y-4">
                                        <x-nav.item
                                            :href="route('profile', ['user' => $user->username])"
                                            :title="__('global.navigation.profile')"
                                        />
                                        <x-nav.item
                                            :href="route('settings')"
                                            :title="__('global.navigation.settings')"
                                        />
                                        <livewire:components.logout />
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
