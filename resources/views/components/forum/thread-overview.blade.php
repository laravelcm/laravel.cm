@props([
    'thread',
])

<article class="rounded-xl cursor-pointer bg-white p-4 ring-1 ring-inset ring-gray-200/60 dark:bg-gray-800 dark:ring-white/10 lg:py-5 lg:px-6" aria-labelledby="{{ $thread->slug }}">
    @if (count($channels = $thread->channels->load('parent')))
        <div class="hidden mb-2 lg:flex flex-wrap lg:gap-1.5">
            @foreach ($channels as $channel)
                <x-link href="{{ route('forum.channels', $channel) }}" class="flex gap-2">
                    <x-forum.channel :channel="$channel" class="text-xs" />
                </x-link>
            @endforeach
        </div>
    @endif

    <div class="flex items-center gap-4">
        <h2 id="question-title-{{ $thread->id }}" class="truncate font-medium text-gray-900 dark:text-white lg:text-xl">
            <x-link :href="route('forum.show', $thread)" class="hover:underline">
                {{ $thread->subject() }}
            </x-link>
        </h2>
        @if ($thread->isSolved())
            <x-link
                :href="route('forum.show', $thread->slug). '#' .$thread->solution_reply_id"
                class="inline-flex items-center rounded-xl gap-2 font-medium bg-green-50 ring-1 ring-green-200 text-green-700"
            >
                <x-untitledui-check-verified class="size-5" stroke-width="1.5" aria-hidden="true" />
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
            <span aria-hidden="true">·</span>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                <time-ago time="{{ $thread->created_at->getTimestamp() }}" />
            </span>
        </div>

        <div class="flex items-center gap-2">
            <p class="inline-flex items-center gap-1 text-sm">
                <x-untitledui-message-text-square-02 class="size-5 text-gray-400 dark:text-gray-500" stroke-width="1.5" aria-hidden="true" />
                <span class="text-gray-500 dark:text-gray-400">{{ count($thread->replies) }}</span>
                <span class="sr-only">{{ __('global.answers') }}</span>
            </p>

            <p class="inline-flex items-center gap-1 text-sm">
                <x-untitledui-eye class="size-5 text-gray-400 dark:text-gray-500" stroke-width="1.5" aria-hidden="true" />
                <span class="text-gray-500 dark:text-gray-400">{{ $thread->views_count }}</span>
                <span class="sr-only">{{ __('global.views') }}</span>
            </p>
        </div>
    </div>
</article>
