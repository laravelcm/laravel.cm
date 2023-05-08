@props(['article'])

<article id="article-title-{{ $article->id }}" class="space-y-4 lg:grid lg:grid-cols-3 lg:items-start lg:gap-6 lg:space-y-0">
    <a href="{{ route('articles.show', $article) }}" class="group">
        <div class="aspect-w-3 aspect-h-2">
            <img class="object-cover shadow-lg rounded-lg group-hover:opacity-75"
                 src="{{ $article->getFirstMediaUrl('media') }}"
                 alt="{{ $article->title }}"
            />
        </div>
    </a>
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
            <a href="{{ route('articles.show', $article) }}" class="group">
                <h4 class="text-lg leading-7 font-semibold font-sans text-skin-inverted group-hover:text-skin-primary">
                    {{ $article->title }}
                </h4>
            </a>
            <p class="mt-1 text-sm text-skin-base leading-5">
                {!! $article->excerpt(130) !!}
            </p>
            <div class="mt-3 flex items-center font-sans">
                <div class="shrink-0">
                    <a href="{{ route('profile', $article->user->username) }}">
                        <span class="sr-only">{{ $article->user->name }}</span>
                        <x-user.avatar :user="$article->user" class="h-10 w-10" />
                    </a>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-skin-inverted">
                        <a href="{{ route('profile', $article->user->username) }}" class="hover:underline">
                            {{ $article->user->name }}
                        </a>
                    </p>
                    <div class="flex space-x-1 text-sm text-skin-base/60">
                        <time class="capitalize" datetime="{{ $article->publishedAt()->format('Y-m-d') }}">{{ $article->publishedAt()->isoFormat('LL') }}</time>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ __(':time min de lecture', ['time' => $article->readTime()]) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
