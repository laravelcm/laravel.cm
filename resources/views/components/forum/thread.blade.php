@props([
    'thread',
])

<article class="rounded-xl mb-8 p-6 cursor-pointer bg-white transition duration-200 ease-in-out dark:bg-gray-800 dark:ring-gray-800 dark:hover:bg-white/10 lg:py-5 lg:px-6" aria-labelledby="{{ $thread->slug }}">
    <x-forum.thread-channels :thread="$thread" :displayButton="true" />

    <div class="flex items-center gap-4">
        <h2 id="question-title-{{ $thread->id }}" class="truncate text-xl font-medium text-gray-900 dark:text-white lg:text-xl">
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

    <div class="mt-6 flex justify-between space-x-8">
        <div class="flex items-center gap-2">
            <x-link :href="route('profile', $thread->user->username)" class="group inline-flex items-center gap-1 shrink-0">
                <x-user.avatar :user="$thread->user" class="size-6" />
                <span class="font-medium text-sm text-gray-700 group-hover:underline dark:text-gray-300">
                    {{ '@' . $thread->user->username }}
                </span>
            </x-link>
            <span class="flex items-center text-xs text-gray-500 flex-wrap gap-x-1 dark:text-gray-400">
                <span>{{ __('global.ask') }}</span>
                <time datetime="{{ $thread->created_at }}">
                    {{ $thread->created_at->diffForHumans() }}
                </time>
            </span>
        </div>

        <x-forum.thread-metadata :thread="$thread" />
    </div>
</article>
