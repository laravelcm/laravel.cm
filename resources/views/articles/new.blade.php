@title('Creer un nouvel article')

@extends('layouts.master')

@section('content')

    <form action="{{ route('articles.store') }}" method="POST">
        @csrf
        <div x-data>
            <nav class="sm:flex sm:items-center justify-between py-4 px-4 sm:px-6">
                <div class="flex items-center divide-x divide-skin-light space-x-3">
                    <a href="{{ route('articles') }}" class="flex items-center font-sans text-skin-primary text-base font-medium hover:text-skin-primary-hover">
                        <x-heroicon-o-chevron-left class="h-5 w-5 mr-1.5" />
                        Tous les articles
                    </a>
                    <a href="#" class="flex items-center pl-3 font-sans text-skin-base text-base font-medium">Mes articles</a>
                </div>
                <div class="flex items-center space-x-2 mt-3 sm:mt-0">
                    <x-button type="submit" name="submitted" value="1">
                        Soumettre
                    </x-button>
                    <x-default-button type="submit" name="submitted" value="0">
                        Brouillon
                    </x-default-button>
                    <x-default-button>
                        <x-heroicon-o-cog class="h-5 w-5" />
                    </x-default-button>
                </div>
            </nav>

            <main class="py-10 relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 z-0">
                <x-rules-banner />

                <div class="mt-6">
                    <x-input
                        type="text"
                        name="title"
                        id="title"
                        class="block w-full h-auto px-0 py-4 text-3xl sm:text-4xl font-bold bg-transparent border-0 leading-normal border-0 appearance-none focus:ring-0"
                        placeholder="Titre de votre article..."
                        autofocus
                        autocomplete="off"
                    />
                </div>
            </main>
        </div>

    </form>

@endsection
