@php $isSolution = $thread->isSolutionReply($reply) @endphp

<li x-data="{ open: @entangle('isUpdating') }" @class(['sm:-mx-4 p-4 border border-green-500 rounded-md relative z-10' => $isSolution])>
    <div class="sm:flex sm:space-x-3" id="reply-{{ $reply->id }}">
        <div class="flex items-center font-sans sm:items-start">
            <div class="flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="{{ $reply->author->profile_photo_url }}" alt="Avatar de {{ $reply->author->username }}">
            </div>
            <div class="ml-4 text-sm space-y-1 sm:hidden">
                <a href="{{ route('profile', $reply->author->username) }}" class="block font-medium text-skin-inverted">
                    {{ $reply->author->name }} <span class="inline-flex text-skin-muted">{{ '@' . $reply->author->username }}</span>
                </a>
                <time datetime="{{ $reply->created_at }}" title="{{ $thread->created_at->format('j M, Y \à h:i') }}" class="text-skin-muted">{{ $reply->created_at->diffForHumans() }}</time>
            </div>
        </div>
        <div x-show="!open" class="flex-1">
            <div class="flex items-start">
                <div class="hidden sm:flex sm:items-center flex-1 text-sm space-x-2 font-sans">
                    <a href="{{ route('profile', $reply->author->username) }}" class="font-medium text-skin-inverted">
                        {{ $reply->author->name }} <span class="inline-flex text-skin-muted">{{ '@' . $reply->author->username }}</span>
                    </a>
                    <span class="text-skin-base font-medium">·</span>
                    <time datetime="{{ $reply->created_at }}" title="{{ $thread->created_at->format('j M, Y \à h:i') }}" class="text-skin-muted">{{ $reply->created_at->diffForHumans() }}</time>
                    @can(App\Policies\ReplyPolicy::UPDATE, $reply)
                        <span class="text-skin-base font-medium">·</span>
                        <div class="flex items-center divide-x divide-skin-base">
                            <button @click="open = true" type="button" class="pr-2 text-sm leading-5 font-sans text-skin-base focus:outline-none hover:underline">Éditer</button>
                            @if (! $isSolution)
                                <button wire:click="$emit('openModal', 'modals.delete-reply', {{ json_encode(['id' => $reply->id, 'slug' => $thread->slug()]) }})" type="button" class="pl-2 text-sm leading-5 font-sans text-red-500 focus:outline-none hover:underline">Supprimer</button>
                            @endif
                        </div>
                    @endcan
                </div>
                @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                    @if ($isSolution)
                        <div class="mt-2 flex items-center sm:mt-0 sm:ml-4 sm:-mt-3">
                            <button wire:click="UnMarkAsSolution" type="button" class="inline-flex items-center justify-center p-2.5 bg-red-500 bg-opacity-10 text-red-600 text-sm leading-5 rounded-full focus:outline-none transform hover:scale-125 transition-all">
                                <x-heroicon-s-x-circle class="w-6 h-6" />
                            </button>
                            <span class="ml-2 text-sm font-sans text-red-500 sm:hidden">Retirer comme solution</span>
                        </div>
                    @else
                        <div class="mt-2 flex items-center sm:mt-0 sm:ml-4 sm:-mt-3">
                            <button wire:click="markAsSolution" type="button" class="inline-flex items-center justify-center p-2.5 bg-green-500 bg-opacity-10 text-green-600 text-sm leading-5 rounded-full focus:outline-none transform hover:scale-125 transition-all">
                                <x-heroicon-s-check-circle class="w-6 h-6" />
                            </button>
                            <span class="ml-2 text-sm font-sans text-green-500 sm:hidden">Marquer comme solution</span>
                        </div>
                    @endif
                @else
                    @if($isSolution)
                        <span class="absolute -top-3 z-20 right-3 ml-4 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-500 text-green-900">
                            <x-heroicon-o-check-circle class="h-4 w-4 mr-1.5" />
                            Réponse acceptée
                        </span>
                    @endif
                @endcan
            </div>
            <div class="mt-1 font-normal prose sm:prose-base prose-green text-skin-base overflow-x-auto sm:max-w-none">
                <x-markdown-content :content="$reply->body" />
            </div>
        </div>
        <div x-show="open" class="flex-1" style="display: none">
            <livewire:editor :body="$body" />

            @error('body')
                <p class="mt-2 text-sm text-red-500 leading-5 font-normal">{{ $message }}</p>
            @enderror

            <div class="mt-5">
                <div class="flex justify-end space-x-3">
                    <x-default-button type="button" class="inline-flex" x-on:click="open = false">
                        Annuler
                    </x-default-button>
                    <x-button type="button" class="inline-flex" wire:click="edit">
                        <x-loader class="text-white" wire:loading wire:target="edit" />
                        Enregistrer
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</li>
