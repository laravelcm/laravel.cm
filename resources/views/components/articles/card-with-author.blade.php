@props(['article'])

<article class="pb-8 border-b border-skin-base" aria-labelledby="post-title-{{ $article->id }}">
    <div>
        <div class="flex space-x-3">
            <div class="flex-shrink-0">
                <x-user.avatar :user="$article->user" class="h-10 w-10" />
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-sm font-medium text-skin-inverted">
                    <a href="{{ route('profile', $article->user->username) }}" class="hover:underline">{{ $article->user->name }}</a>
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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                        </svg>
                        <span class="font-medium text-skin-inverted">{{ $article->reactions_count }}</span>
                        <span class="sr-only">{{ __('mentions j\'aime') }}</span>
                    </button>
                </span>
                <span class="inline-flex items-center text-sm">
                    <div class="inline-flex space-x-2 text-skin-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-medium text-skin-inverted">{{ $article->views_count }}</span>
                        <span class="sr-only">{{ __('vues') }}</span>
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
