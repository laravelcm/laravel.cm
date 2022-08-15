@props(['article'])

<article class="pb-8 border-b border-skin-base" aria-labelledby="post-title-{{ $article->id }}">
    <div>
        <div class="flex space-x-3">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="{{ $article->author->profile_photo_url }}" alt="{{ $article->author->name }}">
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-skin-inverted">
                    <a href="{{ route('profile', $article->author->username) }}" class="hover:underline">{{ $article->author->name }}</a>
                </p>
                <p class="text-sm text-skin-base">
                    <time class="capitalize" datetime="{{ $article->publishedAt()->format('Y-m-d') }}">{{ $article->publishedAt()->isoFormat('LL') }}</time>
                </p>
            </div>
        </div>
        <h2 id="post-title-{{ $article->id }}" class="mt-4 text-lg leading-7 font-medium text-skin-inverted">
            {{ $article->title }}
        </h2>
    </div>
    <a href="{{ route('articles.show', $article) }}" class="block mt-2 group space-y-4">
        <p class="text-base leading-6 text-skin-inverted-muted/70">
            {!! $article->excerpt(175) !!}
        </p>
        <div class="relative h-96 overflow-hidden">
            <img class="w-full h-full object-cover shadow-lg rounded-lg group-hover:opacity-75" src="{{ $article->getFirstMediaUrl('media') }}" alt="{{ $article->title }}" />
        </div>
        <div class="flex justify-between space-x-8">
            <div class="flex space-x-6">
                <span class="inline-flex items-center text-sm">
                    <button type="button" class="inline-flex space-x-2 text-skin-muted hover:text-skin-base">
                        <x-heroicon-o-thumb-up class="h-5 w-5" />
                        <span class="font-medium text-skin-inverted">{{ $article->reactions_count }}</span>
                        <span class="sr-only">likes</span>
                    </button>
                </span>
                <span class="inline-flex items-center text-sm">
                    <div class="inline-flex space-x-2 text-skin-muted">
                        <x-heroicon-o-eye class="h-5 w-5" />
                        <span class="font-medium text-skin-inverted">{{ $article->views_count }}</span>
                        <span class="sr-only">vues</span>
                    </div>
                </span>
            </div>
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
        </div>
    </a>
</article>
