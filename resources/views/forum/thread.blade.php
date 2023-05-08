@title($thread->subject())
@canonical(route('forum.show', $thread))

@extends('layouts.default')

@section('body')

    <div class="relative lg:grid lg:grid-cols-9 lg:gap-10">
        <div class="hidden relative lg:block lg:col-span-2">
            <x-sticky-content class="space-y-6">
                <x-button :link="route('forum.new')" class="w-full flex justify-center">
                    {{ __('Nouveau Sujet') }}
                    <x-heroicon-o-plus-circle class="h-4 w-4 ml-2.5" />
                </x-button>
                <nav>
                    <a href="{{ route('forum.index') }}" class="w-full inline-flex items-center text-skin-base hover:text-skin-inverted py-3 text-sm font-medium">
                        <x-heroicon-s-menu class="h-5 w-5 mr-2" />
                        <span>{{ __('Tous les sujets') }}</span>
                    </a>
                </nav>

                @auth
                    <livewire:forum.subscribe :thread="$thread" />
                @endauth

                <x-forum.thread-author :author="$thread->user" />
            </x-sticky-content>
        </div>
        <div class="lg:col-span-7 lg:pl-8 lg:border-l lg:border-skin-base">
            <h1 class="text-xl text-skin-inverted font-medium tracking-tight sm:text-3xl font-heading">
                {{ $thread->subject() }}
            </h1>

            <div class="border-b pt-2 pb-4 border-skin-base">
                <div class="sm:inline-flex sm:items-center text-sm text-skin-inverted-muted">
                    <div class="flex items-center">
                        <a href="{{ route('profile', $thread->user->username) }}" class="inline-flex items-center hover:underline">
                            <x-user.avatar :user="$thread->user" class="h-5 w-5" span="-right-1 h-3.5 w-3.5 -top-1 ring-1" container="mr-1" />
                            <span class="font-sans">{{ '@' . $thread->user->username }}</span>
                        </a>
                        <x-user.points :author="$thread->user" />
                        <span class="inline-flex mx-1.5 space-x-1">
                            <span>{{ __('a posé') }}</span>
                            <time-ago time="{{ $thread->created_at->getTimestamp() }}"/>
                            <time class="sr-only" datetime="{{ $thread->created_at }}" title="{{ $thread->last_posted_at->format('j M, Y \à H:i') }}">{{ $thread->last_posted_at->format('j M, Y \à H:i') }}</time>
                        </span>
                        <span>{{ __('dans') }}</span>
                    </div>
                    <div class="mt-2 sm:mt-0 sm:ml-2 self-center flex items-center space-x-2">
                        <div class="shrink-0">
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
                                    <span>{{ __('Résolu') }}</span>
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <x-status-message class="mt-5" />

            <x-forum.thread :thread="$thread" />

            @if($thread->replies->isNotEmpty())
                <div class="mt-10">
                    <ul class="space-y-8 sm:px-4" role="list">
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
                            {{ __('La dernière réponse à ce sujet remonte à plus de six mois. Pensez à ouvrir un nouveau sujet si vous avez une question similaire.') }}
                        </p>
                        <p class="mt-4 text-sm">
                            <a href="{{ route('forum.new') }}" class="whitespace-nowrap bg-blue-100 rounded-md px-3 py-2 border border-transparent font-medium text-blue-700 hover:text-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-50 focus:ring-blue-600">
                                {{ __('Créer un nouveau sujet') }} <span aria-hidden="true">&rarr;</span>
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
                        {{ __('Veuillez vous') }} <a href="{{ route('login') }}" class="text-skin-primary hover:text-skin-primary-hover hover:underline">{{ __('connecter') }}</a> {{ __('ou') }}
                        <a href="{{ route('register') }}" class="text-skin-primary hover:text-skin-primary-hover hover:underline">{{ __('créer un compte') }}</a>
                        {{ __('pour participer à cette conversation.') }}
                    </p>
                @else
                    <div class="mt-10 flex justify-between items-center gap-x-12 text-skin-base">
                        <p>{{ __('Vous devrez vérifier votre compte avant de participer à cette conversation.') }}</p>

                        <form action="{{ route('verification.send') }}" method="POST" class="block">
                            @csrf
                            <x-button type="submit" class="px-3 py-2 text-sm leading-4">
                                {{ __('Recevoir un lien') }}
                                <x-heroicon-o-arrow-narrow-right class="h-5 w-5 ml-1.5" />
                            </x-button>
                        </form>
                    </div>
                @endguest
            @endcan
        </div>
    </div>

@endsection
