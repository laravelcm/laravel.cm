@props(['discussion', 'hiddenAuthor' => false])

<div class="py-6">
    <div class="lg:flex lg:items-center lg:justify-between">
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
    @if(!$hiddenAuthor)
        <div class="mt-3 sm:flex sm:justify-between">
            <div class="flex items-center text-sm font-sans text-skin-muted">
                <a class="shrink-0" href="{{ route('profile', $discussion->user->username) }}">
                    <x-user.avatar :user="$discussion->user" class="h-6 w-6" span="-right-1 -top-1 ring-1 h-4 w-4" />
                </a>
                <span class="ml-2 pr-1">{{ __('Posté par') }}</span>
                <div class="flex items-center space-x-1" wire:ignore>
                    <a href="{{ route('profile', $discussion->user->username) }}" class="text-skin-inverted hover:underline">{{ $discussion->user->name }}</a>
                    <span aria-hidden="true">&middot;</span>
                    <time-ago time="{{ $discussion->created_at->getTimestamp() }}"/>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center space-x-3">
                @if($discussion->getReactionsSummary()->isNotEmpty())
                    <div class="flex items-center justify-center space-x-2">
                        @foreach($discussion->getReactionsSummary() as $reaction)
                            <img class="w-4 h-4" src="{{ asset("/images/reactions/{$reaction->name}.svg") }}" alt="{{ $reaction->name }} emoji">
                        @endforeach
                        <span class="ml-3 text-sm font-medium text-green-500">{{ $discussion->getReactionsSummary()->sum('count') }}</span>
                    </div>
                @endif
                <p class="inline-flex text-sm space-x-2 text-skin-base">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                    <span class="font-normal text-skin-inverted-muted">{{ $discussion->count_all_replies_with_child }}</span>
                    <span class="sr-only">{{ __('réponses') }}</span>
                </p>
            </div>
        </div>
    @endif
</div>
