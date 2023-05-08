@props(['article'])

<div class="space-y-6">
    <a href="{{ route('articles.show', $article) }}" class="group">
        <div class="aspect-w-3 aspect-h-2">
            <img class="object-cover shadow-lg rounded-lg group-hover:opacity-75" src="{{ $article->getFirstMediaUrl('media') }}" alt="{{ $article->title }}" />
        </div>
    </a>
    <div class="space-y-4">
        <div>
            <time datetime="{{ $article->publishedAt()->format('Y-m-d') }}" class="font-sans text-sm leading-5 text-skin-base capitalize">
                {{ $article->publishedAt()->isoFormat('LL') }}
            </time>
            <a href="{{ route('articles.show', $article) }}" class="mt-2 flex items-center justify-between group">
                <h4 class="text-lg leading-6 font-semibold font-sans text-skin-inverted group-hover:text-skin-primary">
                    {{ $article->title }}
                </h4>
                <svg class="ml-2.5 h-5 w-5 text-skin-base" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
            <p class="mt-1 font-normal text-skin-base leading-6">
                {!! $article->excerpt(150) !!}
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
