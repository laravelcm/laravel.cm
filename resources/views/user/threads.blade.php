@title("Sujets ~ {$user->username} ({$user->name})")
@canonical(route('threads.me'))

@extends('layouts.default')

@section('body')

    <div class="flex-1 min-w-0">
        <x-status-message class="mb-5" />

        <x-user.breadcrumb section="Sujets" />

        <h2 class="text-xl font-bold leading-7 text-skin-inverted sm:text-2xl sm:truncate font-heading">
            Sujets
        </h2>
    </div>

    <section class="mt-8 relative lg:grid lg:grid-cols-12 lg:gap-12">
        <div class="hidden lg:block lg:col-span-3">
            <x-user.sidebar :user="$user" />
        </div>
        <main class="lg:col-span-9">
            <x-user.page-heading title="Vos sujets" :url="route('forum.new')" button="Nouveau sujet" />

            <div class="mt-5">
                @forelse($threads as $thread)
                    <x-forum.thread-summary :thread="$thread" />
                @empty
                    <p class="text-skin-base text-base">
                        Vous n'avez pas encore créé de sujets.
                    </p>
                @endforelse

                <div class="pt-5">
                    {{ $threads->links() }}
                </div>
            </div>

        </main>
    </section>

@endsection
