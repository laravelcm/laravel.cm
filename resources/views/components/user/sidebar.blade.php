@props([
    'user',
])

<nav aria-label="Sidebar" class="sticky top-4">
    <div class="flex flex-col space-y-2">
        <x-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <span class="flex-1">Articles</span>
            <span>{{ number_format($user->countArticles()) }}</span>
        </x-link>

        <x-link :href="route('discussions.index')" :active="request()->routeIs('discussions.index')">
            <span class="flex-1">Discussions</span>
            <span>{{ number_format($user->countDiscussions()) }}</span>
        </x-link>
    </div>
</nav>
