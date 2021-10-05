@title('Modifier mon article')

@extends('layouts.master')

@section('content')

    <livewire:articles.edit :article="$article" />

@endsection
