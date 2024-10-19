<x-app-layout :title="$title ?? null">
    <x-container class="py-12">
        <div class="relative lg:grid lg:grid-cols-9 lg:gap-12">
            <div class="lg:col-span-2 lg:block">
                <nav class="sticky top-10 space-y-6">
                    @isset($buttons)
                        {{ $buttons }}
                    @endisset

                    <div class="space-y-2">
                        <x-nav.forum-link icon="untitledui-file-02">
                            {{ __('pages/forum.navigation.threads') }}
                        </x-nav.forum-link>
                        <x-nav.forum-link icon="untitledui-git-branch">
                            {{ __('pages/forum.navigation.channels') }}
                        </x-nav.forum-link>
                        <x-nav.forum-link icon="untitledui-user-left">
                            {{ __('pages/forum.navigation.me') }}
                        </x-nav.forum-link>
                        <x-nav.forum-link icon="untitledui-bell-ringing-03">
                            {{ __('pages/forum.navigation.following') }}
                        </x-nav.forum-link>
                        <x-nav.forum-link icon="untitledui-heart">
                            {{ __('pages/forum.navigation.popular') }}
                        </x-nav.forum-link>
                        <x-nav.forum-link icon="untitledui-check-verified">
                            {{ __('pages/forum.navigation.solve') }}
                        </x-nav.forum-link>
                        <x-nav.forum-link icon="untitledui-help-circle">
                            {{ __('pages/forum.navigation.unresolved') }}
                        </x-nav.forum-link>
                        <x-nav.forum-link icon="untitledui-message-x-square">
                            {{ __('pages/forum.navigation.no_reply') }}
                        </x-nav.forum-link>
                        <x-nav.forum-link icon="untitledui-trophy-02">
                            {{ __('pages/forum.navigation.leaderboard') }}
                        </x-nav.forum-link>
                    </div>
                </nav>
            </div>

            <div class="mt-6 sm:mt-0 lg:col-span-7">
                {{ $slot }}
            </div>
        </div>
    </x-container>
</x-app-layout>
