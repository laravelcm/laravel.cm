@title("Tableau de bord ~ {$user->username} ({$user->name})")
@canonical(route('dashboard'))

@extends('layouts.default')

@section('body')

    <div>
        <x-status-message class="mb-5" />

        <h2 class="text-xl font-bold leading-7 text-skin-inverted sm:text-2xl sm:truncate">
            {{ __('Tableau de bord') }}
        </h2>

        <x-user.stats :user="$user" />
    </div>

    <section class="mt-8 relative lg:grid lg:grid-cols-12 lg:gap-12">
        <div class="hidden lg:block lg:col-span-3">
            <x-user.sidebar :user="$user" />
        </div>
        <main class="lg:col-span-9">
            <x-user.page-heading title="Vos articles" :url="route('articles.new')" button="Nouvel article" />

            <div class="mt-5">
                @unless(Auth::user()->hasTwitterAccount())
                    <div class="bg-blue-500 bg-opacity-10 text-blue-800 text-sm p-3 rounded-md font-normal mb-6">
                        <svg class="h-5 w-5 inline-block mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        {{ __('Complétez votre') }} <a href="{{ route('user.settings') }}" class="underline">{{ __('identifiant Twitter') }}</a> {{ __('pour que nous puissions faire un lien vers votre profil lorsque nous tweetons votre article.') }}
                    </div>
                @endunless

                @forelse($articles as $article)
                    <div class="pb-8 mb-8 border-b border-skin-base">
                        <div class="flex items-center space-x-3">
                            @if ($article->isNotPublished())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ __('Brouillon') }}
                                </span>
                            @endif

                            @foreach ($article->tags as $tag)
                                <x-tag :tag="$tag" />
                            @endforeach
                        </div>

                        <a href="{{ route('articles.show', $article->slug()) }}" class="block">
                            <div class="mt-4 flex justify-between items-center">
                                <h3 class="text-xl leading-7 font-semibold text-skin-inverted font-sans hover:text-skin-primary">
                                    {{ $article->title }}
                                </h3>

                                <div class="flex items-center text-skin-muted font-sans">
                                    @if($article->isPublished())
                                        <a href="{{ route('articles.show', $article->slug()) }}" class="hover:text-skin-base hover:underline">
                                            {{ __('Voir') }}
                                        </a>
                                        <span class="mx-1">
                                            &middot;
                                        </span>
                                    @endif
                                    <a href="{{ route('articles.edit', $article->slug()) }}" class="hover:text-skin-base hover:underline">
                                        {{ __('Éditer') }}
                                    </a>
                                </div>
                            </div>

                            <p class="mt-3 text-base leading-6 text-skin-base font-normal">
                                {{ $article->excerpt() }}
                            </p>
                        </a>

                        <div class="flex items-center justify-between mt-6">
                            <div class="flex items-center">
                                <a href="{{ route('profile', $article->user->username) }}" class="shrink-0">
                                    <img class="h-10 w-10 object-cover rounded-full"
                                         src="{{ $article->user->profile_photo_url }}"
                                         alt="{{ $article->user->username }}" />
                                </a>

                                <div class="ml-3 font-sans">
                                    <p class="text-sm leading-5 font-medium text-skin-inverted-muted">
                                        <a href="{{ route('profile', $article->user->username) }}" class="hover:underline">
                                            {{ $article->user->name }}
                                        </a>
                                    </p>

                                    <div class="flex text-sm leading-5 text-skin-base">
                                        @if ($article->isPublished())
                                            <time datetime="{{ $article->submittedAt()->format('Y-m-d') }}">
                                                {{ __('Publié le :date', ['date' => $article->submittedAt()->format('j M, Y')]) }}
                                            </time>
                                        @else
                                            @if ($article->isAwaitingApproval())
                                                <span>
                                                    {{ __('En attente d\'approbation') }}
                                                </span>
                                            @else
                                                <time datetime="{{ $article->updated_at->format('Y-m-d') }}">
                                                    {{ __('Rédigé') }} <time-ago time="{{ $article->updated_at->getTimestamp() }}" />
                                                </time>
                                            @endif
                                        @endif

                                        <span class="mx-1">
                                            &middot;
                                        </span>

                                        <span>
                                            {{ $article->readTime() }} {{ __('min de lecture') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center text-skin-base">
                                <span class="text-xl mr-2">👏</span>
                                {{ count($article->reactions) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-skin-base text-base">
                        {{ __('Vous n\'avez pas encore créé d\'articles.') }}
                    </p>
                @endforelse

                {{ $articles->links() }}
            </div>
        </main>
    </section>

@endsection
