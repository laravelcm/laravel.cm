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
            <x-markdown-content
                class="mt-5 prose prose-sm prose-green !prose-heading-off max-w-none space-y-3 text-gray-500 dark:text-gray-400"
                :content="$reply->body"
            />
            <div class="mt-4 flex items-center justify-between">
                @if(! $thread->isSolutionReply($reply))
                    @can('manage', $reply)
                        <x-filament::dropdown class="inline-flex" placement="top-start">
                            <x-slot name="trigger" class="-mx-2">
                                <button type="button" class="inline-flex items-center rounded-lg px-2 py-1.5 text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900 focus:outline-none">
                                    <x-untitledui-dots-horizontal class="size-5" aria-hidden="true" />
                                </button>
                            </x-slot>

                            <x-filament::dropdown.list>
                                @can('update', $reply)
                                    <x-filament::dropdown.list.item wire:click="openEditModal">
                                        {{ __('actions.edit') }}
                                    </x-filament::dropdown.list.item>
                                @endcan

                                @can('manage', $thread)
                                    <x-filament::dropdown.list.item color="success" wire:click="markAsSolution">
                                        {{ __('pages/forum.mark_answer') }}
                                    </x-filament::dropdown.list.item>
                                @endcan

                                @can('delete', $reply)
                                    <x-filament::dropdown.list.item color="danger" wire:click="openDeleteModal">
                                        {{ __('actions.delete') }}
                                    </x-filament::dropdown.list.item>
                                @endcan
                            </x-filament::dropdown.list>
                        </x-filament::dropdown>
                    @endcan
                @endif
                <div class="opacity-0 group-hover:opacity-100">
                    <button type="button" class="inline-flex items-center rounded-lg text-xs px-2 py-1.5 text-gray-500 dark:text-gray-400 hover:bg-gray-50 hover:text-gray-700 dark:hover:bg-gray-900 dark:hover:text-white focus:outline-none">
                        {{ __('pages/forum.report_spam') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
