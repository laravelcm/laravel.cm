@props(['article'])

<div class="space-y-8">
    <div class="group relative">
        <div class="aspect-w-2 aspect-h-1">
            <img class="object-cover shadow-md rounded-md" src="{{ $article->getFirstMediaUrl('media') }}" alt="{{ $article->title }}" />
        </div>
        <span class="absolute inset-x-0 bottom-0 h-1/3 w-full backdrop-blur-md flex justify-between p-6">
            <div>
                <h4 class="text-white text-sm leading-5">{{ $article->author->name }}</h4>
                <time datetime="{{ $article->created_at->format('Y-m-d') }}" class="text-sm leading-5 text-skin-base capitalize">
                    {{ $article->created_at->isoFormat('LL') }}
                </time>
            </div>
            <div class="flex items-center space-x-3 text-white">
                @if ($article->tags->isNotEmpty())
                    <div class="flex items-center space-x-2">
                        @foreach ($article->tags as $tag)
                            <x-tag :tag="$tag" />
                        @endforeach
                    </div>
                @endif
            </div>
        </span>
    </div>
    <div>
        <h4 class="text-lg leading-6 font-semibold font-sans text-skin-inverted line-clamp-2 group-hover:text-skin-primary">{{ $article->title }}</h4>
        <p class="mt-3 font-normal text-skin-base leading-6 line-clamp-2">
            {!! $article->excerpt(100) !!}
        </p>
        <a href="{{ route('articles.show', $article) }}" class="mt-8 inline-flex items-center text-flag-green hover:text-green-800">
            {{ __('Lire l\'article') }}
            <x-heroicon-o-external-link class="ml-2.5 h-5 w-5" />
        </a>
    </div>
</div>
