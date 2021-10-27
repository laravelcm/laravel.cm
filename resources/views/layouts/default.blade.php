@extends('layouts.master')

@section('content')

    @include('layouts._nav')

    <x-container class="py-10 max-w-7xl mx-auto px-4">
        @yield('body')
    </x-container>

    @include('layouts.footer')

@endsection
