<x-app-layout :title="$title ?? null">
    @php
        $isLogged = \Illuminate\Support\Facades\Auth::check();
    @endphp

    <x-container class="py-12">
        <div class="relative lg:grid lg:grid-cols-10 lg:gap-12">
            <div class="hidden lg:col-span-2 lg:block">
                <nav class="sticky top-10 space-y-6">
                    @isset($buttons)
                        {{ $buttons }}
                    @endisset

                    <div class="space-y-2">
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
                            icon="untitledui-heart"
                            class="hidden"
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
                            icon="untitledui-message-x-square"
                            class="hidden"
                        >
                            {{ __('pages/forum.navigation.no_reply') }}
                        </x-nav.forum-link>
                        <x-nav.forum-link
                            :href="route('forum.leaderboard')"
                            :active="request()->routeIs('forum.leaderboard')"
                            icon="phosphor-ranking-duotone"
                        >
                            {{ __('pages/forum.navigation.leaderboard') }}
                        </x-nav.forum-link>
                    </div>
                </nav>
            </div>

            <div @class([
                'mt-6 sm:mt-0',
                'lg:col-span-8' => $isLogged || request()->routeIs('forum.leaderboard'),
                'lg:col-span-6' => ! $isLogged && ! request()->routeIs('forum.leaderboard'),
            ])>
                {{ $slot }}
            </div>

            @if(! request()->routeIs('forum.leaderboard') && \Illuminate\Support\Facades\Auth::guest())
                <aside class="hidden lg:block lg:col-span-2">
                    <x-sticky-content class="space-y-10">
                        <x-ads />
                        <x-discord />
                    </x-sticky-content>
                </aside>
            @endif
        </div>
    </x-container>
</x-app-layout>
