@props([
    'discussion',
])

<article class="rounded-xl p-4 bg-white ring-1 ring-gray-200/50 transition duration-200 ease-in-out dark:bg-gray-800 dark:ring-white/10 dark:hover:bg-white/10 lg:p-5" aria-labelledby="{{ $discussion->slug }}">
    <div class="space-y-3">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                @foreach ($discussion->tags as $tag)
                    <x-tag :tag="$tag" href="#" />
                @endforeach
            </div>

            <div class="hidden items-center gap-2 lg:flex">
                @isset($buttons)
                    {{ $buttons }}
                @endisset
            </div>
        </div>
        <h2 class="text-xl font-semibold leading-7 text-gray-900 dark:text-white">
            <x-link :href="route('discussions.show', $discussion)" class="hover:text-primary-600">
                {{ $discussion->title }}
            </x-link>
        </h2>
    </div>
    <p class="mt-3 text-gray-500 dark:text-gray-400">
        {!! $discussion->excerpt(175) !!}
    </p>
    <p class="mt-6 inline-flex items-center gap-2 text-gray-500 dark:text-gray-400">
        <x-untitledui-message-dots-square class="size-5" stroke-width="1.5" aria-hidden="true" />
        <span class="text-gray-700 dark:text-gray-300">
            {{ $discussion->count_all_replies_with_child }}
        </span>
        <span class="sr-only">{{ __('global.answers') }}</span>
    </p>
</article>
