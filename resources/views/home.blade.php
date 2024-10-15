<x-app-layout>
    <div class="relative isolate -mt-16 pt-14">
        <div class="absolute inset-0 -z-10 mx-0 max-w-none overflow-hidden">
            <div class="absolute left-1/2 top-0 ml-[-32rem] h-[32rem] w-[84.25rem]">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-flag-red to-flag-yellow opacity-40 [mask-image:radial-gradient(farthest-side_at_top,white,transparent)]"
                ></div>
                <svg
                    viewBox="0 0 1113 440"
                    aria-hidden="true"
                    class="absolute left-1/2 top-0 ml-[-24rem] w-[70.5625rem] fill-green-500 opacity-30 blur-2xl"
                >
                    <path d="M.016 439.5s-9.5-300 434-300S882.516 20 882.516 20V0h230.004v439.5H.016Z" />
                </svg>
                <svg
                    viewBox="0 0 1113 440"
                    aria-hidden="true"
                    class="absolute left-1/2 top-0 ml-[-24rem] w-[70.5625rem] fill-yellow-50 opacity-50 blur-2xl"
                >
                    <path d="M.016 439.5s-9.5-300 434-300S882.516 20 882.516 20V0h230.004v439.5H.016Z" />
                </svg>
            </div>
        </div>
        <div class="mx-auto max-w-3xl px-4 pb-16 pt-28 sm:pt-32 lg:pt-40">
            <div class="flex justify-center">
                <x-link
                    href="{{ route('sponsors') }}"
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
                        <x-buttons.primary :link="route('forum.new')" class="w-full sm:w-auto">
                            {{ __('actions.new_thread') }}
                        </x-buttons.primary>
                    @else
                        <x-buttons.primary :link="route('login')" class="w-full sm:w-auto">
                            {{ __('pages/home.join_community') }}
                        </x-buttons.primary>
                    @endauth
                    <x-buttons.default :link="route('forum.index')">
                        {{ __('pages/home.visit_forum') }}
                    </x-buttons.default>
                </div>
            </div>
        </div>

        <x-join-sponsors :title="__('pages/home.work_associations')" />
    </div>

    <x-container>
        <div class="divide-y divide-skin-base">
            <div class="py-12 lg:py-20">
                <x-section-header
                    :title="__('pages/home.popular_posts.title')"
                    :content="__('pages/home.popular_posts.description')"
                />
                <div
                    class="mx-auto mt-8 grid max-w-xl gap-10 lg:mt-10 lg:max-w-none lg:grid-flow-col lg:grid-cols-2 lg:grid-rows-3 lg:gap-x-8"
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
                    <x-buttons.primary :link="route('articles')" class="gap-2">
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
                        <x-buttons.primary :link="route('forum.index')" class="gap-2">
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
                    <x-buttons.primary :link="route('discussions.index')" class="gap-2">
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

    @feature('premium')
        @if ($plans->count() > 0)
            <div class="relative overflow-hidden pt-12 sm:pt-16 lg:pt-20">
                <div class="pointer-events-none z-0 hidden overflow-hidden opacity-50 lg:block">
                    {{-- Testimonies Area --}}
                </div>
                <div
                    class="via-skin-card to-skin-body relative z-50 bg-gradient-to-t from-transparent pb-12 sm:pb-16 lg:-mt-16 lg:pb-20"
                >
                    <div class="mx-auto max-w-7xl px-4">
                        <div class="lg:text-center">
                            <div class="inline-flex items-center space-x-2 rounded-md bg-yellow-100 px-2 py-0.5 text-yellow-600">
                                <svg
                                    class="size-5"
                                    fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M23 9.04c0-1.249-1.051-2.27-2.335-2.27-1.285 0-2.336 1.021-2.336 2.27 0 .703.35 1.36.888 1.77l-3.083 2.29-2.99-3.857c.724-.386 1.215-1.135 1.215-1.975C14.359 6.021 13.308 5 12.023 5 10.74 5 9.688 6.021 9.688 7.27c0 .839.467 1.588 1.191 1.974L7.633 13.1 4.76 10.832c.537-.408.91-1.066.91-1.793 0-1.248-1.05-2.269-2.335-2.269C2.051 6.77 1 7.791 1 9.04c0 1.111.817 2.042 1.915 2.223l1.121 5.696v2.36c0 .386.304.681.7.681h14.527c.397 0 .7-.295.7-.68v-2.36l1.122-5.697C22.183 11.082 23 10.151 23 9.04zm-2.335-.908c.513 0 .934.408.934.907 0 .5-.42.908-.934.908s-.935-.408-.935-.908c0-.499.42-.907.934-.907zM12 6.339c.514 0 .934.408.934.908 0 .499-.42.907-.934.907s-.934-.408-.934-.907c0-.5.42-.908.934-.908zm-4.18 8.396a.727.727 0 0 0 .467-.25l3.69-4.47 3.456 4.448c.117.136.28.25.467.272a.683.683 0 0 0 .514-.136l3.036-2.247-.77 3.858H5.32l-.747-3.79 2.733 2.156c.14.114.327.182.514.16zM2.4 9.04c0-.499.42-.907.934-.907s.935.408.935.907c0 .5-.42.908-.935.908-.513 0-.934-.408-.934-.908zm3.036 9.6v-1.067h13.126v1.066H5.437z"
                                    />
                                </svg>
                                <h2 class="font-heading text-lg font-semibold">Premium</h2>
                            </div>
                            <h4 class="mt-2 font-heading text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">
                                Accès illimité avec un abonnement premium
                            </h4>
                            <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 lg:mx-auto">
                                Devenir premium c'est soutenir la communauté, les nouveaux contenus chaque semaine et
                                accéder à du contenu exclusif pour apprendre et progresser.
                            </p>
                        </div>
                        <div
                            class="mt-16 space-y-12 lg:mx-auto lg:mt-20 lg:grid lg:max-w-4xl lg:grid-cols-2 lg:gap-x-8 lg:space-y-0"
                        >
                            @foreach ($plans as $plan)
                                <div
                                    class="relative flex flex-col rounded-2xl border border-skin-base bg-skin-card/50 p-8 shadow-sm backdrop-blur-sm"
                                >
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-gray-900">
                                            {{ $plan->title }}
                                        </h3>
                                        @if ($plan->slug === 'le-pro')
                                            <p
                                                class="absolute top-0 inline-flex -translate-y-1/2 transform items-center gap-2 rounded-full bg-flag-yellow px-4 py-1.5 text-sm font-semibold text-yellow-900"
                                            >
                                                <x-untitledui-star-06 class="size-5" aria-hidden="true" />
                                                Populaire
                                            </p>
                                        @endif

                                        <p class="mt-4 flex items-baseline text-gray-900">
                                            <span
                                                class="text-4xl font-bold tracking-tight"
                                                x-data="{ price: 0 }"
                                                x-init="price = formatMoney({{ $plan->price }})"
                                            >
                                                <span x-text="price"></span>
                                            </span>
                                            <span class="ml-1 text-xl font-semibold">/mois</span>
                                        </p>

                                        <!-- Feature list -->
                                        <ul role="list" class="mt-6 space-y-6">
                                            @foreach ($plan->features as $feature)
                                                <li class="flex">
                                                    <x-heroicon-o-check
                                                        class="size-6 shrink-0 text-primary-500"
                                                        aria-hidden="true"
                                                    />
                                                    <span class="ml-3 text-gray-500 dark:text-gray-400">{{ $feature->name }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <x-buttons.primary link="#" class="mt-10 w-full">Souscrire Maintenant</x-buttons.primary>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endfeature
</x-app-layout>
