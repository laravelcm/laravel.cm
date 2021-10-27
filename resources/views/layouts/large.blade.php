@extends('layouts.master')

@section('content')

    @include('layouts._nav')

    <x-container>
        @yield('body')
    </x-container>

    @include('layouts.footer')

@endsection
