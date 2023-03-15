@props(['activity'])

@if($activity->subject->isPublished())
    <li>
        <div class="relative pb-8">
            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
            <div class="relative flex space-x-3">
                <div>
                    <span class="h-8 w-8 rounded-full bg-skin-card-gray flex items-center justify-center ring-8 ring-body">
                        <svg class="h-5 w-5 text-skin-inverted-muted" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                        </svg>
                    </span>
                </div>
                <div class="min-w-0 flex-1">
                    <div>
                        <p class="text-sm text-skin-base">
                            {{ __('a créé l\'article') }}
                            <a href="{{ route('articles.show', $activity->subject) }}" class="font-medium text-skin-primary hover:text-skin-primary-hover">{{ $activity->subject->title }}</a>
                        </p>
                    </div>
                    <div class="mt-1.5 text-sm whitespace-nowrap text-skin-muted font-sans">
                        <time datetime="{{ $activity->created_at->format('Y-m-d') }}">
                            {{ $activity->created_at->diffForHumans() }}
                        </time>
                    </div>
                </div>
            </div>
        </div>
    </li>
@endif
