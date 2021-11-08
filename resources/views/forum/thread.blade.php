@title($thread->subject())
@canonical(route('forum.show', $thread))

@extends('layouts.default')

@section('body')

    <div class="lg:grid lg:grid-cols-9 lg:gap-10">
        <div class="hidden lg:block lg:col-span-2">
            <div class="sticky top-4 space-y-6">
                <x-button :link="route('forum.new')" class="w-full flex justify-center">
                    Nouveau Sujet
                    <x-heroicon-o-plus-circle class="h-4 w-4 ml-2.5" />
                </x-button>
                <nav>
                    <a href="{{ route('forum.index') }}" class="w-full inline-flex items-center text-skin-base hover:text-skin-inverted py-3 text-sm font-medium">
                        <x-heroicon-s-menu class="h-5 w-5 mr-2" />
                        <span>Tous les sujets</span>
                    </a>
                    <a href="#" class="w-full inline-flex items-center text-skin-base hover:text-skin-inverted py-3 text-sm font-medium">
                        <x-heroicon-s-clipboard-list class="h-5 w-5 mr-2" />
                        <span>Classement</span>
                    </a>
                </nav>

                <div class="bg-skin-card-gray px-4 py-5 sm:p-6 rounded-lg">
                    <h3 class="text-lg leading-6 font-medium text-skin-inverted font-sans">
                        Notifications
                    </h3>
                    <div class="mt-2 max-w-xl text-sm leading-5 text-skin-base font-normal">
                        <p>
                            Vous ne recevez pas de notifications de ce sujet.
                        </p>
                    </div>
                    <div class="mt-5">
                        <span class="inline-flex rounded-md shadow-sm">
                            <x-button link="#">
                                <x-heroicon-s-bell class="h-5 w-5 mr-2" />
                                Subscribe
                            </x-button>
                        </span>
                    </div>
                </div>

                <x-forum.thread-author :author="$thread->author" />
            </div>
        </div>
        <div class="lg:col-span-7 lg:pl-8 lg:border-l lg:border-skin-base">
            <h1 class="text-xl sm:text-3xl text-skin-inverted">{{ $thread->subject() }}</h1>

            <div class="border-b pt-2 pb-4 border-skin-base">
                <div class="inline-flex items-center text-sm text-skin-inverted-muted font-normal">
                    <a href="{{ route('profile', $thread->author->username) }}" class="inline-flex items-center hover:underline">
                        <img class="inline-block rounded-full h-4 w-4 mr-1" src="{{ $thread->author->profile_photo_url }}" alt="Avatar de {{ $thread->author->username }}">
                        <span class="font-sans">{{ '@' . $thread->author->username }}</span>
                    </a>
                    <p class="ml-1.5">
                        a posé le <time datetime="{{ $thread->created_at }}" title="{{ $thread->created_at->format('j M, Y \à h:i') }}">{{ $thread->created_at->format('j M, Y \à h:i') }}</time> dans
                    </p>
                    <div class="ml-2 flex-shrink-0 self-center flex">
                        @if (count($channels = $thread->channels->load('parent')))
                            <div class="flex flex-wrap gap-2 mt-2 lg:mt-0 lg:gap-x-2">
                                @foreach ($channels as $channel)
                                    <a href="{{ route('forum.channels', $channel) }}" class="flex gap-2">
                                        <x-forum.channel :channel="$channel" />
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @if ($thread->isSolved())
                        <span class="text-skin-muted mx-2">•</span>
                        <span class="inline-flex items-center gap-x-2 font-medium text-green-500">
                            <x-heroicon-s-badge-check class="w-5 h-5" />
                            <span>Résolu</span>
                        </span>
                    @endif
                </div>
            </div>

            <x-forum.thread :thread="$thread" />

            <div class="mt-6 space-y-6">

            </div>
        </div>
    </div>

@endsection
