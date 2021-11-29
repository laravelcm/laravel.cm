@title("Tableau de bord ~ {$user->username} ({$user->name})")
@canonical(route('dashboard'))

@extends('layouts.default')

@section('body')

    <div class="flex-1 min-w-0">
        <x-status-message class="mb-5" />

        <h2 class="text-xl font-bold leading-7 text-skin-inverted sm:text-2xl sm:truncate font-sans">
            Tableau de bord
        </h2>

        <x-user.stats :user="$user" />
    </div>

    <section class="mt-8 relative lg:grid lg:grid-cols-12 lg:gap-12">
        <div class="hidden lg:block lg:col-span-3">
            <x-user.sidebar :user="$user" />
        </div>
        <main class="lg:col-span-9">

        </main>
    </section>

@endsection
