@props([
    'activity',
])

<li>
    <div class="relative pb-8">
        <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
        <div class="relative flex space-x-3">
            <div>
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-skin-card-gray ring-8 ring-body">
                    <svg
                        class="h-5 w-5 text-skin-inverted-muted"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"
                        />
                    </svg>
                </span>
            </div>
            <div class="min-w-0 flex-1">
                <div>
                    <p class="text-sm text-skin-base">
                        a lancé le sujet
                        <a
                            href="{{ route('forum.show', $activity->subject) }}"
                            class="font-medium text-skin-primary hover:text-skin-primary-hover"
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
