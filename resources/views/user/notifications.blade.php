@title("Notifications")
@canonical(route('notifications'))

@extends('layouts.default')

@section('body')

    <div class="flex-1 min-w-0">
        <x-user.breadcrumb section="Notifications" />

        <h2 class="inline-flex items-center gap-x-2 text-xl font-bold leading-7 text-skin-inverted sm:text-2xl sm:truncate font-sans">
            Notifications <livewire:notification-count />
        </h2>
    </div>

    <section class="mt-8 relative">
        <livewire:notifications />
    </section>

@endsection
