<x-layouts.dashboard :user="$this->user">
    <div x-data>
        <div class="flex items-center justify-end">
            @can('create', App\Models\Thread::class)
                <x-buttons.primary
                    type="button"
                    wire:click="$dispatch('openPanel', { component: 'components.slideovers.thread-form' })"
                >
                    {{ __('global.launch_modal.forum_action') }}
                </x-buttons.primary>
            @endcan
        </div>
        <div class="mt-5">
            <div class="space-y-4">
                @foreach ($this->threads as $thread)
                    <x-forum.thread-summary :$thread>
                        <x-slot name="buttons">
                            @can('update', $thread)
                                {{ $this->editAction()(['id' => $thread->id]) }}
                            @endcan

                            @can('delete', $thread)
                                {{ $this->deleteAction()(['id' => $thread->id]) }}
                            @endcan
                        </x-slot>
                    </x-forum.thread-summary>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $this->threads->links() }}
            </div>
        </div>

        <template x-teleport="#main-site">
            <x-filament-actions::modals />
        </template>
    </div>
</x-layouts.dashboard>
