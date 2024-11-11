@props([
    'discussion',
    'hiddenAuthor' => false,
])

<div class="py-6">
    @if ($discussion->tags->isNotEmpty())
        <div class="flex items-center space-x-2 mb-4">
            @foreach ($discussion->tags as $tag)
                <x-tag
                    :tag="$tag"
                    :href="route('discussions.index', ['tag' => $tag->slug])"
                />
            @endforeach
        </div>
    @endif
    <h2 class="font-heading text-xl font-semibold leading-7 text-gray-900 dark:text-white">
        <x-link :href="route('discussions.show', $discussion)" class="hover:text-primary-600">
            {{ $discussion->title }}
        </x-link>
    </h2>
    <p class="mt-2 leading-5 text-gray-500 dark:text-gray-400 line-clamp-2">
        {!! $discussion->excerpt(175) !!}
    </p>

    @if (! $hiddenAuthor)
        <div class="mt-4 sm:flex sm:justify-between">
            <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                <x-user.avatar
                    :user="$discussion->user"
                    class="size-6"
                    span="-right-1 -top-1 ring-1 size-4"
                />
                <span class="ml-2 pr-1">{{ __('global.posted_by') }}</span>
                <div class="flex items-center gap-1.5">
                    <x-link
                        :href="route('profile', $discussion->user->username)"
                        class="text-gray-700 dark:text-gray-300 font-medium hover:underline"
                    >
                        {{ $discussion->user->name }}
                    </x-link>
                    <span aria-hidden="true">&middot;</span>
                    <time class="truncate text-sm text-gray-500 dark:text-gray-400" datetime="{{ $discussion->created_at }}">
                        {{ $discussion->created_at->diffForHumans() }}
                    </time>
                </div>
            </div>
            <div class="hidden space-x-3 sm:flex sm:items-center">
                @if ($discussion->getReactionsSummary()->isNotEmpty())
                    <div class="flex items-center justify-center gap-2">
                        @foreach ($discussion->getReactionsSummary() as $reaction)
                            <img
                                class="size-4"
                                src="{{ asset("/images/reactions/{$reaction->name}.svg") }}"
                                alt="{{ $reaction->name }} emoji"
                            />
                        @endforeach

                        <span class="text-sm font-medium text-gray-400 dark:text-gray-500">
                            {{ $discussion->getReactionsSummary()->sum('count') }}
                        </span>
                    </div>
                @endif

                <p class="inline-flex space-x-2 text-sm text-gray-500 dark:text-gray-400">
                    <x-untitledui-message-dots-square class="size-5" stroke-width="1.5" aria-hidden="true" />
                    <span class="text-gray-700 dark:text-gray-300">
                        {{ $discussion->count_all_replies_with_child }}
                    </span>
                    <span class="sr-only">{{ __('pages/discussion.total_answer') }}</span>
                </p>
            </div>
        </div>
    @endif
</div>
