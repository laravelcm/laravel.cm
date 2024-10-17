<x-container class="py-12">
    <div class="relative lg:grid lg:grid-cols-9 lg:gap-8">
        <div class="lg:col-span-2 lg:block">
            <nav class="space-y-6">
                <x-buttons.primary :href="route('forum.new')" class="gap-2 justify-between">
                    {{ __('pages/forum.new_thread') }}
                    <x-untitledui-plus class="size-4" stroke-width="1.5" aria-hidden="true" />
                </x-buttons.primary>
            </nav>
        </div>

        <div class="mt-6 sm:mt-0 lg:col-span-7">
            <div class="flex items-center gap-6">
                <livewire:components.channels-selector />
            </div>

            <div class="mt-6 space-y-6 sm:space-y-5 lg:mb-32">
                @foreach ($threads as $thread)
                    <x-forum.thread-overview :thread="$thread" />
                @endforeach

                <div class="mt-10">
                    {{ $threads->links() }}
                </div>
            </div>
        </div>
    </div>
</x-container>
