@title("Discussions ~ {$user->username} ({$user->name})")
@canonical(route('dashboard'))

@extends('layouts.default')

@section('body')

    <div class="flex-1 min-w-0">
        <x-status-message class="mb-5" />

        <x-user.breadcrumb section="Discussions" />

        <h2 class="text-xl font-bold leading-7 text-skin-inverted sm:text-2xl sm:truncate font-sans">
            Discussions
        </h2>
    </div>

    <section class="mt-8 relative lg:grid lg:grid-cols-12 lg:gap-12">
        <div class="hidden lg:block lg:col-span-3">
            <x-user.sidebar :user="$user" />
        </div>
        <main class="lg:col-span-9">
            <x-user.page-heading title="Vos discussions" :url="route('discussions.new')" button="Nouvelle discussion" />

            <div class="mt-5">
                @forelse($discussions as $discussion)
                    <x-discussions.summary :discussion="$discussion" />
                @empty
                    <p class="text-skin-base text-base">
                        Vous n'avez pas encore créé de discussions.
                    </p>
                @endforelse

                <div class="pt-5">
                    {{ $discussions->links() }}
                </div>
            </div>
        </main>
    </section>

@endsection
