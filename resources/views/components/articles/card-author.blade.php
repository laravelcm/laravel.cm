@props([
    'article',
])

@php
    $media = ! empty($article->getFirstMediaUrl('media', 'media_thumb'))
        ? $article->getFirstMediaUrl('media', 'media_thumb')
        : asset('images/socialcard.png')
@endphp

<article class="relative" wire:key="{{ $article->slug }}">
    <div class="relative w-full">
        <img
            src="{{ $media }}"
            alt="{{ $article->title }}"
            class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] dark:bg-gray-800"
        >
        <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10 dark:ring-white/10"></div>
    </div>
    <div class="max-w-xl mt-4">
        <div class="flex items-center gap-x-4 text-xs">
            @if ($article->tags->isNotEmpty())
                <div class="flex items-center gap-x-4">
                    @foreach ($article->tags as $tag)
                        <x-tag :tag="$tag" />
                    @endforeach
                </div>
            @endif

            <x-articles.sponsored :isSponsored="$article->isSponsored()" />
        </div>
        <div class="group relative">
            <h3 class="mt-3 text-lg/6 font-heading font-bold text-gray-900 group-hover:text-primary-600 dark:text-white lg:text-xl">
                <x-link :href="route('articles.show', $article)">
                    <span class="absolute inset-0"></span>
                    {{ $article->title }}
                </x-link>
            </h3>
            <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600 dark:text-gray-300">
                {!! $article->excerpt(175) !!}
            </p>
        </div>
        <div class="relative mt-8">
            <div class="text-sm/6 flex items-center gap-4">
                <x-link :href="route('profile', $article->user->username)" class="inline-flex items-center gap-2 text-gray-700 dark:text-gray-300">
                    <x-user.avatar
                        :user="$article->user"
                        class="size-6 ring-1 ring-offset-2 ring-gray-200 ring-offset-gray-50 dark:ring-white/20 dark:ring-offset-gray-900"
                        span="-right-1 top-0 size-3 ring-1"
                    />
                    <span class="absolute inset-0"></span>
                    {{ $article->user->name }}
                </x-link>
                <div class="w-[1px] h-4 border-l border-gray-200 dark:border-white/20"></div>
                <time class="capitalize text-gray-500 dark:text-gray-400" datetime="{{ $article->published_at->format('Y-m-d') }}">
                    {{ $article->published_at->isoFormat('LL') }}
                </time>
            </div>
        </div>
    </div>
</article>
