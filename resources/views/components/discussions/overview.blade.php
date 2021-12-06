@props(['discussion'])

<div class="py-6">
    <div class="lg:flex lg:items-center lg:justify-between">
        <div class="flex-1">
            <h2 class="text-xl font-semibold font-sans text-skin-inverted leading-7">
                <a href="{{ route('discussions.show', $discussion) }}" class="hover:text-skin-primary">{{ $discussion->title }}</a>
            </h2>
        </div>
        <div class="mt-2 lg:mt-0 flex-shrink-0 self-start">
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
    <div class="mt-3 sm:flex sm:justify-between">
        <div class="flex items-center text-sm font-sans text-skin-muted">
            <a class="flex-shrink-0" href="/user/{{ $discussion->author->username }}">
                <img class="h-6 w-6 rounded-full" src="{{ $discussion->author->profile_photo_url }}" alt="{{ $discussion->author->name }}">
            </a>
            <span class="ml-2 pr-1">Posté par</span>
            <div class="flex items-center space-x-1">
                <a href="{{ route('profile', $discussion->author->username) }}" class="text-skin-inverted hover:underline">{{ $discussion->author->name }}</a>
                <span aria-hidden="true">&middot;</span>
                <time-ago time="{{ $discussion->created_at->getTimestamp() }}"/>
            </div>
        </div>
        <div class="hidden sm:flex sm:items-center space-x-3">
            <livewire:reactions
                wire:key="{{ $discussion->id }}"
                :model="$discussion"
                direction="left"
                :with-place-holder="false"
                :with-background="false"
            />
            <p class="inline-flex text-sm space-x-2 text-skin-base">
                <x-heroicon-o-chat-alt-2 class="h-5 w-5" />
                <span class="font-normal text-skin-inverted-muted">{{ $discussion->count_all_replies_with_child }}</span>
                <span class="sr-only">réponses</span>
            </p>
        </div>
    </div>
</div>
