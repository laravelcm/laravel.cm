<x-app-layout
    :title="'Tableau de bord ~ '. $user->username . ' (' . $user->name .')'"
    :canonical="route('dashboard')"
>
    <x-container class="py-12">
        <div>
            <x-status-message class="mb-5" />

            <h2 class="text-xl font-bold leading-7 text-gray-900 sm:truncate sm:text-2xl">Tableau de bord</h2>

            <x-user.stats :user="$user" />
        </div>
        <section class="relative mt-8 lg:grid lg:grid-cols-12 lg:gap-12">
            <div class="hidden lg:col-span-3 lg:block">
                <x-user.sidebar :user="$user" />
            </div>
            <main class="lg:col-span-9">
                <x-user.page-heading title="Vos articles" :url="route('articles.index')" button="Nouvel article" />

                <div class="mt-5">
                    @unless (Auth::user()->hasTwitterAccount())
                        <div class="mb-6 rounded-md bg-blue-500 bg-opacity-10 p-3 text-sm font-normal text-blue-800">
                            <svg
                                class="mr-1 inline-block size-5"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
                                />
                            </svg>
                            Complétez votre
                            <a href="{{ route('user.settings') }}" class="underline">identifiant Twitter</a>
                            pour que nous puissions faire un lien vers votre profil lorsque nous tweetons votre article.
                        </div>
                    @endunless

                    @forelse ($articles as $article)
                        <div class="mb-8 border-b border-skin-base pb-8">
                            <div class="flex items-center space-x-3">
                                @if ($article->isNotPublished())
                                    <span
                                        class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800"
                                    >
                                        Brouillon
                                    </span>
                                @endif

                                @foreach ($article->tags as $tag)
                                    <x-tag :tag="$tag" />
                                @endforeach
                            </div>

                            <a href="{{ route('articles.show', $article->slug) }}" class="block">
                                <div class="mt-4 flex items-center justify-between">
                                    <h3
                                        class="font-sans text-xl font-semibold leading-7 text-gray-900 hover:text-primary-600"
                                    >
                                        {{ $article->title }}
                                    </h3>

                                    <div class="flex items-center font-sans text-gray-400 dark:text-gray-500">
                                        @if ($article->isPublished())
                                            <a
                                                href="{{ route('articles.show', $article->slug) }}"
                                                class="hover:text-gray-500 dark:text-gray-400 hover:underline"
                                            >
                                                Voir
                                            </a>
                                            <span class="mx-1">&middot;</span>
                                        @endif

                                        <a
                                            href="{{ route('articles.edit', $article->slug) }}"
                                            class="hover:text-gray-500 dark:text-gray-400 hover:underline"
                                        >
                                            Éditer
                                        </a>
                                    </div>
                                </div>

                                <p class="mt-3 text-base font-normal leading-6 text-gray-500 dark:text-gray-400">
                                    {{ $article->excerpt() }}
                                </p>
                            </a>

                            <div class="mt-6 flex items-center justify-between">
                                <div class="flex items-center">
                                    <a href="{{ route('profile', $article->user->username) }}" class="shrink-0">
                                        <img
                                            class="size-10 rounded-full object-cover"
                                            src="{{ $article->user->profile_photo_url }}"
                                            alt="{{ $article->user->username }}"
                                        />
                                    </a>

                                    <div class="ml-3 font-sans">
                                        <p class="text-sm font-medium leading-5 text-gray-700 dark:text-gray-300">
                                            <a
                                                href="{{ route('profile', $article->user->username) }}"
                                                class="hover:underline"
                                            >
                                                {{ $article->user->name }}
                                            </a>
                                        </p>

                                        <div class="flex text-sm leading-5 text-gray-500 dark:text-gray-400">
                                            @if ($article->isPublished())
                                                <time datetime="{{ $article->submittedAt()->format('Y-m-d') }}">
                                                    {{ __('Publié le :date', ['date' => $article->submittedAt()->format('j M, Y')]) }}
                                                </time>
                                            @else
                                                @if ($article->isAwaitingApproval())
                                                    <span>En attente d'approbation</span>
                                                @else
                                                    <time datetime="{{ $article->updated_at->format('Y-m-d') }}">
                                                        Rédigé
                                                        <time-ago time="{{ $article->updated_at->getTimestamp() }}" />
                                                    </time>
                                                @endif
                                            @endif

                                            <span class="mx-1">&middot;</span>
                                            <span>{{ $article->readTime() }} min de lecture</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center text-gray-500 dark:text-gray-400">
                                    <span class="mr-2 text-xl">👏</span>
                                    {{ count($article->reactions) }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-base text-gray-500 dark:text-gray-400">Vous n'avez pas encore créé d'articles.</p>
                    @endforelse

                    {{ $articles->links() }}
                </div>
            </main>
        </section>
    </x-container>
</x-app-layout>
