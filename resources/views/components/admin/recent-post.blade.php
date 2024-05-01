@props([
    'article',
])

<div class="space-y-8">
    <div class="group relative overflow-hidden rounded-md">
        <div class="aspect-h-1 aspect-w-2">
            <img
                class="rounded-md object-cover shadow-md"
                src="{{ $article->getFirstMediaUrl('media') }}"
                alt="{{ $article->title }}"
            />
        </div>
        <div class="absolute inset-x-0 bottom-0 w-full bg-black/50 p-4 backdrop-blur-md">
            <div class="flex justify-between">
                <h4 class="text-sm leading-5 text-white">{{ $article->user->name }}</h4>
                <time
                    datetime="{{ $article->created_at->format('Y-m-d') }}"
                    class="text-sm capitalize leading-5 text-slate-300"
                >
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
        <h4 class="line-clamp-2 font-sans text-lg font-semibold leading-6 text-slate-900 group-hover:text-primary-500">
            {{ $article->title }}
        </h4>
        <p class="mt-3 line-clamp-2 font-normal leading-6 text-slate-500">
            {!! $article->excerpt(100) !!}
        </p>
        <a
            href="{{ route('articles.show', $article) }}"
            class="mt-8 inline-flex items-center text-flag-green hover:text-primary-800"
        >
            {{ __('Lire l\'article') }}
            <x-untitledui-link-external-01 class="ml-2.5 h-5 w-5" />
        </a>
    </div>
</div>
