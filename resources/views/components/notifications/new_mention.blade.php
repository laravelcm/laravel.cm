@php($data = $notification->data)

<li>
    <div class="relative pb-8">
        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
        <div class="relative flex items-start space-x-8">
            <div class="whitespace-nowrap text-sm leading-5 text-skin-base">
                <div class="flex items-center space-x-3">
                    <span class="p-2 flex items-center justify-center rounded-full bg-skin-card-gray">
                        <x-heroicon-s-at-symbol class="w-5 h-5 text-skin-base"/>
                    </span>
                    <div>
                        <p class="font-normal text-base leading-6">
                            <a href="{{ route('profile', $data['author_username']) }}" class="font-medium text-skin-primary">{{ $data['author_name'] }}</a>
                            vous a mentionné dans <a href="{{ route('replyable', [$data['replyable_id'], $data['replyable_type']]) }}" class="text-skin-primary hover:text-skin-primary-hover">"{{ $data['replyable_subject'] }}"</a>.
                        </p>
                        <p class="mt-1 text-sm leading-5 text-skin-muted font-sans">
                            <time-ago time="{{ $notification->created_at->getTimestamp() }}" />
                        </p>
                    </div>
                </div>
            </div>

            <div class="whitespace-nowrap text-sm leading-5 text-skin-base text-right">
                <div class="flex justify-end -mt-3">
                    <button wire:click="markAsRead('{{ $notification->id }}')" type="button" title="Marquer comme lue" class="inline-flex items-center justify-center p-2 bg-green-500 bg-opacity-10 text-green-600 text-sm leading-5 rounded-full focus:outline-none transform hover:scale-125 transition-all">
                        <x-heroicon-s-check class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</li>
