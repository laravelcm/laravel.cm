<x-app-layout>
    <div class="relative isolate">
        <x-container class="mx-auto max-w-3xl py-16 sm:pt-32 lg:pb-20 lg:pt-40">
            <div class="flex justify-center">
                <x-link
                    :href="route('sponsors')"
                    class="inline-flex items-center rounded-full bg-green-700 p-1 pr-2 text-white sm:text-base lg:text-sm xl:text-base"
                >
                    <span class="rounded-full bg-flag-green px-3 py-0.5 text-xs font-semibold uppercase leading-5 tracking-wide text-white">
                        ⚡️ {{ __('pages/home.sponsor.title') }}
                    </span>
                    <span class="ml-4 hidden text-sm sm:block">
                        {{ __('pages/home.sponsor.description') }}
                    </span>
                    <span class="ml-4 text-sm sm:hidden">
                        {{ __('pages/home.sponsor.description_small') }}
                    </span>
                    <x-heroicon-s-chevron-right class="ml-2 size-5 text-white" aria-hidden="true" />
                </x-link>
            </div>
            <div class="mt-10 text-center">
                <h1 class="font-heading text-4xl font-medium tracking-tight text-primary-600 sm:leading-none lg:text-6xl">
                    {{ __('global.site_name') }}
                </h1>
                <p class="mt-3 text-base text-gray-700 dark:text-white sm:mt-5 sm:text-lg">
                    {{ __('global.site_description') }}
                </p>
                <div class="mt-10 gap-4 sm:flex sm:items-center sm:justify-center">
                    @auth
                        <x-buttons.primary :href="route('forum.index')" class="w-full sm:w-auto">
                            {{ __('actions.new_thread') }}
                        </x-buttons.primary>
                    @else
                        <x-buttons.primary :href="route('login')" class="w-full sm:w-auto">
                            {{ __('pages/home.join_community') }}
                        </x-buttons.primary>
                    @endauth
                    <x-buttons.default :href="route('forum.index')" class="mt-4 w-full sm:mt-0 sm:w-auto">
                        {{ __('pages/home.visit_forum') }}
                    </x-buttons.default>
                </div>
            </div>
        </x-container>

        <x-join-sponsors :title="__('pages/home.work_associations')" />
    </div>

    <x-container>
        <div class="divide-y divide-gray-200 dark:divide-white/10">
            <div class="py-12 lg:py-20">
                <x-section-header
                    :title="__('pages/home.popular_posts.title')"
                    :content="__('pages/home.popular_posts.description')"
                />
                <div
                    class="mx-auto mt-8 grid max-w-xl gap-10 lg:mt-10 lg:max-w-none lg:grid-flow-col lg:grid-cols-2 lg:grid-rows-3 lg:gap-x-12"
                >
                    @foreach ($latestArticles as $article)
                        @if ($loop->first)
                            <div class="lg:row-span-3">
                                <x-articles.card :article="$article" :icon-link="true" />
                            </div>
                        @else
                            <div class="lg:col-span-2">
                                <x-articles.card :article="$article" is-summary />
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="mt-10 flex items-center justify-center sm:mt-12 xl:mt-16">
                    <x-buttons.primary :href="route('articles.index')" class="gap-2">
                        {{ __('pages/home.view_posts') }}
                        <x-heroicon-o-arrow-long-right class="size-5" aria-hidden="true" />
                    </x-buttons.primary>
                </div>
            </div>

            @if ($latestThreads->isNotEmpty())
                <div class="py-12 lg:py-20">
                    <x-section-header :title="__('pages/home.threads.title')" :content="__('pages/home.threads.description')" />

                    <div class="mt-10 grid gap-10 lg:mt-12 lg:grid-cols-2 lg:gap-x-5 lg:gap-y-12">
                        @foreach ($latestThreads as $thread)
                            <div>
                                <div class="flex items-center text-gray-500 dark:text-gray-400">
                                    <x-link
                                        :href="route('profile', $thread->user->username)"
                                        class="inline-flex items-center hover:underline"
                                    >
                                        <x-user.avatar
                                            :user="$thread->user"
                                            class="size-6"
                                            container="mr-1.5"
                                            span="-right-1 -top-1 size-4 ring-1"
                                        />
                                        <span>{{ '@' . $thread->user->username }}</span>
                                    </x-link>
                                    <span class="mx-1.5 inline-flex gap-1.5">
                                        <span>{{ __('global.ask') }}</span>
                                        <time-ago time="{{ $thread->created_at->getTimestamp() }}" />
                                    </span>
                                </div>
                                <x-link :href="route('forum.show', $thread)" class="mt-3 block">
                                    <p class="text-xl font-medium text-gray-900 dark:text-white">
                                        {{ $thread->subject() }}
                                    </p>
                                    <p class="mt-3 text-gray-500 dark:text-gray-400">
                                        {!! $thread->excerpt() !!}
                                    </p>
                                </x-link>
                                <div class="mt-3">
                                    <x-link
                                        :href="route('forum.show', $thread)"
                                        class="font-medium text-green-600 hover:text-green-500 hover:underline"
                                    >
                                        {{ __('pages/home.threads.show') }}
                                    </x-link>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10 flex items-center justify-center sm:mt-12 xl:mt-16">
                        <x-buttons.primary :href="route('forum.index')" class="gap-2">
                            {{ __('pages/home.threads.show_all') }}
                            <x-heroicon-o-arrow-long-right class="size-5" aria-hidden="true" />
                        </x-buttons.primary>
                    </div>
                </div>
            @endif

            <div class="py-12 lg:py-20">
                <x-section-header :title="__('pages/home.discussions.title')" :content="__('pages/home.discussions.description')" />

                <div class="mt-8 grid gap-8 md:grid-cols-3 md:gap-x-10 lg:mt-12">
                    @foreach ($latestDiscussions as $discussion)
                        <div>
                            <div class="relative flex items-center gap-1 text-sm text-gray-400 dark:text-gray-500">
                                <x-user.avatar
                                    :user="$discussion->user"
                                    class="size-6"
                                    container="mr-1.5"
                                    span="-right-1 -top-1 size-4 ring-1"
                                />
                                <x-link
                                    :href="route('profile', $discussion->user->username)"
                                    class="text-gray-900 hover:underline dark:text-white"
                                >
                                    {{ $discussion->user->name }}
                                    <span class="absolute inset-0"></span>
                                </x-link>
                                <span aria-hidden="true">&middot;</span>
                                <time-ago time="{{ $discussion->created_at->getTimestamp() }}" />
                            </div>
                            <x-link :href="route('discussions.show', $discussion)" class="mt-2 block">
                                <p class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ $discussion->title }}
                                </p>
                                <p class="mt-3 text-gray-500 dark:text-gray-400">
                                    {!! $discussion->excerpt() !!}
                                </p>
                            </x-link>
                            <div class="mt-3">
                                <x-link
                                    :href="route('discussions.show', $discussion)"
                                    class="font-medium text-flag-green hover:text-green-500 hover:underline"
                                >
                                    {{ __('pages/home.discussions.read') }}
                                </x-link>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10 flex items-center justify-center sm:mt-12 xl:mt-16">
                    <x-buttons.primary :href="route('discussions.index')" class="gap-2">
                        {{ __('pages/home.discussions.show_all') }}
                        <x-heroicon-o-arrow-long-right class="size-5" aria-hidden="true" />
                    </x-buttons.primary>
                </div>
            </div>
        </div>
    </x-container>

    <div class="relative bg-black">
        <div class="absolute bottom-0 h-80 w-full xl:inset-0 xl:h-full">
            <div class="h-full w-full xl:grid xl:grid-cols-2">
                <div class="h-full xl:relative xl:col-start-2">
                    <img
                        class="h-full w-full object-cover opacity-25 xl:absolute xl:inset-0"
                        src="{{ asset('/images/developer.jpg') }}"
                        alt="Developer working on laptop"
                    />
                    <div
                        aria-hidden="true"
                        class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-black xl:inset-y-0 xl:left-0 xl:h-full xl:w-32 xl:bg-gradient-to-r"
                    ></div>
                </div>
            </div>
        </div>
        <div class="mx-auto max-w-4xl px-4 lg:max-w-7xl xl:grid xl:grid-flow-col-dense xl:grid-cols-2 xl:gap-x-8">
            <div class="relative pb-64 pt-12 sm:pb-64 sm:pt-24 xl:col-start-1 xl:pb-24">
                <h2 class="font-heading text-sm font-semibold uppercase tracking-wide text-green-300">
                    {{ __('global.navigation.about') }}
                </h2>
                <p class="mt-3 text-3xl font-extrabold text-white">
                    {{ __('pages/home.about.heading') }}
                </p>
                <p class="mt-5 text-lg text-gray-400">
                    <span class="text-white">
                        <span class="italic text-primary-600">"</span>
                        {{ __('pages/home.about.everybody_learn') }}
                        <span class="italic text-primary-600">"</span>
                    </span>.
                    {{ __('pages/home.about.community_spirit') }}
                </p>
                <div class="mt-12 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-2">
                    <p>
                        <span class="block font-heading text-2xl text-white">600+</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="font-medium text-white">{{ __('global.members') }}</span>
                            {{ __('pages/home.about.join_members') }}
                        </span>
                    </p>

                    <p>
                        <span class="block font-heading text-2xl text-white">50K+</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="font-medium text-white">{{ __('global.developers') }}</span>
                            {{ __('pages/home.about.developers_location') }}
                        </span>
                    </p>

                    <p>
                        <span class="block font-heading text-2xl text-white">25%</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="font-medium text-white">{{ __('global.event_rates') }}</span>
                            {{ __('pages/home.about.young_community') }}
                        </span>
                    </p>

                    <p>
                        <span class="block font-heading text-2xl text-white">10K+</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="font-medium text-white">{{ __('global.stars') }}</span>
                            {{ __('pages/home.about.projects') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <livewire:components.github-repositories />
</x-app-layout>
