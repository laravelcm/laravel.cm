@extends('layouts.master')

@section('content')

    <x-header class="header" />

    @yield('body')

    @include('layouts.footer')

@endsection
