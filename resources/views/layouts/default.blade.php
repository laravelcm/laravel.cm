@extends('layouts.master')

@section('content')

    @include('layouts._nav')

    <main class="py-10 relative max-w-7xl mx-auto px-4 sm:px-6 z-0">
        @yield('body')
    </main>

    @include('layouts.footer')

@endsection
