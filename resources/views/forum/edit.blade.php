@title(__('Modifier le sujet :subject', ['subject' => $thread->subject()]))

@extends('layouts.default')

@section('body')

    <div class="max-w-4xl mx-auto">
        <div class="space-y-8 divide-y divide-skin-base sm:space-y-5">
            <div>
                <h3 class="text-lg leading-6 font-medium text-skin-inverted font-heading">
                    {{ __('Modifier mon sujet') }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-skin-base font-normal">
                    Assurez-vous d'avoir lu nos <a href="{{ route('rules') }}" class="font-medium text-skin-primary hover:text-skin-primary-hover">règles de conduite</a> avant de continuer.
                </p>
            </div>

            <livewire:forum.edit-thread :thread="$thread" />
        </div>
    </div>

@endsection
