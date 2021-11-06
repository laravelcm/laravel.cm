@title(__('Forum'))

@extends('layouts.default')

@section('body')

    <div class="lg:grid lg:grid-cols-12 lg:gap-8">
        <div class="hidden lg:block lg:col-span-2">
            @include('forum._channels')
        </div>

        <div class="lg:col-span-8">

        </div>

        <div class="hidden lg:block lg:col-span-2">
            <x-ads />
        </div>
    </div>

@endsection
