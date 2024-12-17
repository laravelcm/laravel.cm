@props([
    'article',
])

@php
    $media = ! empty($article->getFirstMediaUrl('media'))
        ? $article->getFirstMediaUrl('media')
        : asset('images/socialcard.png');
@endphp

<article
    id="{{ $article->slug }}"
    class="space-y-4 lg:grid lg:grid-cols-3 lg:items-start lg:gap-6 lg:space-y-0"
>
    <x-link :href="route('articles.show', $article)" class="group">
        <div class="aspect-h-2 aspect-w-3">
            <img
                class="rounded-lg object-cover shadow-lg group-hover:opacity-75"
                src="{{ $media }}"
                alt="{{ $article->title }}"
            />
        </div>
    </x-link>
    <div class="sm:col-span-2">
        <div class="flex items-center space-x-3">
            @if ($article->tags->isNotEmpty())
                <div class="flex items-center space-x-2">
                    @foreach ($article->tags as $tag)
                        <x-tag :tag="$tag" />
                    @endforeach
                </div>
            @endif

            <x-articles.sponsored :isSponsored="$article->isSponsored()" />
        </div>
        <div class="mt-2">
            <x-link :href="route('articles.show', $article)" class="group">
                <h4 class="font-sans text-lg font-semibold leading-7 text-gray-900 group-hover:text-primary-600">
                    {{ $article->title }}
                </h4>
            </x-link>
            <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">
                {!! $article->excerpt(130) !!}
            </p>
            <div class="mt-3 flex items-center font-sans">
                <div class="shrink-0">
                    <x-link :href="route('profile', $article->user->username)">
                        <span class="sr-only">{{ $article->user->name }}</span>
                        <x-user.avatar :user="$article->user" class="size-10" />
                    </x-link>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">
                        <x-link :href="route('profile', $article->user->username)" class="hover:underline">
                            {{ $article->user->name }}
                        </x-link>
                    </p>
                    <div class="flex space-x-1 text-sm text-gray-500 dark:text-gray-400/60">
                        <time class="capitalize" datetime="{{ $article->published_at->format('Y-m-d') }}">
                            {{ $article->published_at->isoFormat('LL') }}
                        </time>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ __('global.read_time', ['time' => $article->readTime()]) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
