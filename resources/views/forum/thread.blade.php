<x-app-layout :title="$thread->subject()" :canonical="route('forum.show', $thread)">
    <x-container class="py-12">
        <div class="relative lg:grid lg:grid-cols-9 lg:gap-10">
            <div class="lg:col-span-7 lg:border-l lg:border-skin-base lg:pl-8">
                <x-forum.thread :thread="$thread" />

                @if ($thread->replies->isNotEmpty())
                    <div class="mt-10">
                        <ul class="space-y-8 sm:px-4" role="list">
                            @foreach ($thread->replies as $reply)
                                <livewire:forum.reply wire:key="$reply->id" :thread="$thread" :reply="$reply" />
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </x-container>
</x-app-layout>
