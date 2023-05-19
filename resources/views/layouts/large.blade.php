@extends('layouts.master')

@section('content')

    <x-layouts.header class="header" />

    @yield('body')

    @include('layouts.footer')

@endsection
