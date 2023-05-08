@props(['thread'])

<div class="bg-skin-card px-4 py-6 rounded-lg shadow sm:p-6">
    <article aria-labelledby="question-title-{{ $thread->id }}">
        <div>
            <div class="lg:flex lg:space-x-3">
                <div class="flex-1 flex items-center space-x-3">
                    <div class="shrink-0">
                        <x-user.avatar :user="$thread->user" class="h-8 w-8" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-skin-inverted">
                            <a href="{{ route('profile', $thread->user->username) }}" class="block group">
                                <span class="group-hover:underline">{{ $thread->user->name }}</span>
                                <span class="text-skin-muted">{{ '@'. $thread->user->username }}</span>
                            </a>
                        </p>
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
            <h2 id="question-title-{{ $thread->id }}" class="mt-4 text-base font-medium text-skin-inverted">
                <a href="{{ route('forum.show', $thread) }}" class="hover:underline">{{ $thread->subject() }}</a>
            </h2>
        </div>
        <div class="mt-2 text-sm text-skin-inverted-muted">
            <a href="{{ route('forum.show', $thread) }}">{!! $thread->excerpt() !!}</a>
        </div>
        <div class="mt-6 flex justify-between space-x-8">
            <div class="flex items-center space-x-4">
                <livewire:reactions :model="$thread" :with-place-holder="false" :with-background="false"/>
                <p class="inline-flex text-sm space-x-2 text-skin-base">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                    <span class="text-skin-inverted-muted">{{ count($thread->replies) }}</span>
                    <span class="sr-only">{{ __('réponses') }}</span>
                </p>
                <p class="inline-flex text-sm space-x-2 text-skin-base">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-skin-inverted-muted">{{ $thread->views_count }}</span>
                    <span class="sr-only">{{ __('vues') }}</span>
                </p>
            </div>
            <div class="flex text-sm">
                <p class="inline-flex items-center space-x-3 text-sm">
                    @if ($thread->isSolved())
                        <a href="{{ route('forum.show', $thread->slug) }}#{{ $thread->solution_reply_id }}" class="flex items-center gap-x-2 font-medium text-green-500">
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
