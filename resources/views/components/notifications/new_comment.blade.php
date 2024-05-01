@php($data = $notification->data)

<li>
    <div class="relative pb-8">
        <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
        <div class="relative flex items-start space-x-8">
            <div class="whitespace-nowrap text-sm leading-5 text-skin-base">
                <div class="flex items-center space-x-3">
                    <span class="flex items-center justify-center rounded-full bg-skin-card-gray p-2">
                        <x-untitledui-message-plus-square class="h-5 w-5 text-skin-base" />
                    </span>
                    <div>
                        <p class="text-base font-normal leading-6">
                            Un commentaire a été ajoutée dans la conversation
                            <a
                                href="{{ route('replyable', [$data['replyable_id'], $data['replyable_type']]) }}"
                                class="text-skin-primary hover:text-skin-primary-hover"
                            >
                                "{{ $data['replyable_subject'] }}"
                            </a>
                            .
                        </p>
                        <p class="mt-1 font-sans text-sm leading-5 text-skin-muted">
                            <time-ago time="{{ $notification->created_at->getTimestamp() }}" />
                        </p>
                    </div>
                </div>
            </div>

            <div class="whitespace-nowrap text-right text-sm leading-5 text-skin-base">
                <div class="-mt-3 flex justify-end">
                    <button
                        wire:click="markAsRead('{{ $notification->id }}')"
                        type="button"
                        title="Marquer comme lue"
                        class="inline-flex transform items-center justify-center rounded-full bg-green-500 bg-opacity-10 p-2 text-sm leading-5 text-green-600 transition-all hover:scale-125 focus:outline-none"
                    >
                        <x-heroicon-s-check class="h-5 w-5" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</li>
