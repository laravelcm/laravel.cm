@props(['thread', 'reply'])

<li>
    <div class="flex space-x-3" id="reply-{{ $reply->id }}">
        <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full" src="{{ $reply->author->profile_photo_url }}" alt="Avatar de {{ $reply->author->username }}">
        </div>
        <div>
            <div class="flex items-center text-sm space-x-2 font-sans">
                <a href="{{ route('profile', $reply->author->username) }}" class="font-medium text-skin-inverted">{{ $reply->author->name }}</a>
                <span class="text-skin-base font-medium">·</span>
                <time datetime="{{ $reply->created_at }}" title="{{ $thread->created_at->format('j M, Y \à h:i') }}" class="text-skin-muted">{{ $reply->created_at->diffForHumans() }}</time>
            </div>
            <div class="mt-1 font-normal prose prose-base prose-green text-skin-base max-w-none">
                <x-markdown-content :content="$reply->body" />
            </div>
        </div>
    </div>
</li>
