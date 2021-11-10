@php $isSolution = $thread->isSolutionReply($reply) @endphp

<li>
    <div class="flex space-x-3" id="reply-{{ $reply->id }}">
        <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full" src="{{ $reply->author->profile_photo_url }}" alt="Avatar de {{ $reply->author->username }}">
        </div>
        <div class="flex-1">
            <div class="flex items-start">
                <div class="flex items-center flex-1 text-sm space-x-2 font-sans">
                    <a href="{{ route('profile', $reply->author->username) }}" class="font-medium text-skin-inverted">{{ $reply->author->name }}</a>
                    <span class="text-skin-base font-medium">·</span>
                    <time datetime="{{ $reply->created_at }}" title="{{ $thread->created_at->format('j M, Y \à h:i') }}" class="text-skin-muted">{{ $reply->created_at->diffForHumans() }}</time>
                    @can(App\Policies\ReplyPolicy::UPDATE, $reply)
                        <span class="text-skin-base font-medium">·</span>
                        <div class="flex items-center divide-x divide-skin-base">
                            <button type="button" class="pr-2 text-sm leading-5 font-sans text-skin-base focus:outline-none hover:underline">Éditer</button>
                            @if (! $isSolution)
                                <button wire:click="$emit('openModal', 'modals.delete-reply', {{ json_encode(['id' => $reply->id, 'slug' => $thread->slug()]) }})" type="button" class="pl-2 text-sm leading-5 font-sans text-red-500 focus:outline-none hover:underline">Supprimer</button>
                            @endif
                        </div>
                    @endcan
                </div>
                @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                    @if ($isSolution)
                        <span class="ml-4 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-500 bg-opacity-10 text-green-600">
                            <x-heroicon-o-check-circle class="h-4 w-4 mr-1.5" />
                            Réponse acceptée
                        </span>
                    @else
                        <div class="ml-4">
                            <button wire:click="markAsSolution" type="button" class="inline-flex items-center justify-center p-2.5 bg-green-500 bg-opacity-10 text-green-600 text-sm leading-5 rounded-full focus:outline-none transform hover:scale-125 transition-all">
                                <x-heroicon-s-check-circle class="w-6 h-6" />
                            </button>
                        </div>
                    @endif
                @endcan
            </div>
            <div class="mt-1 font-normal prose prose-base prose-green text-skin-base max-w-none">
                <x-markdown-content :content="$reply->body" />
            </div>
        </div>
    </div>
</li>
