<x-app-layout :title="$title ?? null">
    @php
        $isLogged = auth()->check();
    @endphp

    <x-container class="px-0">
        <div class="pt-14 pb-16 lg:pt-28 line-x">
            <div class="lg:grid lg:grid-cols-10 lg:border-t lg:border-line lg:divide-x divide-dotted divide-gray-300 dark:divide-white/20">
                <div class="hidden py-6 lg:col-span-2 lg:block">
                    <x-sticky-content class="space-y-6">
                        @isset ($buttons)
                            {{ $buttons }}
                        @endisset

                        <div class="space-y-1">
                            <x-nav.forum-link :href="route('forum.index')" icon="untitledui-file-02">
                                {{ __('pages/forum.navigation.threads') }}
                            </x-nav.forum-link>
                            <x-nav.forum-link
                                :href="route('forum.channels')"
                                :active="request()->routeIs('forum.channels')"
                                icon="phosphor-tree-view-duotone"
                            >
                                {{ __('pages/forum.navigation.channels') }}
                            </x-nav.forum-link>

                            @auth
                                <x-nav.forum-link
                                    :href="route('forum.index', ['me' => true])"
                                    :active="request()->getUri() === route('forum.index', ['me' => true])"
                                    icon="phosphor-user-list-duotone"
                                >
                                    {{ __('pages/forum.navigation.me') }}
                                </x-nav.forum-link>
                                <x-nav.forum-link
                                    :href="route('forum.index', ['follow' => true])"
                                    :active="request()->getUri() === route('forum.index', ['follow' => true])"
                                    icon="phosphor-bell-ringing-duotone"
                                >
                                    {{ __('pages/forum.navigation.following') }}
                                </x-nav.forum-link>
                            @endauth

                            <x-nav.forum-link
                                :href="route('forum.index', ['popular' => true])"
                                :active="request()->getUri() === route('forum.index', ['popular' => true])"
                                icon="phosphor-heart-duotone"
                            >
                                {{ __('pages/forum.navigation.popular') }}
                            </x-nav.forum-link>
                            <x-nav.forum-link
                                :href="route('forum.index', ['solved' => 'yes'])"
                                :active="request()->getUri() === route('forum.index', ['solved' => 'yes'])"
                                icon="phosphor-seal-check-duotone"
                            >
                                {{ __('pages/forum.navigation.solve') }}
                            </x-nav.forum-link>
                            <x-nav.forum-link
                                :href="route('forum.index', ['solved' => 'no'])"
                                :active="request()->getUri() === route('forum.index', ['solved' => 'no'])"
                                icon="phosphor-seal-question-duotone"
                            >
                                {{ __('pages/forum.navigation.unresolved') }}
                            </x-nav.forum-link>
                            <x-nav.forum-link
                                :href="route('forum.index', ['no-replies' => true])"
                                :active="request()->getUri() === route('forum.index', ['no-replies' => true])"
                                icon="phosphor-chat-teardrop-slash-duotone"
                            >
                                {{ __('pages/forum.navigation.no_reply') }}
                            </x-nav.forum-link>
                        </div>
                    </x-sticky-content>
                </div>

                <div @class([
                    'mt-6 border-b border-line sm:mt-0',
                    'lg:col-span-8' => $isLogged || request()->routeIs('forum.leaderboard'),
                    'lg:col-span-6' => ! $isLogged && ! request()->routeIs('forum.leaderboard'),
                ])>
                    {{ $slot }}
                </div>

                @if (! request()->routeIs('forum.leaderboard') && auth()->guest())
                    <aside class="hidden p-6 lg:block lg:col-span-2">
                        <x-sticky-content class="space-y-10">
                            <x-ads />
                            <x-discord />
                        </x-sticky-content>
                    </aside>
                @endif
            </div>
        </div>
    </x-container>
</x-app-layout>
