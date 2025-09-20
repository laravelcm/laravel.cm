@props([
    'discussion',
    'withAuthor' => true,
])

<div class="py-6">
    @if ($discussion->tags->isNotEmpty())
        <div class="flex items-center gap-2">
            <div class="flex-1">
                @foreach ($discussion->tags as $tag)
                    <x-tag
                        :tag="$tag"
                        :href="route('discussions.index', ['tag' => $tag->slug])"
                    />
                @endforeach
            </div>
        </div>
    @endif

    <h2 class="mt-4 font-heading/7 text-xl font-semibold text-gray-900 dark:text-white">
        <x-link :href="route('discussions.show', $discussion)" class="hover:text-primary-600">
            {{ $discussion->title }}
        </x-link>
    </h2>
    <p class="mt-2 text-gray-500 dark:text-gray-300 line-clamp-2">
        {!! $discussion->excerpt(175) !!}
    </p>

    <div class="mt-4 sm:flex sm:justify-between">
        <div class="flex items-center gap-3 text-sm text-gray-700 dark:text-gray-300">
            @if ($withAuthor)
                <div class="flex items-center gap-2">
                    <x-user.avatar
                        :user="$discussion->user"
                        class="size-6"
                        span="-right-1 -top-1 ring-1 size-4"
                    />
                </div>
                <x-link
                    :href="route('profile', $discussion->user)"
                    class="text-gray-700 dark:text-gray-300 font-medium hover:underline"
                >
                    {{ $discussion->user->name }}
                </x-link>
                <span aria-hidden="true">&middot;</span>
            @endif
            <time class="truncate text-sm text-gray-500 dark:text-gray-400" datetime="{{ $discussion->created_at }}">
                {{ $discussion->created_at->diffForHumans() }}
            </time>
        </div>
        <div class="hidden space-x-3 sm:flex sm:items-center">
            @if ($discussion->reactions_count > 0)
                <p class="inline-flex items-center text-sm justify-center gap-2">
                    <x-untitledui-heart class="size-5 text-gray-500 dark:text-gray-400" stroke-width="1.5" aria-hidden="true" />
                    <span class="text-gray-700 font-mono proportional-nums slashed-zero dark:text-gray-300">
                        {{ $discussion->reactions_count }}
                    </span>
                </p>
            @endif

            <p class="inline-flex space-x-2 text-sm text-gray-500 dark:text-gray-400">
                <x-untitledui-message-dots-square class="size-5" stroke-width="1.5" aria-hidden="true" />
                <span class="text-gray-700 font-mono proportional-nums slashed-zero dark:text-gray-300">
                    {{ $discussion->replies_count }}
                </span>
                <span class="sr-only">{{ __('pages/discussion.total_answer') }}</span>
            </p>
        </div>
    </div>
</div>
