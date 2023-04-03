<li class="comment" id="c{{ $comment->id }}">
    <div class="relative pb-2">
        @if($comment->allChildReplies->isNotEmpty())
            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-card-gray" aria-hidden="true"></span>
        @endif
        <div class="relative flex space-x-3">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="{{ $comment->user->profile_photo_url }}" alt=""/>
            </div>
            <div class="flex-1">
                <div class="text-sm sm:flex sm:items-center">
                    <a href="{{ route('profile', $comment->user->username) }}" class="font-medium text-skin-primary font-sans hover:text-skin-primary-hover">
                        {{ $comment->user->name }}
                    </a>
                    <span class="mx-1.5 inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-skin-card-gray text-skin-inverted-muted">
                        {{ $comment->user->getPoints() }} XP
                    </span>
                    <span wire:ignore class="text-sm text-skin-base font-normal mx-2">
                        <time-ago time="{{ $comment->created_at->getTimestamp() }}" />
                    </span>
                    @can(App\Policies\ReplyPolicy::UPDATE, $comment)
                        <div class="mt-1 flex sm:mt-0">
                            <span class="hidden sm:inline-block text-skin-base font-medium">·</span>
                            <div class="pl-2 flex items-center divide-x divide-skin-base space-x-2">
                                <button type="button" wire:click="delete" class="inline-flex items-center text-sm leading-5 font-sans text-red-500 focus:outline-none hover:underline">{{ __('Supprimer') }}</button>
                            </div>
                        </div>
                    @endcan
                </div>
                <x-markdown-content :content="$comment->body" class="mt-2 text-sm text-skin-base prose prose-green font-normal max-w-none"/>
                <div class="mt-4 text-sm space-x-4">
                    <button
                        type="button"
                        wire:click="toggleLike"
                        @class([
                            'inline-flex items-center justify-center text-sm font-normal hover:text-rose-500',
                            'text-rose-500' => $count > 0,
                            'text-skin-base' => $count === 0,
                        ])
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="-ml-1 mr-2 h-5 w-5 fill-current">
                            <path opacity="0.4" d="M11.776 21.837a36.258 36.258 0 01-6.328-4.957 12.668 12.668 0 01-3.03-4.805C1.278 8.535 2.603 4.49 6.3 3.288A6.282 6.282 0 0112.007 4.3a6.291 6.291 0 015.706-1.012c3.697 1.201 5.03 5.247 3.893 8.787a12.67 12.67 0 01-3.013 4.805 36.58 36.58 0 01-6.328 4.957l-.25.163-.24-.163z"/>
                            <path d="M12.01 22l-.234-.163a36.316 36.316 0 01-6.337-4.957 12.667 12.667 0 01-3.048-4.805c-1.13-3.54.195-7.585 3.892-8.787a6.296 6.296 0 015.728 1.023V22zM18.23 10a.719.719 0 01-.517-.278.818.818 0 01-.167-.592c.022-.702-.378-1.342-.994-1.59-.391-.107-.628-.53-.53-.948.093-.41.477-.666.864-.573a.384.384 0 01.138.052c1.236.476 2.036 1.755 1.973 3.155a.808.808 0 01-.23.56.708.708 0 01-.537.213z"/>
                        </svg>
                        <span class="mr-1.5">{{ $count }}</span> Like
                    </button>
                </div>
            </div>
        </div>
    </div>
</li>
