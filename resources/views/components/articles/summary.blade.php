@props(['article'])

<div class="space-y-4 lg:grid lg:grid-cols-3 lg:items-start lg:gap-6 lg:space-y-0">
    <a href="{{ route('articles.show', $article) }}" class="group">
        <div class="aspect-w-3 aspect-h-2">
            <img class="object-cover shadow-lg rounded-lg group-hover:opacity-75" src="{{ $article->getFirstMediaUrl('media') }}" alt="{{ $article->title }}" />
        </div>
    </a>
    <div class="sm:col-span-2 space-y-2">
        <div>
            <time datetime="{{ $article->created_at->format('Y-m-d') }}" class="font-sans text-sm leading-5 text-skin-base capitalize">
                {{ $article->created_at->isoFormat('LL') }}
            </time>
            <a href="{{ route('articles.show', $article) }}" class="mt-2 flex group">
                <h4 class="text-lg leading-6 font-semibold font-sans text-skin-inverted group-hover:text-skin-primary">{{ $article->title }}</h4>
            </a>
            <p class="mt-1 text-sm font-normal text-skin-base leading-5">
                {!! $article->excerpt() !!}
            </p>
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
</div>
