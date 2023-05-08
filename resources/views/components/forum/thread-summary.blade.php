@props(['thread'])

<div class="py-6 border-b border-skin-base">
    <article aria-labelledby="question-title-{{ $thread->id }}">
        <div>
            <div class="lg:flex lg:space-x-3">
                <div class="flex-1 flex items-center space-x-3">
                    <div class="shrink-0">
                        <x-user.avatar :user="$thread->user" class="h-8 w-8" />
                    </div>
                    <div class="min-w-0 flex-1 flex items-center space-x-1 font-sans">
                        <p class="text-sm font-medium text-skin-inverted">
                            <a href="{{ route('profile', $thread->user->username) }}" class="block group">
                                <span class="group-hover:underline">{{ $thread->user->name }}</span>
                                <span class="text-skin-muted">{{ '@'. $thread->user->username }}</span>
                            </a>
                        </p>
                        <span aria-hidden="true">&middot;</span>
                        <p class="text-sm text-skin-base">
                            <time-ago time="{{ $thread->created_at->getTimestamp() }}"/>
                        </p>
                    </div>
                </div>
                <div class="mt-2 lg:mt-0 shrink-0 self-center">
                    @if (count($channels = $thread->channels->load('parent')))
                        <div class="flex flex-wrap gap-2 mt-2 lg:mt-0 lg:gap-x-3">
                            @foreach ($channels as $channel)
                                <a href="{{ route('forum.channels', $channel) }}" class="flex gap-2">
                                    <x-forum.channel :channel="$channel" />
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <h2 id="question-title-{{ $thread->id }}" class="mt-4 text-base font-medium text-skin-inverted font-sans">
                <a href="{{ route('forum.show', $thread) }}" class="hover:underline">{{ $thread->subject() }}</a>
            </h2>
        </div>
        <div class="mt-2 text-sm text-skin-inverted-muted font-normal">
            <a href="{{ route('forum.show', $thread) }}">{!! $thread->excerpt() !!}</a>
        </div>
        <div class="mt-6 flex justify-between space-x-8">
            <div class="flex items-center space-x-4">
                <div class="flex items-center text-sm text-skin-inverted-muted font-normal">
                    <span class="text-base mr-2">👏</span>
                    {{ count($thread->reactions) }}
                </div>
                <p class="inline-flex text-sm space-x-2 text-skin-base">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                    <span class="font-normal text-skin-inverted-muted">{{ count($thread->replies) }}</span>
                    <span class="sr-only">{{ __('réponses') }}</span>
                </p>
            </div>
            <div class="flex text-sm">
                <p class="inline-flex items-center space-x-3 text-sm">
                    @if ($thread->isSolved())
                        <a href="{{ route('forum.show', $thread->slug) }}#reply-{{ $thread->solution_reply_id }}" class="flex items-center gap-x-2 font-medium text-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                            <span class="hover:underline">{{ __('Résolu') }}</span>
                        </a>
                    @endif
                </p>
            </div>
        </div>
    </article>
</div>
