<x-layouts.dashboard :user="$this->user">
    <div x-data>
        @can('create', App\Models\Thread::class)
            <div class="flex items-center justify-end">
                <flux:button
                    variant="primary"
                    wire:click="$dispatch('openPanel', { component: 'components.slideovers.thread-form' })"
                    class="border-0"
                >
                    {{ __('global.launch_modal.forum_action') }}
                </flux:button>
            </div>
        @endcan

        <div class="mt-5">
            <div class="space-y-4">
                @foreach ($this->threads as $thread)
                    <x-forum.thread-summary wire:key="thread-{{ $thread->id }}" :$thread>
                        <x-slot name="buttons">
                            @can('update', $thread)
                                <flux:button
                                    size="xs"
                                    variant="ghost"
                                    wire:click="$dispatch('openPanel', { component: 'components.slideovers.thread-form', arguments: {'threadId': {{ $thread->id }}} })"
                                >
                                    {{ __('actions.edit') }}
                                </flux:button>
                            @endcan

                            @can('delete', $thread)
                                <flux:button
                                    size="xs"
                                    variant="danger"
                                    class="border-0"
                                    wire:click="confirmDelete({{ $thread->id }})"
                                >
                                    {{ __('actions.delete') }}
                                </flux:button>
                            @endcan
                        </x-slot>
                    </x-forum.thread-summary>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $this->threads->links() }}
            </div>
        </div>

        <flux:modal name="confirm-delete-thread" class="max-w-md">
            <div>
                <flux:heading size="lg">{{ __('actions.confirm_delete_title') }}</flux:heading>
                <flux:subheading>
                    <p class="mt-2">
                        {{ __('actions.confirm_delete_thread_message') }}
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
