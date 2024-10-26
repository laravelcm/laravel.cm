@php
    $isSolution = $thread->isSolutionReply($reply);
@endphp

<div class="relative pb-8" id="reply-{{ $reply->id }}">
    <span class="hidden absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-100 dark:bg-white/20 lg:block" aria-hidden="true"></span>
    <div class="relative flex items-start gap-6">
        <div class="hidden sticky top-10 lg:block">
            <x-user.avatar
                :user="$reply->user"
                class="size-10 ring-4 ring-white dark:ring-white/20"
                span="-right-1 size-3.5 -top-1"
            />
        </div>
        <div
            @class([
                'group min-w-0 flex-1 rounded-xl p-5 ring-1 ring-inset lg:py-6 lg:px-8',
                'ring-green-500 bg-green-50 ring-2 dark:bg-green-800/20 dark:ring-primary-600' => $isSolution,
                'ring-gray-200/60 bg-white dark:bg-gray-800 dark:ring-white/10' => ! $isSolution,
           ])
        >
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-2">
                    <x-user.avatar
                        :user="$reply->user"
                        class="size-8 lg:hidden"
                        span="-right-1 size-3.5 -top-1"
                    />
                    <div>
                        <div class="text-sm flex items-center gap-2">
                            <x-link :href="route('profile', $reply->user->username)" class="font-medium text-gray-900 dark:text-white">
                                {{ $reply->user->username }}
                            </x-link>
                            <x-user.points class="ring-1 ring-inset ring-gray-200 dark:ring-white/10" :author="$reply->user" />
                        </div>
                        <div class="flex items-center text-xs text-gray-500 flex-wrap gap-x-1 dark:text-gray-400 lg:mt-1">
                            <span>{{ __('global.posted') }}</span>
                            <time datetime="{{ $reply->created_at }}">
                                {{ $reply->created_at->diffForHumans() }}
                            </time>
                        </div>
                    </div>
                </div>
                @if($isSolution)
                    <div class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-medium text-white bg-flag-green">
                        {{ __('pages/forum.best_answer') }}
                    </div>
                @endif
            </div>
            <div class="mt-5 prose prose-green max-w-none text-gray-500 dark:text-gray-400 dark:prose-invert">
                <x-markdown-content :content="$reply->body" />
            </div>
            <div class="mt-10">
                @can('manage', $reply)
                    <x-filament::dropdown placement="top-start">
                        <x-slot name="trigger">
                            <button type="button" class="inline-flex items-center rounded-lg px-2 py-1.5 text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900 focus:outline-none">
                                <x-untitledui-dots-horizontal class="size-5" aria-hidden="true" />
                            </button>
                        </x-slot>

                        <x-filament::dropdown.list>
                            <x-filament::dropdown.list.item wire:click="openEditModal">
                                {{ __('actions.edit') }}
                            </x-filament::dropdown.list.item>

                            <x-filament::dropdown.list.item color="danger" wire:click="openDeleteModal">
                                {{ __('actions.delete') }}
                            </x-filament::dropdown.list.item>
                        </x-filament::dropdown.list>
                    </x-filament::dropdown>
                @endcan
                <div class="hidden group-hover:flex"></div>
            </div>
        </div>
    </div>
</div>

{{--<li
    x-data="{ open: @entangle('isUpdating') }"
    @class(['relative z-10 rounded-md border border-green-500 p-4 sm:-mx-4' => $isSolution])
>
    <div class="sm:flex sm:space-x-3">
        <div x-show="!open" class="flex-1 overflow-hidden">
            <div class="flex items-start">
                <div class="hidden flex-1 space-x-2 font-sans text-sm sm:flex sm:items-center">
                    @can('update', $reply)
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
                @can('update', $thread)
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
                    <x-buttons.default type="button" class="inline-flex" x-on:click="open = false">
                        Annuler
                    </x-buttons.default>
                    <x-buttons.primary type="button" class="inline-flex" wire:click="edit">
                        <x-loader class="text-white" wire:loading wire:target="edit" />
                        Enregistrer
                    </x-buttons.primary>
                </div>
            </div>
        </div>
    </div>
</li>--}}
