@extends('layouts.master')

@section('content')

    <x-layouts.header class="header" />

    <x-container class="flex-1 w-full py-10 max-w-7xl mx-auto px-4">
        @yield('body')
    </x-container>

    @include('layouts.footer')

@endsection
