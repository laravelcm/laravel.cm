<div class="overflow-hidden">
    <div class="section-gradient isolate pt-16">
        <x-container class="border-x border-dotted border-gray-300 dark:border-white/20 px-0">
            <div class="mx-auto px-4 max-w-3xl py-20 sm:pt-32 text-center">
                <x-link :href="route('sponsors')" class="group inline-flex items-center justify-center rounded-full px-2 py-1 bg-primary-700 text-white text-sm dark:bg-primary-800/60">
                    <span class="rounded-full bg-flag-green px-2 py-0.5 text-xs font-semibold uppercase leading-5 tracking-wide text-white dark:bg-flag-green/50">
                        ⚡️ {{ __('pages/home.sponsor.title') }}
                    </span>
                    <span class="ml-4 hidden text-sm sm:block">
                        {{ __('pages/home.sponsor.description') }}
                    </span>
                    <span class="ml-4 text-sm sm:hidden">
                        {{ __('pages/home.sponsor.description_small') }}
                    </span>
                    <x-heroicon-s-chevron-right
                        class="ml-2 size-5 text-white transition-all duration-300 ease-in-out group-hover:translate-x-1"
                        aria-hidden="true"
                    />
                </x-link>

                <h1 class="mt-4 font-heading text-4xl font-semibold tracking-tight text-primary-600 sm:leading-none lg:text-6xl lg:mt-8">
                    {{ __('global.site_name') }}
                </h1>
                <p class="mt-3 text-base text-gray-700 dark:text-white sm:mt-5 sm:text-lg">
                    {{ __('global.site_description') }}
                </p>
                <div class="mt-10 gap-4 sm:flex sm:items-center sm:justify-center">
                    @auth
                        <flux:button :href="route('forum.index')" variant="primary" class="w-full border-0 sm:w-auto" wire:navigate>
                            {{ __('actions.new_thread') }}
                        </flux:button>
                    @else
                        <flux:button :href="route('register')" variant="primary" class="w-full border-0 sm:w-auto" wire:navigate>
                            {{ __('pages/home.join_community') }}
                        </flux:button>
                    @endauth
                    <flux:button :href="route('forum.index')" class="mt-4 w-full sm:mt-0 sm:w-auto" wire:navigate>
                        {{ __('pages/home.visit_forum') }}
                    </flux:button>
                </div>
            </div>

            <x-join-sponsors :title="__('pages/home.work_associations')" />
        </x-container>
    </div>

    <div class="border-y border-dotted border-gray-300 dark:border-white/20">
        <x-container class="px-0">
            <div class="flex flex-col items-start justify-between px-6 py-10 sm:flex-row">
                <x-section-header
                    :title="__('pages/home.popular_posts.title')"
                    :content="__('pages/home.popular_posts.description')"
                />
            </div>
            <div
                class="relative line-t grid dark:border-white/20 lg:grid-flow-col lg:grid-cols-2 lg:grid-rows-3"
            >
                @foreach ($articles as $article)
                    @if ($loop->first)
                        <div class="px-4 py-6 bg-dotted flex flex-col justify-between lg:px-6 lg:row-span-3">
                            <x-articles.card :$article />
                            <div class="hidden mt-4 sm:block">
                                <flux:link :href="route('articles.index')" class="inline-flex items-center gap-2 text-primary-600 dark:text-primary-500">
                                    {{ __('pages/home.view_posts') }}
                                    <x-heroicon-o-arrow-long-right class="size-5" aria-hidden="true" />
                                </flux:link>
                            </div>
                        </div>
                    @else
                        <div class="px-4 py-6 lg:col-span-2 lg:px-6">
                            <x-articles.card :$article is-summary />
                        </div>
                    @endif
                @endforeach
            </div>
        </x-container>
    </div>

    <div class="line-b overflow-hidden section-gradient">
        <div class="py-2 line-b bg-white dark:bg-line-black">
            <x-container class="lg:px-6">
                <div class="flex items-start gap-4">
                    <x-untitledui-code class="size-4 shrink-0 text-primary-600 dark:text-primary-500" aria-hidden="true" />
                    <p class="text-gray-700 dark:text-gray-400 text-xs font-mono uppercase">
                        {{ __('pages/home.intro_forum') }}
                    </p>
                </div>
            </x-container>
        </div>
        <x-container class="px-0 lg:line-x">
            <div class="grid [&>div]:pt-10 lg:grid-cols-2 divide-y divide-dotted divide-gray-300 lg:divide-y-0 lg:divide-x lg:dark:divide-white/20">
                <div class="space-y-10">
                    <x-section-header
                        :title="__('pages/home.threads.title')"
                        :content="__('pages/home.threads.description')"
                        class="px-4 lg:px-6"
                    />

                    <div class="border-t border-line grid divide-y divide-dotted divide-gray-300 dark:divide-white/20">
                        @foreach ($threads as $thread)
                            <div class="px-4 py-6 lg:px-6 hover:bg-white dark:hover:bg-gray-950/75">
                                <div class="text-sm flex flex-wrap items-center gap-2 text-gray-500 dark:text-gray-400">
                                    <x-link
                                        :href="route('profile', $thread->user)"
                                        class="inline-flex items-center gap-1.5 shrink-0 hover:underline hover:decoration-1 hover:decoration-dotted"
                                    >
                                        <x-user.avatar :user="$thread->user" size="xs" />
                                        <span class="truncate">{{ '@' . $thread->user->username }}</span>
                                    </x-link>
                                    <span class="inline-flex items-center gap-1.5 shrink-0">
                                        <span>{{ __('global.ask') }}</span>
                                        <time datetime="{{ $thread->created_at }}">
                                            {{ $thread->created_at->diffForHumans() }}
                                        </time>
                                    </span>
                                </div>
                                <div class="relative mt-4">
                                    <x-link
                                        :href="route('forum.show', $thread)"
                                        class="font-medium text-gray-900 dark:text-white hover:underline hover:decoration-1 hover:decoration-dotted"
                                    >
                                        {{ $thread->subject() }}
                                        <span class="absolute inset-0"></span>
                                    </x-link>
                                    <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                        {!! $thread->excerpt() !!}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-10 h-full flex flex-col">
                    <x-section-header
                        :title="__('pages/home.discussions.title')"
                        :content="__('pages/home.discussions.description')"
                        class="px-4 lg:px-6"
                    />

                    <div class="border-t border-line flex flex-col flex-1 bg-dotted p-1.5 after:border-0">
                        <div class="grid gap-2">
                            @foreach ($discussions as $discussion)
                                <div class="px-3 py-4 lg:px-4 lg:py-5 transition duration-200 hover:ring-1 hover:ring-do hover:ring-gray-200 dark:hover:ring-white/10 rounded-lg hover:bg-white dark:hover:bg-gray-950/75">
                                    <div class="relative flex flex-wrap items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center gap-2 min-w-0 shrink">
                                            <x-user.avatar :user="$discussion->user" size="xs" class="shrink-0" />
                                            <x-link
                                                :href="route('profile', $discussion->user)"
                                                class="text-gray-900 truncate dark:text-white hover:underline hover:decoration-1 hover:decoration-dotted"
                                            >
                                                {{ $discussion->user->name }}
                                                <span class="absolute inset-0"></span>
                                            </x-link>
                                        </div>
                                        <span class="shrink-0" aria-hidden="true">&middot;</span>
                                        <time class="shrink-0" datetime="{{ $discussion->created_at }}">
                                            {{ $discussion->created_at->diffForHumans() }}
                                        </time>
                                    </div>
                                    <div class="relative mt-4">
                                        <x-link
                                            :href="route('discussions.show', $discussion)"
                                            class="font-medium text-gray-900 dark:text-white hover:underline hover:decoration-1 hover:decoration-dotted"
                                        >
                                            {{ $discussion->title }}
                                        </x-link>
                                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
                                            {!! $discussion->excerpt() !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="relative flex-1 flex flex-col items-end justify-end p-6">
                            <p class="text-sm font-mono text-gray-700 dark:text-gray-300 font-medium text-right">
                                {{ __('pages/home.intro_forum_links') }}
                            </p>
                            <div class="mt-2 flex flex-wrap items-center justify-end gap-4">
                                <flux:link
                                    :href="route('discussions.index')"
                                    class="group inline-flex items-center gap-2 text-sm text-primary-500 hover:text-primary-600 underline decoration-1 decoration-dotted"
                                    wire:navigate
                                >
                                    {{ __('pages/home.discussions.show_all') }}
                                    <x-heroicon-o-arrow-long-right class="size-5 shrink-0" aria-hidden="true" />
                                </flux:link>
                                <flux:link
                                    :href="route('forum.index')"
                                    class="group inline-flex items-center gap-2 text-sm text-primary-500 hover:text-primary-600 underline decoration-1 decoration-dotted"
                                    wire:navigate
                                >
                                    {{ __('pages/home.threads.show_all') }}
                                    <x-heroicon-o-arrow-long-right class="size-5 shrink-0" aria-hidden="true" />
                                </flux:link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-container>
    </div>

    <div class="relative bg-line-black overflow-hidden dark:line-b">
        <div class="py-2 line-b after:border-white/20">
            <x-container class="px-6">
                <div class="inline-flex items-center gap-4">
                    <x-phosphor-text-aa-duotone class="size-4 text-primary-500" aria-hidden="true" />
                    <p class="text-primary-300 text-xs font-mono uppercase">
                        {{ __('global.navigation.about') }}
                    </p>
                    <p class="hidden text-gray-400 text-xs font-mono uppercase lg:block">
                        {{ __('pages/home.about.intro') }}
                    </p>
                </div>
            </x-container>
        </div>
        <div class="hidden absolute bottom-0 w-full lg:block lg:inset-0 lg:h-full">
            <div class="size-full lg:grid lg:grid-cols-2">
                <div class="h-full flex items-center justify-center lg:relative lg:col-start-2">
                    <x-cameroon-map />
                </div>
            </div>
        </div>
        <div class="mx-auto max-w-4xl px-4 lg:max-w-7xl lg:grid lg:grid-flow-col-dense lg:grid-cols-2 lg:gap-x-8 lg:px-6">
            <div class="relative py-12 sm:py-24 lg:col-start-1">
                <h2 class="text-3xl font-bold font-heading text-white">
                    {{ __('pages/home.about.heading') }}
                </h2>
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
                        <span class="block font-mono proportional-nums slashed-zero text-2xl text-white">2K+</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="block font-medium text-white sm:inline">{{ __('global.members') }}</span>
                            {{ __('pages/home.about.join_members') }}
                        </span>
                    </p>

                    <p>
                        <span class="block font-mono proportional-nums slashed-zero text-2xl text-white">50K+</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="block font-medium text-white sm:inline">{{ __('global.developers') }}</span>
                            {{ __('pages/home.about.developers_location') }}
                        </span>
                    </p>

                    <p>
                        <span class="block font-mono proportional-nums slashed-zero text-2xl text-white">25%</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="block font-medium text-white sm:inline">{{ __('global.event_rates') }}</span>
                            {{ __('pages/home.about.young_community') }}
                        </span>
                    </p>

                    <p>
                        <span class="block font-mono proportional-nums slashed-zero text-2xl text-white">10K+</span>
                        <span class="mt-1 block text-base text-gray-400">
                            <span class="block font-medium text-white sm:inline">{{ __('global.stars') }}</span>
                            {{ __('pages/home.about.projects') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if (config('services.github.token'))
        <livewire:components.github-repositories />
    @endif
</div>
