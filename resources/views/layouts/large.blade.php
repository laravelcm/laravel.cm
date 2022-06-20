@extends('layouts.master')

@section('content')

    <x-layouts.header class="header" />

    <x-container>
        @yield('body')
    </x-container>

    @include('layouts.footer')

@endsection
