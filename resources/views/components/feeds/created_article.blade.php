@props(['activity'])

@if($activity->subject->isPublished())
    <li>
        <div class="relative pb-8">
            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
            <div class="relative flex space-x-3">
                <div>
                    <span class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-body">
                        <x-heroicon-o-newspaper class="h-5 w-5 text-white" />
                    </span>
                </div>
                <div class="min-w-0 flex-1">
                    <div>
                        <p class="text-sm text-skin-base">a créé l'article <a href="{{ route('articles.show', $activity->subject) }}" class="font-medium text-skin-primary hover:text-skin-primary-hover">{{ $activity->subject->title }}</a></p>
                    </div>
                    <div class="mt-1.5 text-sm whitespace-nowrap text-skin-base font-sans">
                        <time datetime="{{ $activity->created_at->format('Y-m-d') }}">{{ $activity->created_at->diffForHumans() }}</time>
                    </div>
                </div>
            </div>
        </div>
    </li>
@endif
