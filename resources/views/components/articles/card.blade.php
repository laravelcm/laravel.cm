@props([
    'article',
    'isSummary' => false,
])

<div @class([
    'relative space-y-6',
    'lg:grid lg:grid-cols-3 lg:items-start lg:gap-6 lg:space-y-0' => $isSummary
])>
    @php
        $media = ! empty($article->getFirstMediaUrl('media'))
            ? $article->getFirstMediaUrl('media')
            : asset('images/socialcard.png')
    @endphp

    @if (! $isSummary)
        <div class="aspect-4/2 w-full rounded-lg bg-gray-100 overflow-hidden shadow-xs transition group-hover:opacity-80 dark:bg-gray-800">
            <img
                loading="lazy"
                class="rounded-lg object-cover shadow-xs group-hover:opacity-75"
                src="{{ $media }}"
                alt="{{ $article->title }}"
            />
        </div>
    @endif

    <div @class(['sm:col-span-3' => $isSummary])>
        <div @class([
            'flex flex-col lg:flex-row',
            'justify-between gap-4' => ! $isSummary,
            'flex-col justify-between gap-2' => $isSummary,
        ])>
            @if ($article->tags->isNotEmpty())
                <div class="flex items-center gap-2">
                    @foreach ($article->tags as $tag)
                        <x-tag :$tag />
                    @endforeach
                </div>
            @endif

            <time
                datetime="{{ $article->published_at->format('Y-m-d') }}"
                class="text-sm capitalize leading-5 text-gray-500 dark:text-gray-400"
            >
                {{ $article->published_at->isoFormat('LL') }}
            </time>
        </div>
        <x-link :href="route('articles.show', $article)" class="group relative mt-4 flex items-center justify-between gap-2">
            <h4 class="text-lg font-bold font-heading leading-6 text-gray-900 transition duration-200 ease-in-out dark:text-white dark:group-hover:text-primary-500 group-hover:text-primary-600 lg:text-xl">
                {{ $article->title }}
            </h4>
            <span class="absolute inset-0"></span>
        </x-link>
        <p class="mt-3 line-clamp-4 text-gray-500 dark:text-gray-400">
            {!! $article->excerpt(200) !!}
        </p>
    </div>
</div>
