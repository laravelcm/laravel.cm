<x-app-layout :title="$thread->subject()" :canonical="route('forum.show', $thread)">
    <x-container class="py-12">
        <div class="relative lg:grid lg:grid-cols-9 lg:gap-10">
            <div class="relative hidden lg:col-span-2 lg:block">
                <x-sticky-content class="space-y-6">
                    <x-button :link="route('forum.new')" class="flex w-full justify-center">
                        Nouveau Sujet
                        <x-heroicon-o-plus-circle class="ml-2.5 h-4 w-4" />
                    </x-button>
                    <nav>
                        <a
                            href="{{ route('forum.index') }}"
                            class="inline-flex w-full items-center py-3 text-sm font-medium text-skin-base hover:text-skin-inverted"
                        >
                            <x-untitledui-menu class="mr-2 h-5 w-5" />
                            <span>Tous les sujets</span>
                        </a>
                    </nav>

                    @auth
                        <livewire:forum.subscribe :thread="$thread" />
                    @endauth

                    <x-forum.thread-author :author="$thread->user" />
                </x-sticky-content>
            </div>
            <div class="lg:col-span-7 lg:border-l lg:border-skin-base lg:pl-8">
                <h1 class="font-heading text-xl font-medium tracking-tight text-skin-inverted sm:text-3xl">
                    {{ $thread->subject() }}
                </h1>

                <div class="border-b border-skin-base pb-4 pt-2">
                    <div class="text-sm text-skin-inverted-muted sm:inline-flex sm:items-center">
                        <div class="flex items-center">
                            <a
                                href="{{ route('profile', $thread->user->username) }}"
                                class="inline-flex items-center hover:underline"
                            >
                                <x-user.avatar
                                    :user="$thread->user"
                                    class="h-5 w-5"
                                    span="-right-1 h-3.5 w-3.5 -top-1 ring-1"
                                    container="mr-1"
                                />
                                <span class="font-sans">{{ '@' . $thread->user->username }}</span>
                            </a>
                            <x-user.points :author="$thread->user" />
                            <span class="mx-1.5 inline-flex space-x-1">
                                <span>a posé</span>
                                <time-ago time="{{ $thread->created_at->getTimestamp() }}" />
                                <time
                                    class="sr-only"
                                    datetime="{{ $thread->created_at }}"
                                    title="{{ $thread->last_posted_at->format('j M, Y \à H:i') }}"
                                >
                                    {{ $thread->last_posted_at->format('j M, Y \à H:i') }}
                                </time>
                            </span>
                            <span>dans</span>
                        </div>
                        <div class="mt-2 flex items-center space-x-2 self-center sm:ml-2 sm:mt-0">
                            <div class="shrink-0">
                                @if (count($channels = $thread->channels->load('parent')))
                                    <div class="mt-2 flex flex-wrap gap-2 lg:mt-0 lg:gap-x-2">
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
                                    <span class="mx-2 text-skin-muted">•</span>
                                    <span class="inline-flex items-center gap-x-2 font-medium text-green-500">
                                        <x-untitledui-check-verified-03 class="h-5 w-5" />
                                        <span>Résolu</span>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <x-status-message class="mt-5" />

                <x-forum.thread :thread="$thread" />

                @if ($thread->replies->isNotEmpty())
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
                                La dernière réponse à ce sujet remonte à plus de six mois. Pensez à ouvrir un nouveau
                                sujet si vous avez une question similaire.
                            </p>
                            <p class="mt-4 text-sm">
                                <a
                                    href="{{ route('forum.new') }}"
                                    class="whitespace-nowrap rounded-md border border-transparent bg-blue-100 px-3 py-2 font-medium text-blue-700 hover:text-blue-600 focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-blue-50"
                                >
                                    Créer un nouveau sujet
                                    <span aria-hidden="true">&rarr;</span>
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
                        <p class="py-8 text-center font-sans text-skin-base">
                            Veuillez vous
                            <a
                                href="{{ route('login') }}"
                                class="text-skin-primary hover:text-skin-primary-hover hover:underline"
                            >
                                connecter
                            </a>
                            ou
                            <a
                                href="{{ route('register') }}"
                                class="text-skin-primary hover:text-skin-primary-hover hover:underline"
                            >
                                créer un compte
                            </a>
                            pour participer à cette conversation.
                        </p>
                    @else
                        <div class="mt-10 flex items-center justify-between gap-x-12 text-skin-base">
                            <p>Vous devrez vérifier votre compte avant de participer à cette conversation.</p>

                            <form action="{{ route('verification.send') }}" method="POST" class="block">
                                @csrf
                                <x-button type="submit" class="px-3 py-2 text-sm leading-4">
                                    Recevoir un lien
                                    <x-heroicon-o-arrow-long-right class="ml-1.5 h-5 w-5" />
                                </x-button>
                            </form>
                        </div>
                    @endguest
                @endcan
            </div>
        </div>
    </x-container>
</x-app-layout>
