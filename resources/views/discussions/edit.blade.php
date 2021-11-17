@title('Modifier mon sujet')

@extends('layouts.master')

@section('content')

    <livewire:discussions.edit :discussion="$discussion" />

@endsection
