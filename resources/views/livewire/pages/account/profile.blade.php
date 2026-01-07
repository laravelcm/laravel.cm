<div
    x-data="{
        tabSelected: 1,
        tabId: $id('tabs'),
        tabButtonClicked(tabButton) {
            this.tabSelected = tabButton.id.replace(this.tabId + '-', '')
            this.tabRepositionMarker(tabButton)
        },
        tabRepositionMarker(tabButton) {
            this.$refs.tabMarker.style.width = tabButton.offsetWidth + 'px'
            this.$refs.tabMarker.style.height = tabButton.offsetHeight + 'px'
            this.$refs.tabMarker.style.left = tabButton.offsetLeft + 'px'
        },
        tabContentActive(tabContent) {
            return (
                this.tabSelected ==
                tabContent.id.replace(this.tabId + '-content-', '')
            )
        },
    }"
    x-init="tabRepositionMarker($refs.tabButtons.firstElementChild)"
>
    <div class="line-b section-gradient pb-6 pt-20">
        <x-container>
            <div class="py-10 lg:flex lg:items-start lg:gap-8 lg:py-12">
                <x-user.avatar
                    :user="$user"
                    class="size-20 lg:size-28"
                />
                <div>
                    <h1 class="inline-flex items-center gap-2 text-2xl font-bold text-gray-900 dark:text-white">
                        <span class="font-heading">{{ $user->name }}</span>

                        @if ($user->isAdmin() || $user->isModerator())
                            <x-user.status />
                        @endif
                    </h1>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
                        {{ __('global.joined') }}
                        <time datetime="{{ $user->created_at->format('Y-m-d') }}">
                            {{ $user->created_at->diffForHumans() }}
                        </time>
                    </p>

                    @if ($user->location)
                        <div class="mt-1 text-sm flex items-center gap-2">
                            <h5 class="sr-only">{{ __('pages/account.account.location') }}</h5>
                            <x-untitledui-marker-pin-02 class="size-4 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                            <p class="text-gray-500 dark:text-gray-400">
                                {{ $user->location }}
                            </p>
                        </div>
                    @endif

                    @if ($user->bio)
                        <div class="mt-4">
                            <h5 class="sr-only">{{ __('pages/account.account.biography') }}</h5>
                            <p class="text-sm text-gray-700 max-w-lg dark:text-gray-300">
                                {{ $user->bio }}
                            </p>
                        </div>
                    @endif

                    @if ($user->githubUsername() || $user->twitter() || $user->linkedin() || $user->website)
                        <div class="mt-5 flex items-center gap-3">
                            @if ($user->githubUsername())
                                <a
                                    href="https://github.com/{{ $user->githubUsername() }}"
                                    target="_blank"
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                                >
                                    <span class="sr-only">Github</span>
                                    <x-icon.github class="size-5" aria-hidden="true" />
                                </a>
                            @endif

                            @if ($user->twitter())
                                <a
                                    href="https://twitter.com/{{ $user->twitter() }}"
                                    target="_blank"
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                                >
                                    <span class="sr-only">Twitter</span>
                                    <x-phosphor-x-logo-bold class="size-5" aria-hidden="true" />
                                </a>
                            @endif

                            @if ($user->linkedin())
                                <a
                                    href="https://www.linkedin.com/in/{{ $user->linkedin() }}"
                                    target="_blank"
                                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                                >
                                    <span class="sr-only">LinkedIn</span>
                                    <x-phosphor-linkedin-logo-fill class="size-5" aria-hidden="true" />
                                </a>
                            @endif

                            @if ($user->website)
                                <a
                                    href="{{ $user->website }}?utm_source=laravel.cm"
                                    target="_blank"
                                    class="text-sm text-gray-500 dark:text-gray-500 hover:text-gray-900 dark:hover:text-white"
                                >
                                    <span class="sr-only">{{ __('global.website') }}</span>
                                    <x-untitledui-globe class="size-5" stroke-width="1.5" aria-hidden="true" />
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div
                x-ref="tabButtons"
                class="relative inline-grid h-10 w-full select-none grid-cols-3 items-center justify-center rounded-lg bg-white ring-1 ring-gray-200 dark:ring-white/10 dark:bg-line-black p-1 text-gray-700 dark:text-gray-300 lg:max-w-sm"
            >
                @foreach([
                    __('global.navigation.articles'),
                    __('global.navigation.discussions'),
                    __('global.navigation.questions')
                ] as $tab)
                    <button
                        :id="$id(tabId)"
                        @click="tabButtonClicked($el)"
                        type="button"
                        class="relative z-20 inline-flex h-8 w-full cursor-pointer items-center justify-center whitespace-nowrap rounded-lg px-3 text-sm font-medium transition-all"
                    >
                        {{ $tab }}
                    </button>
                @endforeach
                <div x-ref="tabMarker" class="absolute left-0 z-10 h-full w-1/2 duration-300 ease-out" x-cloak>
                    <div class="size-full rounded-lg bg-gray-50 ring-1 ring-gray-100 dark:ring-white/10 dark:bg-gray-800 shadow-xs"></div>
                </div>
            </div>
        </x-container>
    </div>

    <x-container class="line-x px-0">
        <div class="px-4 py-10 lg:py-12 lg:grid lg:grid-cols-3 lg:gap-x-16">
            <div class="lg:col-span-2">
                <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)">
                    <x-user.articles :$user :articles="$this->articles" />
                </div>
                <div x-cloak :id="$id(tabId + '-content')" x-show="tabContentActive($el)">
                    <x-user.discussions :$user :discussions="$this->discussions" />
                </div>
                <div x-cloak :id="$id(tabId + '-content')" x-show="tabContentActive($el)">
                    <x-user.threads :$user :threads="$this->threads" />
                </div>
            </div>
            <aside class="hidden lg:block">
                <livewire:components.user.activities :$user />
            </aside>
        </div>
    </x-container>
</div>
