@props(['article'])

<div class="space-y-4 lg:grid lg:grid-cols-3 lg:items-start lg:gap-6 lg:space-y-0">
    <a href="{{ route('articles.show', $article) }}">
        <div class="aspect-w-3 aspect-h-2">
            <img class="object-cover shadow-lg rounded-lg" src="{{ $article->cover_image_url }}" alt="{{ $article->title }}" />
        </div>
    </a>
    <div class="sm:col-span-2">
        @if ($article->tags->isNotEmpty())
            <div class="flex items-center space-x-2">
                @foreach ($article->tags as $tag)
                    <span class="inline-flex items-center leading-none px-2.5 py-1 text-sm font-medium text-skin-inverted rounded-full border border-skin-input font-sans">
                        <svg class="mr-1.5 h-2 w-2 brand-{{ $tag->slug() }}" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                        </svg>
                        {{ $tag->name() }}
                    </span>
                @endforeach
            </div>
        @endif
        <div class="mt-2">
            <a href="{{ route('articles.show', $article) }}" class="group">
                <h4 class="font-xl leading-7 font-bold font-sans text-skin-inverted group-hover:text-skin-primary">{{ $article->title }}</h4>
            </a>
            <p class="mt-1 text-sm font-normal text-skin-base leading-5">
                {!! $article->excerpt() !!}
            </p>
            <div class="mt-3 flex items-center font-sans">
                <div class="flex-shrink-0">
                    <a href="#">
                        <span class="sr-only">{{ $article->author->name }}</span>
                        <img class="h-10 w-10 rounded-full" src="{{ $article->author->profile_photo_url }}" alt="{{ $article->author->name }}">
                    </a>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-skin-inverted">
                        <a href="#" class="hover:underline">
                            {{ $article->author->name }}
                        </a>
                    </p>
                    <div class="flex space-x-1 text-sm text-skin-muted">
                        <time datetime="2020-03-16">{{ $article->createdAt()->format('j M, Y') }}</time>
                        <span aria-hidden="true">&middot;</span>
                        <span>{{ $article->readTime() }} min de lecture</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
