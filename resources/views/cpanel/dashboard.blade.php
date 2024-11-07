<x-app-layout title="Tableau de bord">
    <x-container class="mx-auto max-w-7xl px-4 sm:px-6">
        <div>
            <h3 class="font-heading text-3xl font-semibold leading-8 text-gray-900">
                {{ __('Shalom, :name', ['name' => auth()->user()->name]) }}
            </h3>
            <div class="mt-6 lg:grid lg:grid-cols-5 lg:gap-8">
                <div class="lg:col-span-4">
                    @widget('recentNumbers')
                    <div class="mt-8">
                        <div class="border-b border-skin-base pb-5">
                            <h3 class="font-heading text-lg font-medium leading-6 text-gray-900">
                                {{ __('Actions rapide') }}
                            </h3>
                        </div>
                        <div class="mt-6 space-y-8">
                            <div class="grid gap-5 sm:grid-cols-3 sm:gap-6">
                                <a
                                    href="{{ route('discussions.new') }}"
                                    class="group flex rounded-md border border-skin-base bg-skin-card p-4 hover:border-green-300"
                                >
                                    <div
                                        class="flex size-10 shrink-0 items-center justify-center rounded-full bg-green-50 text-green-800"
                                    >
                                        <svg class="size-5" fill="none" viewBox="0 0 24 24">
                                            <path
                                                d="M8 7h8m-4 0v10m-4.2 4h8.4c1.68 0 2.52 0 3.162-.327a3 3 0 0 0 1.311-1.311C21 18.72 21 17.88 21 16.2V7.8c0-1.68 0-2.52-.327-3.162a3 3 0 0 0-1.311-1.311C18.72 3 17.88 3 16.2 3H7.8c-1.68 0-2.52 0-3.162.327a3 3 0 0 0-1.311 1.311C3 5.28 3 6.12 3 7.8v8.4c0 1.68 0 2.52.327 3.162a3 3 0 0 0 1.311 1.311C5.28 21 6.12 21 7.8 21Z"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p
                                            class="text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 group-hover:text-green-600"
                                        >
                                            {{ __('Démarrer une discussion') }}
                                        </p>
                                        <p class="mt-0.5 text-sm leading-5 text-skin-muted">
                                            {{ __('Partager des sujets qui animent la communauté.') }}
                                        </p>
                                    </div>
                                </a>
                                <a
                                    href="{{ route('articles.new') }}"
                                    class="group flex rounded-md border border-skin-base bg-skin-card p-4 hover:border-green-300"
                                >
                                    <div
                                        class="flex size-10 shrink-0 items-center justify-center rounded-full bg-green-50 text-green-800"
                                    >
                                        <x-heroicon-o-newspaper class="size-5" />
                                    </div>
                                    <div class="ml-3">
                                        <p
                                            class="text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 group-hover:text-green-600"
                                        >
                                            {{ __('Créer un nouvel article') }}
                                        </p>
                                        <p class="mt-0.5 text-sm leading-5 text-skin-muted">
                                            {{ __('Donnez des informations à propos de Laravel, etc.') }}
                                        </p>
                                    </div>
                                </a>
                                <a
                                    href="#"
                                    class="group flex rounded-md border border-skin-base bg-skin-card p-4 hover:border-green-300"
                                >
                                    <div
                                        class="flex size-10 shrink-0 items-center justify-center rounded-full bg-green-50 text-green-800"
                                    >
                                        <x-heroicon-o-video-camera class="size-5" />
                                    </div>
                                    <div class="ml-3">
                                        <p
                                            class="text-sm font-medium leading-6 text-gray-700 dark:text-gray-300 group-hover:text-green-600"
                                        >
                                            {{ __('Nouveau tutoriel') }}
                                        </p>
                                        <p class="mt-0.5 text-sm leading-5 text-skin-muted">
                                            {{ __('Créer un nouveau contenu vidéo pour YouTube.') }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                            <div>
                                <div class="border-b border-skin-base pb-5">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                                        {{ __('Derniers articles') }}
                                    </h3>
                                </div>
                                <div class="mt-6 grid gap-5 sm:grid-cols-2 sm:gap-6">
                                    @foreach ($latestArticles as $article)
                                        <x-admin.recent-post :article="$article" />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-10 lg:col-span-1 lg:mt-0">
                    <h5 class="text-sm font-medium leading-5 text-gray-500 dark:text-gray-400">{{ __('Nouveaux membres') }}</h5>
                    <div class="mt-6 space-y-5">
                        @foreach ($users as $user)
                            <x-admin.new-member :user="$user" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout>
