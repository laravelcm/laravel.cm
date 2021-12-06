@php($subTitle = isset($channel) ? $channel->name : null)
@title('Forum' . (isset($subTitle) ? ' ~ ' . $subTitle : ''))

@extends('layouts.default')

@section('body')

    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="lg:block lg:col-span-2">
            @include('forum._channels')
        </div>

        <div class="mt-6 space-y-5 sm:mt-0 lg:col-span-8 xl:col-span-7">
            <x-status-message />

            <div class="lg:grid lg:grid-cols-3 lg:gap-10">
                <div class="hidden lg:flex items-center">
                    <h3 class="text-skin-inverted text-xl">
                        {{ number_format($threads->total()) }} Sujets
                    </h3>
                </div>
                <div class="lg:col-span-2">
                    <x-forum.filters :filter="$filter" />
                </div>
            </div>
            <div class="my-10 lg:mb-32 space-y-6 sm:space-y-5">
                @foreach ($threads as $thread)
                    <x-forum.thread-overview :thread="$thread" />
                @endforeach

                <div class="mt-10">
                    {{ $threads->links() }}
                </div>
            </div>
        </div>

        <div class="hidden lg:block lg:col-span-2 xl:col-span-3">
            <aside class="sticky top-4 space-y-10 mt-10">
                <x-sponsors />

                <x-ads />

                @include('forum._moderators')
            </aside>
        </div>
    </div>

@endsection
