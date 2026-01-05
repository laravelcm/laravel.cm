<x-layouts.dashboard :user="$this->user">
    <div x-data>
        @can('create', App\Models\Discussion::class)
            <div class="flex items-center justify-end">
                <flux:button
                    variant="primary"
                    wire:click="$dispatch('openPanel', { component: 'components.slideovers.discussion-form' })"
                    class="border-0"
                >
                    {{ __('actions.start') }}
                </flux:button>
            </div>
        @endcan

        <div class="mt-5">
            <div class="space-y-4">
                @forelse ($this->discussions as $discussion)
                    <x-discussions.summary wire:key="discussion-{{ $discussion->id }}" :discussion="$discussion">
                        <x-slot name="buttons">
                            @can('update', $discussion)
                                <flux:button
                                    size="xs"
                                    variant="ghost"
                                    wire:click="$dispatch('openPanel', { component: 'components.slideovers.discussion-form', arguments: {'discussionId': {{ $discussion->id }}} })"
                                >
                                    {{ __('actions.edit') }}
                                </flux:button>
                            @endcan

                            @can('delete', $discussion)
                                <flux:button
                                    size="xs"
                                    variant="danger"
                                    class="border-0"
                                    wire:click="confirmDelete({{ $discussion->id }})"
                                >
                                    {{ __('actions.delete') }}
                                </flux:button>
                            @endcan
                        </x-slot>
                    </x-discussions.summary>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ __('pages/discussion.empty_discussion') }}
                    </p>
                @endforelse
            </div>

            <div class="py-10">
                {{ $this->discussions->links() }}
            </div>
        </div>

        <flux:modal name="confirm-delete-discussion" class="max-w-md">
            <div>
                <flux:heading size="lg">{{ __('actions.confirm_delete_title') }}</flux:heading>
                <flux:subheading>
                    <p class="mt-2">
                        {{ __('actions.confirm_delete_discussion_message') }}
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
</x-layouts.dashboard>
