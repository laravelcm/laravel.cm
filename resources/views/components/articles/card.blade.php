@props([
    'article',
    'isSummary' => false,
    'iconLink' => false,
])

<div
    @class(['relative group space-y-6', 'lg:grid lg:grid-cols-3 lg:items-start lg:gap-6 lg:space-y-0' => $isSummary])
>
    <div class="aspect-h-2 aspect-w-3">
        <img
            class="rounded-lg object-cover shadow-lg group-hover:opacity-75"
            src="{{ $article->getFirstMediaUrl('media') }}"
            alt="{{ $article->title }}"
        />
    </div>
    <div @class(['space-y-4', 'sm:col-span-2' => $isSummary])>
        <div>
            <time
                datetime="{{ $article->publishedAt()->format('Y-m-d') }}"
                class="text-sm capitalize leading-5 text-gray-500 dark:text-gray-400"
            >
                {{ $article->publishedAt()->isoFormat('LL') }}
            </time>
            <x-link :href="route('articles.show', $article)" class="group mt-0.5 flex items-center justify-between gap-2">
                <h4 class="text-lg font-semibold leading-6 text-gray-900 transition duration-200 ease-in-out group-hover:text-primary-600">
                    {{ $article->title }}
                </h4>
                @if ($iconLink)
                    <x-untitledui-link-external-01 class="size-5 text-gray-500 dark:text-gray-400" aria-hidden="true" />
                @endif
                <span class="absolute inset-0"></span>
            </x-link>
            <p class="mt-1 line-clamp-3 leading-6 text-gray-500 dark:text-gray-400">
                {!! $article->excerpt(150) !!}
            </p>
        </div>
        <div class="flex items-center gap-3">
            @if ($article->tags->isNotEmpty())
                <div class="flex items-center gap-2">
                    @foreach ($article->tags as $tag)
                        <x-tag :tag="$tag" />
                    @endforeach
                </div>
            @endif

            <x-articles.sponsored :isSponsored="$article->isSponsored()" />
        </div>
    </div>
</div>
