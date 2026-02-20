@php
    $isSolution = $thread->isSolutionReply($reply);
@endphp

<div x-data class="relative pb-8" id="reply-{{ $reply->id }}">
    <span class="hidden absolute left-4 top-5 -ml-px h-full w-0.5 bg-gray-100 dark:bg-white/20 lg:block" aria-hidden="true"></span>
    <div class="relative flex items-start gap-6">
        <div class="hidden sticky lg:block" style="top: calc(4.5rem + var(--banner-height))">
            <x-user.avatar :user="$reply->user" size="sm" />
        </div>
        <div
            @class([
                'group min-w-0 flex-1 rounded-xl p-4 ring-1 ring-inset lg:p-5',
                'ring-green-500 bg-green-50 ring-2 dark:bg-green-800/20 dark:ring-primary-600' => $isSolution,
                'ring-gray-200 bg-white dark:bg-gray-800 dark:ring-white/10' => ! $isSolution,
           ])
        >
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-2">
                    <x-user.avatar :user="$reply->user" class="size-8 lg:hidden" />
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

                @if ($isSolution)
                    <div class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-medium text-white bg-flag-green">
                        {{ __('pages/forum.best_answer') }}
                    </div>
                @endif
            </div>
            <x-markdown-content
                class="mt-2 prose prose-green !prose-heading-off max-w-none space-y-3 text-gray-500 dark:text-gray-400 dark:prose-invert"
                :content="$reply->body"
            />
            <div class="mt-3 flex items-center justify-between">
                @if (! $thread->isSolutionReply($reply))
                    @can('manage', $reply)
                        <flux:dropdown position="top" align="start">
                            <flux:button size="xs" variant="ghost" icon="ellipsis-horizontal" inset="top bottom" />

                            <flux:menu class="min-w-32">
                                @can('update', $reply)
                                    <flux:menu.item wire:click="edit" icon="pencil">
                                        {{ __('actions.edit') }}
                                    </flux:menu.item>
                                @endcan

                                @can('manage', $thread)
                                    <flux:menu.item wire:click="markAsSolution" icon="check-circle">
                                        {{ __('pages/forum.mark_answer') }}
                                    </flux:menu.item>
                                @endcan

                                @can('delete', $reply)
                                    <flux:menu.item wire:click="confirmDelete" icon="trash">
                                        {{ __('actions.delete') }}
                                    </flux:menu.item>
                                @endcan
                            </flux:menu>
                        </flux:dropdown>
                    @endcan

                    @can('report', $reply)
                        <livewire:components.report-spam :model="$reply" />
                    @endcan
                @endif
            </div>
        </div>
    </div>

    <flux:modal name="confirm-delete-reply-{{ $reply->id }}" class="max-w-md">
        <div>
            <flux:heading size="lg">{{ __('actions.confirm_delete_title') }}</flux:heading>
            <flux:subheading>
                <p class="mt-2">
                    {{ __('actions.confirm_delete_reply_message') }}
                </p>
            </flux:subheading>
        </div>

        <div class="mt-6 flex gap-2 justify-end">
            <flux:modal.close>
                <flux:button variant="ghost">{{ __('actions.cancel') }}</flux:button>
            </flux:modal.close>

            <flux:button variant="danger" wire:click="delete">
                {{ __('actions.delete') }}
            </flux:button>
        </div>
    </flux:modal>
</div>
