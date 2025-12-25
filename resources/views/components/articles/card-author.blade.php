@props([
    'article',
])

<article {{ $attributes->twMerge(['class' => 'flex flex-col justify-between p-6 hover:bg-gray-50 dark:hover:bg-white/5']) }}>
    <div class="flex-1">
        <div class="flex items-center gap-4">
            @if ($article->tags->isNotEmpty())
                <div class="flex items-center gap-x-4">
                    @foreach ($article->tags as $tag)
                        <x-tag :$tag />
                    @endforeach
                </div>
            @endif

            <x-articles.sponsored :isSponsored="$article->isSponsored()" />
        </div>
        <div class="mt-3 group relative">
            <h3 class="text-lg font-heading font-medium text-gray-900 group-hover:text-primary-600 dark:text-white lg:text-xl dark:group-hover:text-primary-500">
                <x-link :href="route('articles.show', $article)">
                    <span class="absolute inset-0"></span>
                    {{ $article->title }}
                </x-link>
            </h3>
            <p class="mt-5 line-clamp-3 text-gray-500 dark:text-gray-300">
                {!! $article->excerpt(175) !!}
            </p>
        </div>
    </div>
    <div class="relative mt-4 text-sm flex items-center justify-between gap-2">
        <x-link
            :href="route('profile', $article->user->username)"
            class="inline-flex items-center gap-2 text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white"
        >
            <x-user.avatar :user="$article->user" size="xs" />
            <span class="absolute inset-0"></span>
            {{ $article->user->name }}
        </x-link>
        <time
            class="capitalize text-gray-500 dark:text-gray-400"
            datetime="{{ $article->published_at->format('Y-m-d') }}"
        >
            {{ $article->published_at->isoFormat('LL') }}
        </time>
    </div>
</article>
