@title("{$user->username} ({$user->name})")
@canonical(route('profile', $user->username))

@extends('layouts.large')

@section('body')

    <div>
        <div>
            <img class="h-32 w-full object-cover lg:h-48" src="{{ asset('images/profile-banner.png') }}" alt="">
        </div>
        <x-container class="max-w-7xl mx-auto px-4">
            <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                <div class="flex">
                    <img class="h-24 w-24 rounded-full ring-4 ring-card sm:h-32 sm:w-32" src="{{ $user->profile_photo_url }}" alt="User avatar">
                </div>
                <div class="mt-6 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
                    <div class="sm:hidden md:block mt-6 min-w-0 flex-1">
                        <h1 class="inline-flex items-center text-2xl font-bold text-skin-inverted truncate font-sans">
                            {{ $user->name }}
                            @if($user->hasAnyRole('admin', 'moderator'))
                                <x-user-status />
                            @endif
                        </h1>
                        <p class="text-sm font-medium text-skin-base font-normal">
                            {{ __('Inscrit') }} <time-ago time="{{ $user->created_at->getTimestamp() }}"/>
                        </p>
                    </div>
                    <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                        @if ($user->isLoggedInUser())
                            <x-default-button :link="route('user.settings')">
                                <x-heroicon-o-pencil class="-ml-1 mr-2 h-5 w-5 text-skin-muted" />
                                Éditer
                            </x-default-button>
                        @endif
                        <x-default-button type="button">
                            <x-heroicon-o-user-add class="-ml-1 mr-2 h-5 w-5 text-skin-muted" />
                            <span>{{ __('Suivre') }}</span>
                        </x-default-button>
                    </div>
                </div>
            </div>
            <div class="hidden sm:block md:hidden mt-6 min-w-0 flex-1">
                <h1 class="text-2xl font-bold text-skin-inverted truncate font-sans">
                    {{ $user->name }}
                </h1>
                <p class="text-sm font-medium text-skin-base font-normal">
                    {{ __('Inscrit') }} <time-ago time="{{ $user->created_at->getTimestamp() }}"/>
                </p>
            </div>
        </x-container>
    </div>

    <x-container class="py-10 max-w-7xl mx-auto px-4">
        <div class="space-y-6 lg:grid lg:grid-cols-2 lg:gap-6 lg:space-y-0">
            <div>
                <h3 class="text-lg leading-6 font-medium font-sans text-skin-inverted">{{ __('Biographie') }}</h3>
                <p class="mt-2 text-skin-base font-normal">
                    {{ $user->bio ?? '...' }}
                </p>
                <div class="mt-4 mb-6 flex items-center gap-x-3">
                    @if ($user->githubUsername())
                        <a href="https://github.com/{{ $user->githubUsername() }}" class="text-skin-base hover:text-skin-inverted">
                            <x-icon.github class="w-6 h-6" />
                        </a>
                    @endif

                    @if ($user->twitter())
                        <a href="https://twitter.com/{{ $user->twitter() }}" class="text-skin-base hover:text-[#29aaec]">
                            <x-icon.twitter class="w-6 h-6" />
                        </a>
                    @endif
                </div>
            </div>
            <div>
                <dl class="grid grid-cols-1 gap-x-3 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-skin-base font-sans">
                            Localisation
                        </dt>
                        <dd class="mt-1 text-skin-inverted-muted font-normal">
                            {{ $user->location ?? '...' }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-skin-base font-sans">
                            Site internet
                        </dt>
                        <dd class="mt-1 text-skin-inverted-muted font-normal">
                            @if ($user->website)
                                <a href="{{ $user->website }}" target="_blank" class="inline-flex items-center text-skin-primary hover:text-skin-primary-hover">
                                    {{ $user->website }} <x-heroicon-o-external-link class="ml-1.5 w-5 h-5" />
                                </a>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="relative border-t border-skin-base mt-6 pt-6 sm:pt-0 sm:border-0 lg:mt-0 lg:grid lg:grid-cols-8 lg:gap-12">
            <div
                class="lg:col-span-5"
                x-data="{
                    activeTab: 'articles',
                    tabs: ['articles', 'discussions', 'questions', 'badges']
                }"
            >
                <div>
                    <div class="sm:hidden">
                        <label for="tabs" class="sr-only">Select a tab</label>
                        <x-forms.select x-model="activeTab" aria-label="Selected tab" class="block w-full pl-3 pr-10 py-2">
                            <template x-for="tab in tabs" :key="tab">
                                <option
                                    x-bind:value="tab"
                                    x-text="capitalize(tab)"
                                    x-bind:selected="tab === activeTab"
                                ></option>
                            </template>
                        </x-forms.select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="border-b border-skin-base">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <template x-for="tab in tabs" :key="tab">
                                    <button
                                      type="button"
                                      @click="activeTab = tab"
                                      class="border-transparent text-skin-base hover:text-skin-inverted-muted hover:border-skin-base whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none"
                                      :class="{ 'border-green-500 text-green-600 focus:text-green-600 focus:border-green-500': activeTab === tab}"
                                      x-text="capitalize(tab)"
                                    ></button>
                                </template>
                            </nav>
                        </div>
                    </div>

                    <div class="mt-10">
                        <div x-show="activeTab === 'articles'">
                            <livewire:user.articles :user="$user" />
                        </div>
                        <div x-cloak x-show="activeTab === 'discussions'">
                            <livewire:user.discussions :user="$user" />
                        </div>
                        <div x-cloak x-show="activeTab === 'questions'">
                            <livewire:user.threads :user="$user" />
                        </div>
                        <div x-cloak x-show="activeTab === 'badges'">
                            <div class="flex items-center justify-between rounded-md border border-skin-base border-dashed py-8 px-6">
                                <div class="text-center max-w-sm mx-auto">
                                    <x-heroicon-o-badge-check class="h-10 w-10 text-skin-primary mx-auto" />
                                    <p class="mt-1 text-skin-base text-sm leading-5">{{ $user->name }} ne possède aucun badge</p>
                                    <x-button link="#" class="mt-4">
                                        Voir tous les badges
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden lg:block lg:col-span-3">
                <aside aria-label="Sidebar" class="sticky top-4 ml-6">
                    <livewire:user.activities :user="$user" />
                </aside>
            </div>
        </div>
    </x-container>

@endsection
