@props([
    'activity',
])

<li>
    <div class="relative pb-8">
        <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
        <div class="relative flex space-x-3">
            <div>
                <span class="flex size-8 items-center justify-center rounded-full bg-skin-card-gray ring-8 ring-body">
                    <svg
                        class="size-5 text-gray-700 dark:text-gray-300"
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
                </span>
            </div>
            <div class="min-w-0 flex-1">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('a démarré une conversation') }}
                        <a
                            href="{{ route('discussions.show', $activity->subject) }}"
                            class="font-medium text-primary-600 hover:text-primary-600-hover"
                        >
                            {{ $activity->subject->title }}
                        </a>
                    </p>
                </div>
                <div class="mt-1.5 whitespace-nowrap font-sans text-sm text-skin-muted">
                    <time datetime="{{ $activity->created_at->format('Y-m-d') }}">
                        {{ $activity->created_at->diffForHumans() }}
                    </time>
                </div>
            </div>
        </div>
    </div>
</li>
