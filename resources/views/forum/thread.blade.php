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
                <div class="sm:inline-flex sm:items-center text-sm text-skin-inverted-muted font-normal">
                    <div class="flex items-center">
                        <a href="{{ route('profile', $thread->author->username) }}" class="inline-flex items-center hover:underline">
                            <img class="inline-block rounded-full h-5 w-5 mr-1" src="{{ $thread->author->profile_photo_url }}" alt="Avatar de {{ $thread->author->username }}">
                            <span class="font-sans">{{ '@' . $thread->author->username }}</span>
                        </a>
                        <span class="inline-flex ml-1.5">
                            a posé le <time class="mr-1.5" datetime="{{ $thread->created_at }}" title="{{ $thread->created_at->format('j M, Y \à h:i') }}">{{ $thread->created_at->format('j M, Y \à h:i') }}</time> dans
                        </span>
                    </div>
                    <div class="mt-2 sm:mt-0 sm:ml-2 self-center flex items-center space-x-2">
                        <div class="flex-shrink-0">
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
                            <div class="flex items-center">
                                <span class="text-skin-muted mx-2">•</span>
                                <span class="inline-flex items-center gap-x-2 font-medium text-green-500">
                                    <x-heroicon-s-badge-check class="w-5 h-5" />
                                    <span>Résolu</span>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <x-forum.thread :thread="$thread" />

            @if($thread->replies->isNotEmpty())
                <div class="mt-10">
                    <ul class="space-y-8 px-4" role="list">
                        @foreach ($thread->replies as $reply)
                            <livewire:forum.reply wire:key="$reply->id" :thread="$thread" :reply="$reply" />
                        @endforeach
                    </ul>
                </div>
            @endif

            @can(App\Policies\ReplyPolicy::CREATE, App\Models\Reply::class)
                @if ($thread->isConversationOld())
                    <x-info-panel class="font-sans">
                        <p class="text-sm text-blue-700">
                            La dernière réponse à ce sujet remonte à plus de six mois. Pensez à ouvrir un nouveau sujet si vous avez une question similaire.
                        </p>
                        <p class="mt-4 text-sm">
                            <a href="{{ route('forum.new') }}" class="whitespace-nowrap bg-blue-100 rounded-md px-3 py-2 border border-transparent font-medium text-blue-700 hover:text-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-50 focus:ring-blue-600">
                                Créer un nouveau sujet <span aria-hidden="true">&rarr;</span>
                            </a>
                        </p>
                    </x-info-panel>
                @else
                    <div class="my-8">
                        <livewire:forum.create-reply :thread="$thread" />
                    </div>
                @endif
            @else
                @guest
                    <p class="text-center py-8 font-sans text-skin-base">
                        Veuillez vous <a href="{{ route('login') }}" class="text-skin-primary hover:text-skin-primary-hover hover:underline">connecter</a> ou <a href="{{ route('register') }}" class="text-skin-primary hover:text-skin-primary-hover hover:underline">créer un compte</a> pour participer à cette conversation.
                    </p>
                @else
                    <div class="mt-10 flex justify-between items-center gap-x-12 text-skin-base font-normal">
                        <p>Vous devrez vérifier votre compte avant de participer à cette conversation.</p>

                        <form action="{{ route('verification.send') }}" method="POST" class="block">
                            @csrf
                            <x-button type="submit" class="px-3 py-2 text-sm leading-4">
                                Recevoir un lien
                                <x-heroicon-o-arrow-narrow-right class="h-5 w-5 ml-1.5" />
                            </x-button>
                        </form>
                    </div>
                @endguest
            @endcan
        </div>
    </div>

@endsection
