@php(($subTitle = isset($channel) ? $channel->name : null))

<x-app-layout :title="'Forum' . (isset($subTitle) ? ' ~ ' . $subTitle : '')">
    <x-container class="py-12">
        <div class="relative lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="lg:col-span-2 lg:block">
                @include('forum._channels')
            </div>

            <div class="mt-6 space-y-5 sm:mt-0 lg:col-span-8 xl:col-span-7">
                <x-status-message />

                <div class="lg:grid lg:grid-cols-3 lg:gap-10">
                    <div class="hidden items-center lg:flex">
                        <h3 class="font-heading text-xl text-gray-900">
                            {{ number_format($threads->total()) }} Sujets
                        </h3>
                    </div>
                    <div class="lg:col-span-2">
                        <x-forum.filters :filter="$filter" />
                    </div>
                </div>
                <div class="my-10 space-y-6 sm:space-y-5 lg:mb-32">
                    @foreach ($threads as $thread)
                        <x-forum.thread-overview :thread="$thread" />
                    @endforeach

                    <div class="mt-10">
                        {{ $threads->links() }}
                    </div>
                </div>
            </div>

            <div class="relative mt-10 hidden lg:col-span-2 lg:block xl:col-span-3">
                <x-sticky-content class="space-y-10">
                    <x-sponsors />

                    <x-ads />

                    @include('forum._moderators')
                </x-sticky-content>
            </div>
        </div>
    </x-container>
</x-app-layout>
