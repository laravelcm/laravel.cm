@php(($subTitle = isset($channel) ? $channel->name : null))

<x-app-layout :title="__('pages/forum.channel_title', ['channel' => isset($subTitle) ? ' ~ ' . $subTitle : ''])">
    <x-container class="py-12">
        <div class="relative lg:grid lg:grid-cols-9 lg:gap-8">
            <div class="lg:col-span-2 lg:block">
                @include('forum._channels')
            </div>

            <div class="mt-6 space-y-5 sm:mt-0 lg:col-span-7">
                <x-status-message />

                <div class="my-10 space-y-6 sm:space-y-5 lg:mb-32">
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
</x-app-layout>
