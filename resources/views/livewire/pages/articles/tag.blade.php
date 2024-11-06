<x-container class="py-12">
    <header class="max-w-2xl">
        <nav class="flex items-center gap-2 text-sm" aria-label="Breadcrumb">
            <x-link :href="route('home')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                {{ __('global.navigation.home') }}
            </x-link>
            <span>
                <x-untitledui-slash-divider
                    class="size-4 text-gray-400 dark:text-gray-500"
                    stroke-width="1.5"
                    aria-hidden="true"
                />
            </span>
            <x-link :href="route('articles')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                {{ __('global.navigation.articles') }}
            </x-link>
        </nav>
        <div class="mt-4 flex items-center gap-4">
            <x-dynamic-component :component="'icon.tags.'. $tag->slug()" class="h-8" aria-hidden="true" />
            <h1 class="text-2xl font-bold tracking-tight font-heading text-gray-900 dark:text-white sm:text-3xl">
                {{ $tag->name }}
            </h1>
        </div>
        @if($tag->description)
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                {{ $tag->description }}
            </p>
        @endif
    </header>

    <div x-data x-intersect="@this.call('loadMore')" class="mt-12 lg:mt-16">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 lg:gap-y-12">
            @foreach ($articles as $article)
                <x-articles.card-author :article="$article" wire:key="{{ $article->slug() }}" />
            @endforeach
        </div>

        @if ($articles->hasMorePages())
            <p x-intersect="@this.call('loadMore')" class="mt-10 flex items-center justify-center gap-2">
                <x-loader class="text-primary-600" aria-hidden="true" />
                {{ __('global.loading') }}
            </p>
        @endif
    </div>
</x-container>
