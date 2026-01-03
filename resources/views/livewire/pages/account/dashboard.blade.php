<div class="section-gradient">
    <x-container class="px-0 pt-20 pb-16 lg:pt-28 lg:line-x">
        <header class="px-4">
            <h1 class="text-xl font-bold font-heading text-gray-900 dark:text-white sm:text-2xl">
                {{ __('global.navigation.dashboard') }}
            </h1>
            <x-user.stats :user="$this->user" />
        </header>

        <section class="relative mt-8 lg:border-t lg:border-line lg:flex">
            <div class="border-y border-line lg:w-64 lg:border-y-0 lg:border-r">
                <nav class="flex flex-row overflow-x-scroll sticky top-16 lg:flex-col lg:space-y-1">
                    <x-nav.forum-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')"
                        icon="untitledui-file-05"
                        class="border-y-0 lg:border-b"
                    >
                        {{ __('pages/article.my_article') }}
                    </x-nav.forum-link>
                    <x-nav.forum-link
                        :href="route('account.password')"
                        :active="request()->routeIs('dashboard.discussions')"
                        wire:current="border-line text-gray-900 bg-gray-50 dark:bg-white/10 dark:text-white"
                        icon="untitledui-message-chat-square"
                        class="border-y-0 lg:border-y"
                    >
                        {{ __('pages/discussion.my_discussion') }}
                    </x-nav.forum-link>
                    <x-nav.forum-link
                        :href="route('account.preferences')"
                        :active="request()->routeIs('account.preferences')"
                        wire:current="border-line text-gray-900 bg-gray-50 dark:bg-white/10 dark:text-white"
                        icon="untitledui-file-02"
                        class="border-y-0 lg:border-y"
                    >
                        {{ __('pages/forum.my_thread') }}
                    </x-nav.forum-link>
                </nav>
            </div>

            <div class="mt-4 px-4 overflow-hidden line-b lg:mt-0 lg:flex-1">
                <livewire:components.user.articles />

                {{--<div x-cloak x-show="activeTab === 'discussions'">
                    <livewire:components.user.discussions />
                </div>
                <div x-cloak x-show="activeTab === 'sujets'">
                    <livewire:components.user.threads />
                </div>--}}
            </div>
        </section>
    </x-container>
</div>
