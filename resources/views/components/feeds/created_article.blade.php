@props([
    'activity',
])

@if ($activity->subject->isPublished())
    <li>
        <div class="relative pb-8">
            <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
            <div class="relative flex space-x-3">
                <div>
                    <span
                        class="flex size-8 items-center justify-center rounded-full bg-skin-card-gray ring-8 ring-body"
                    >
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
                                d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"
                            />
                        </svg>
                    </span>
                </div>
                <div class="min-w-0 flex-1">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('a créé l\'article') }}
                            <a
                                href="{{ route('articles.show', $activity->subject) }}"
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
@endif
