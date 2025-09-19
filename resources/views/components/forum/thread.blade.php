@props([
    'thread',
    'withAuthor' => true,
])

<article class="rounded-xl p-4 bg-white ring-1 ring-gray-200/50 transition duration-200 ease-in-out dark:bg-gray-800 dark:ring-white/10 dark:hover:bg-white/10 lg:p-5" aria-labelledby="{{ $thread->slug }}">
    <x-forum.thread-channels :$thread />

    <div class="flex items-center gap-4">
        <h2 id="question-title-{{ $thread->id }}" class="truncate font-heading/7 font-semibold text-gray-900 dark:text-white lg:text-lg">
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
            @if ($withAuthor)
                <x-link :href="route('profile', $thread->user)" class="group inline-flex items-center gap-1 shrink-0">
                    <x-user.avatar :user="$thread->user" class="size-6" />
                    <span class="font-medium text-sm text-gray-700 group-hover:underline dark:text-gray-300">
                        {{ '@' . $thread->user->username }}
                    </span>
                </x-link>
            @endif

            <span class="flex items-center text-xs text-gray-500 flex-wrap gap-1 dark:text-gray-400">
                <span class="hidden lg:inline">{{ __('global.ask') }}</span>
                <time datetime="{{ $thread->created_at }}">
                    {{ $thread->created_at->diffForHumans() }}
                </time>
            </span>
        </div>

        <x-forum.thread-metadata :$thread />
    </div>
</article>
