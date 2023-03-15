@props(['activity'])

<li>
    <div class="relative pb-8">
        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
        <div class="relative flex space-x-3">
            <div>
                <span class="h-8 w-8 rounded-full bg-skin-card-gray flex items-center justify-center ring-8 ring-body">
                    <svg class="h-5 w-5 text-skin-inverted-muted" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                </span>
            </div>
            <div class="min-w-0 flex-1">
                <div>
                    <p class="text-sm text-skin-base">
                        {{ __('a démarré une conversation') }}
                        <a href="{{ route('discussions.show', $activity->subject) }}" class="font-medium text-skin-primary hover:text-skin-primary-hover">{{ $activity->subject->title }}</a>
                    </p>
                </div>
                <div class="mt-1.5 text-sm whitespace-nowrap text-skin-muted font-sans">
                    <time datetime="{{ $activity->created_at->format('Y-m-d') }}">{{ $activity->created_at->diffForHumans() }}</time>
                </div>
            </div>
        </div>
    </div>
</li>
