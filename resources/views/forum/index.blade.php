@php($subTitle = isset($channel) ? $channel->name : null)
@title('Forum' . (isset($subTitle) ? ' > ' . $subTitle : ''))

@extends('layouts.default')

@section('body')

    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="hidden lg:block lg:col-span-2">
            @include('forum._channels')
        </div>

        <div class="space-y-5 lg:col-span-8 xl:col-span-7">
            <x-status-message />

            <livewire:forum.browse :channel="$channel" />
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
