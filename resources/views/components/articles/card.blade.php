@props([
    'article',
    'isSummary' => false,
    'iconLink' => false,
])

<div
    @class(['relative space-y-6', 'lg:grid lg:grid-cols-3 lg:items-start lg:gap-6 lg:space-y-0' => $isSummary])
>
    @php
        $media = ! empty($article->getFirstMediaUrl('media'))
            ? $article->getFirstMediaUrl('media')
            : asset('images/socialcard.png')
    @endphp

    @if(! $isSummary)
        <div class="aspect-[2/1] w-full rounded-lg bg-gray-100 shadow-sm transition group-hover:opacity-80">
            <img
                class="rounded-lg object-cover shadow-sm group-hover:opacity-75"
                src="{{ $media }}"
                alt="{{ $article->title }}"
            />
        </div>
    @endif

    <div @class(['space-y-4', 'sm:col-span-3' => $isSummary])>
        <div>
            <div @class([
                'flex',
                'items-center justify-between gap-4' => ! $isSummary,
                'flex-col justify-between gap-2' => $isSummary,
            ])>
                @if ($article->tags->isNotEmpty())
                    <div class="flex items-center gap-2">
                        @foreach ($article->tags as $tag)
                            <x-tag :tag="$tag" />
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
                @if ($iconLink)
                    <x-untitledui-link-external-01 class="size-5 text-gray-500 dark:text-gray-400" aria-hidden="true" />
                @endif
                <span class="absolute inset-0"></span>
            </x-link>
            <p class="mt-1 line-clamp-3 leading-6 text-gray-500 dark:text-gray-400">
                {!! $article->excerpt(150) !!}
            </p>
        </div>
    </div>
</div>
