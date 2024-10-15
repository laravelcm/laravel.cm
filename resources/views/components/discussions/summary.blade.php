@props([
    'discussion',
])

<div class="border-b border-skin-base py-6">
    <div class="mt-2 lg:flex lg:items-center lg:justify-between">
        <div class="flex-1">
            <h2 class="font-sans text-xl font-semibold leading-7 text-gray-900">
                <a href="{{ route('discussions.show', $discussion) }}" class="hover:text-primary-600">
                    {{ $discussion->title }}
                </a>
            </h2>
        </div>
        <div class="mt-2 shrink-0 self-start lg:mt-0">
            @if (count($tags = $discussion->tags))
                <div class="flex flex-wrap gap-2 lg:gap-x-3">
                    @foreach ($tags as $tag)
                        <x-tag :tag="$tag" />
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <p class="mt-1 text-sm font-normal leading-5 text-gray-500 dark:text-gray-400">
        {!! $discussion->excerpt(175) !!}
    </p>
    <div class="mt-3 flex justify-between">
        <div class="flex items-center font-sans text-sm text-skin-muted">
            <a class="shrink-0" href="{{ route('profile', $discussion->user->username) }}">
                <x-user.avatar :user="$discussion->user" class="size-6" />
            </a>
            <span class="ml-2 pr-1">{{ __('Posté par') }}</span>
            <div class="flex items-center space-x-1">
                <a
                    href="{{ route('profile', $discussion->user->username) }}"
                    class="text-gray-900 hover:underline"
                >
                    {{ $discussion->user->name }}
                </a>
                <span aria-hidden="true">&middot;</span>
                <time-ago time="{{ $discussion->created_at->getTimestamp() }}" />
            </div>
        </div>
        <div class="flex items-center space-x-4 text-sm">
            <p class="inline-flex space-x-2 text-gray-500 dark:text-gray-400">
                <svg
                    class="size-5"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"
                    />
                </svg>
                <span class="font-normal text-gray-700 dark:text-gray-300">
                    {{ $discussion->count_all_replies_with_child }}
                </span>
                <span class="sr-only">{{ __('réponses') }}</span>
            </p>
            <a
                href="{{ route('discussions.edit', $discussion->slug()) }}"
                class="inline-flex items-center font-normal text-gray-700 dark:text-gray-300 hover:text-gray-500 dark:text-gray-400 hover:underline"
            >
                <svg
                    class="mr-1.5 size-4"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
                    />
                </svg>
                {{ __('Éditer') }}
            </a>
        </div>
    </div>
</div>
