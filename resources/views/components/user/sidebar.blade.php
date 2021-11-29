@props(['user'])

<nav aria-label="Sidebar" class="sticky top-4">
    <div class="space-y-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <span class="flex-1">{{ __('Articles') }}</span>
            <span>{{ number_format($user->countArticles()) }}</span>
        </x-nav-link>

        <x-nav-link :href="route('discussions.me')" :active="request()->routeIs('discussions.me')">
            <span class="flex-1">{{ __('Discussions') }}</span>
            <span>{{ number_format($user->countDiscussions()) }}</span>
        </x-nav-link>

        <x-nav-link :href="route('threads.me')" :active="request()->routeIs('threads.me')">
            <span class="flex-1">{{ __('Sujets') }}</span>
            <span>{{ number_format($user->countThreads()) }}</span>
        </x-nav-link>
    </div>
</nav>
