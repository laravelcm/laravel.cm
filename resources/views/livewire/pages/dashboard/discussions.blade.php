<x-layouts.dashboard :user="$this->user">
    <div x-data>
        @can('create', App\Models\Discussion::class)
            <div class="flex items-center justify-end">
                <x-buttons.primary
                    type="button"
                    wire:click="$dispatch('openPanel', { component: 'components.slideovers.discussion-form' })"
                >
                    {{ __('actions.start') }}
                </x-buttons.primary>
            </div>
        @endcan

        <div class="mt-5">
            <div class="space-y-4">
                @forelse ($this->discussions as $discussion)
                    <x-discussions.summary :discussion="$discussion">
                        <x-slot name="buttons">
                            @can('update', $discussion)
                                {{ $this->editAction()(['id' => $discussion->id]) }}
                            @endcan

                            @can('delete', $discussion)
                                {{ $this->deleteAction()(['id' => $discussion->id]) }}
                            @endcan
                        </x-slot>
                    </x-discussions.summary>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ __('pages/discussion.empty_discussion') }}
                    </p>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $this->discussions->links() }}
            </div>
        </div>

        <template x-teleport="#main-site">
            <x-filament-actions::modals />
        </template>
    </div>
</x-layouts.dashboard>
