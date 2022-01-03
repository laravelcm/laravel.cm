@props(['discussion'])

<div class="py-6 border-b border-skin-base">
    <div class="mt-2 lg:flex lg:items-center lg:justify-between">
        <div class="flex-1">
            <h2 class="text-xl font-semibold font-sans text-skin-inverted leading-7">
                <a href="{{ route('discussions.show', $discussion) }}" class="hover:text-skin-primary">{{ $discussion->title }}</a>
            </h2>
        </div>
        <div class="mt-2 lg:mt-0 shrink-0 self-start">
            @if (count($tags = $discussion->tags))
                <div class="flex flex-wrap gap-2 lg:gap-x-3">
                    @foreach ($tags as $tag)
                        <x-tag :tag="$tag" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <p class="mt-1 text-sm font-normal text-skin-base leading-5">
        {!! $discussion->excerpt(175) !!}
    </p>
    <div class="mt-3 flex justify-between">
        <div class="flex items-center text-sm font-sans text-skin-muted">
            <a class="shrink-0" href="{{ route('profile', $discussion->author->username) }}">
                <img class="h-6 w-6 rounded-full" src="{{ $discussion->author->profile_photo_url }}" alt="{{ $discussion->author->name }}">
            </a>
            <span class="ml-2 pr-1">Posté par</span>
            <div class="flex items-center space-x-1">
                <a href="{{ route('profile', $discussion->author->username) }}" class="text-skin-inverted hover:underline">{{ $discussion->author->name }}</a>
                <span aria-hidden="true">&middot;</span>
                <time-ago time="{{ $discussion->created_at->getTimestamp() }}"/>
            </div>
        </div>
        <div class="flex items-center text-sm space-x-4">
            <p class="inline-flex space-x-2 text-skin-base">
                <x-heroicon-o-chat-alt-2 class="h-5 w-5" />
                <span class="font-normal text-skin-inverted-muted">{{ $discussion->count_all_replies_with_child }}</span>
                <span class="sr-only">réponses</span>
            </p>
            <a href="{{ route('discussions.edit', $discussion->slug()) }}" class="inline-flex items-center font-normal text-skin-inverted-muted hover:text-skin-base hover:underline">
                <x-heroicon-o-pencil class="h-4 w-4 mr-1.5" />
                Éditer
            </a>
        </div>
    </div>
</div>
