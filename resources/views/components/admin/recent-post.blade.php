@props(['article'])

<div class="space-y-8">
    <div class="group relative rounded-md overflow-hidden">
        <div class="aspect-w-2 aspect-h-1">
            <img class="object-cover shadow-md rounded-md" src="{{ $article->getFirstMediaUrl('media') }}" alt="{{ $article->title }}" />
        </div>
        <div class="absolute inset-x-0 bottom-0 w-full backdrop-blur-md bg-black/50 p-4">
            <div class="flex justify-between">
                <h4 class="text-white text-sm leading-5">{{ $article->user->name }}</h4>
                <time datetime="{{ $article->created_at->format('Y-m-d') }}" class="text-sm leading-5 text-slate-300 capitalize">
                    {{ $article->created_at->isoFormat('LL') }}
                </time>
            </div>
            <div class="mt-3 flex items-center space-x-2 text-white">
                @if ($article->tags->isNotEmpty())
                    @foreach ($article->tags as $tag)
                        <x-tag :tag="$tag" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div>
        <h4 class="text-lg leading-6 font-semibold font-sans text-slate-900 line-clamp-2 group-hover:text-primary-500">
            {{ $article->title }}
        </h4>
        <p class="mt-3 font-normal text-slate-500 leading-6 line-clamp-2">
            {!! $article->excerpt(100) !!}
        </p>
        <a href="{{ route('articles.show', $article) }}" class="mt-8 inline-flex items-center text-flag-green hover:text-primary-800">
            {{ __('Lire l\'article') }}
            <x-heroicon-o-external-link class="ml-2.5 h-5 w-5" />
        </a>
    </div>
</div>
