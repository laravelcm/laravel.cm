@php
    $isSolution = $thread->isSolutionReply($reply);
@endphp

<li
    x-data="{ open: @entangle('isUpdating') }"
    @class(['relative z-10 rounded-md border border-green-500 p-4 sm:-mx-4' => $isSolution])
>
    <div class="sm:flex sm:space-x-3" id="reply-{{ $reply->id }}">
        <div class="flex items-center font-sans sm:items-start">
            <div class="shrink-0">
                <x-user.avatar :user="$reply->user" class="size-10" />
            </div>
            <div class="ml-4 space-y-1 text-sm sm:hidden">
                <a href="{{ route('profile', $reply->user->username) }}" class="block font-medium text-gray-900">
                    {{ $reply->user->name }}
                    <span class="inline-flex text-skin-muted">{{ '@' . $reply->user->username }}</span>
                </a>
                <time
                    datetime="{{ $reply->created_at }}"
                    title="{{ $thread->created_at->format('j M, Y \à h:i') }}"
                    class="text-skin-muted"
                >
                    {{ $reply->created_at->diffForHumans() }}
                </time>
            </div>
        </div>
        <div x-show="!open" class="flex-1 overflow-hidden">
            <div class="flex items-start">
                <div class="hidden flex-1 space-x-2 font-sans text-sm sm:flex sm:items-center">
                    <a href="{{ route('profile', $reply->user->username) }}" class="font-medium text-gray-900">
                        {{ $reply->user->name }}
                        <span class="inline-flex text-skin-muted">{{ '@' . $reply->user->username }}</span>
                    </a>

                    <x-user.points :author="$reply->user" />

                    <span class="font-medium text-gray-500 dark:text-gray-400">·</span>
                    <time
                        datetime="{{ $reply->created_at }}"
                        title="{{ $thread->created_at->format('j M, Y \à h:i') }}"
                        class="text-skin-muted"
                    >
                        {{ $reply->created_at->diffForHumans() }}
                    </time>

                    @can(App\Policies\ReplyPolicy::UPDATE, $reply)
                        <span class="font-medium text-gray-500 dark:text-gray-400">·</span>
                        <div class="flex items-center divide-x divide-skin-base">
                            <button
                                @click="open = true"
                                type="button"
                                class="pr-2 font-sans text-sm leading-5 text-gray-500 dark:text-gray-400 hover:underline focus:outline-none"
                            >
                                Éditer
                            </button>
                            @if (! $isSolution)
                                <button
                                    wire:click="$dispatch('openModal', { component: 'modals.delete-reply', arguments: {{ json_encode(['id' => $reply->id, 'slug' => $thread->slug()]) }} })"
                                    type="button"
                                    class="pl-2 font-sans text-sm leading-5 text-red-500 hover:underline focus:outline-none"
                                >
                                    Supprimer
                                </button>
                            @endif
                        </div>
                    @endcan
                </div>
                @can(App\Policies\ThreadPolicy::UPDATE, $thread)
                    @if ($isSolution)
                        <div class="mt-2 flex items-center sm:ml-4 sm:mt-0">
                            <button
                                wire:click="UnMarkAsSolution"
                                type="button"
                                class="inline-flex transform items-center justify-center rounded-full bg-red-500 bg-opacity-10 p-2.5 text-sm leading-5 text-red-600 transition-all hover:scale-125 focus:outline-none"
                            >
                                <x-untitledui-x class="size-6" />
                            </button>
                            <span class="ml-2 font-sans text-sm text-red-500 sm:hidden">Retirer comme solution</span>
                        </div>
                    @else
                        <div class="mt-2 flex items-center sm:ml-4 sm:mt-0">
                            <button
                                wire:click="markAsSolution"
                                type="button"
                                class="inline-flex transform items-center justify-center rounded-full bg-green-500 bg-opacity-10 p-2.5 text-sm leading-5 text-green-600 transition-all hover:scale-125 focus:outline-none"
                            >
                                <x-heroicon-s-check-circle class="size-6" />
                            </button>
                            <span class="ml-2 font-sans text-sm text-green-500 sm:hidden">Marquer comme solution</span>
                        </div>
                    @endif
                @else
                    @if ($isSolution)
                        <span
                            class="absolute -top-3 right-3 z-20 ml-4 inline-flex items-center rounded-full bg-green-500 px-3 py-0.5 text-sm font-medium text-green-900"
                        >
                            <x-heroicon-o-check-circle class="mr-1.5 size-4" />
                            Réponse acceptée
                        </span>
                    @endif
                @endcan
            </div>
            <div class="prose prose-green mt-1 overflow-x-auto font-normal text-gray-500 dark:text-gray-400 sm:prose-base sm:max-w-none">
                <x-markdown-content :content="$reply->body" />
            </div>
        </div>
        <div x-show="open" class="flex-1" style="display: none">
            <livewire:editor :body="$body" />

            @error('body')
                <p class="mt-2 text-sm leading-5 text-red-500">
                    {{ $message }}
                </p>
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
