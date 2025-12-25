<div class="overflow-hidden">
    <div class="line-b section-gradient">
        <x-container class="pt-20 pb-16 lg:pt-28">
            <header>
                {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('tag', $tag) }}

                <div class="mt-4 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <x-dynamic-component :component="'icon.tags.'. $tag->slug" class="h-8" aria-hidden="true" />
                        <h1 class="text-2xl font-bold tracking-tight font-heading text-gray-900 dark:text-white sm:text-3xl">
                            {{ $tag->name }}
                        </h1>
                    </div>

                    <div class="flex items-center gap-2">
                        <span wire:loading>
                            <x-loader class="text-flag-green" aria-hidden="true" />
                        </span>
                        <x-locale-selector :$locale />
                    </div>
                </div>

                @if ($tag->description)
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        {{ $tag->description }}
                    </p>
                @endif
            </header>
        </x-container>
    </div>

    <x-container class="line-x px-0">
        <div x-data x-intersect="@this.call('loadMore')">
            <div class="grid *:border-b *:border-line sm:grid-cols-2 sm:[&>*:nth-child(odd)]:border-r lg:grid-cols-3 lg:[&>*:not(:nth-child(3n))]:border-r">
                @foreach ($articles as $article)
                    <x-articles.card-author :$article wire:key="{{ $article->slug }}" />
                @endforeach
            </div>

            @if ($articles->hasMorePages())
                <p x-intersect="@this.call('loadMore')" class="py-12 flex items-center justify-center gap-4">
                    <x-loader class="text-primary-600" aria-hidden="true" />
                    {{ __('global.loading') }}
                </p>
            @endif
        </div>
    </x-container>
</div>
