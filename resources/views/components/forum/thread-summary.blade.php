@props([
    'thread',
])

<article class="rounded-xl p-4 bg-white ring-1 ring-gray-200/50 transition duration-200 ease-in-out dark:bg-gray-800 dark:ring-white/10 dark:hover:bg-white/10 lg:p-5" aria-labelledby="{{ $thread->slug }}">
    <div class="flex items-center justify-between gap-4">
        <x-forum.thread-channels :thread="$thread" />
        <div class="hidden items-center gap-2 lg:flex">
            @isset($buttons)
                {{ $buttons }}
            @endisset
        </div>
    </div>

    <div class="flex items-center gap-4">
        <h2 id="question-{{ $thread->id }}" class="truncate text-xl font-medium text-gray-900 dark:text-white lg:text-xl">
            <x-link :href="route('forum.show', $thread)" class="hover:underline">
                {{ $thread->subject() }}
            </x-link>
        </h2>

        @if ($thread->isSolved())
            <x-link
                :href="route('forum.show', $thread->slug). '#' .$thread->solution_reply_id"
                class="inline-flex items-center rounded-xl gap-1 px-2 py-0.5 font-medium bg-primary-50 ring-1 ring-primary-200 text-primary-700 dark:bg-primary-800/20 dark:text-primary-500 dark:ring-primary-800"
            >
                <x-untitledui-check-verified class="size-3.5 text-primary-600" stroke-width="1.5" aria-hidden="true" />
                <span class="text-xs">{{ __('pages/forum.navigation.solve') }}</span>
            </x-link>
        @endif
    </div>

    <div class="mt-2 text-sm text-gray-700 line-clamp-2 dark:text-gray-300">
        <x-link :href="route('forum.show', $thread)">{!! $thread->excerpt() !!}</x-link>
    </div>

    <div class="mt-6">
        <x-forum.thread-metadata :thread="$thread" />
    </div>
</article>
