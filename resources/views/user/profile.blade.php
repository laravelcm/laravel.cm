@title("{$user->username} ({$user->name})")
@canonical(route('profile', $user->username))

@extends('layouts.large')

@section('body')

    <div>
        <div>
            <img class="h-32 w-full object-cover lg:h-48" src="{{ asset('images/profile-banner.png') }}" alt="Profile Banner">
        </div>
        <x-container class="max-w-7xl mx-auto px-4">
            <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                <div class="flex">
                    <x-user.avatar
                        :user="$user"
                        class="h-24 w-24 !ring-4 ring-card sm:h-32 sm:w-32"
                        span="right-1 top-0 ring-4 h-6 w-6"
                    />
                </div>
                <div class="mt-6 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
                    <div class="sm:hidden md:block mt-6 min-w-0 flex-1">
                        <h1 class="inline-flex items-center text-2xl font-bold text-skin-inverted truncate">
                            <span class="font-heading">{{ $user->name }}</span>

                            <x-user.points :author="$user" />

                            @if($user->hasAnyRole('admin', 'moderator'))
                                <x-user.status />
                            @endif
                        </h1>
                        <p class="text-sm text-skin-base font-normal">
                            {{ __('Inscrit') }} <time-ago time="{{ $user->created_at->getTimestamp() }}"/>
                        </p>
                    </div>
                    <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                        @if ($user->isLoggedInUser())
                            <x-default-button :link="route('user.settings')">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-skin-muted" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                                {{ __('Éditer') }}
                            </x-default-button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="hidden sm:block md:hidden mt-6 min-w-0 flex-1">
                <h1 class="text-2xl font-bold text-skin-inverted truncate font-sans">
                    {{ $user->name }}
                </h1>
                <p class="text-sm text-skin-base font-normal">
                    {{ __('Inscrit') }} <time-ago time="{{ $user->created_at->getTimestamp() }}"/>
                </p>
            </div>
        </x-container>
    </div>

    <x-container class="py-10 w-full max-w-7xl mx-auto px-4">
        <div class="space-y-6 lg:grid lg:grid-cols-2 lg:gap-6 lg:space-y-0">
            <div>
                <h3 class="text-lg leading-6 font-medium font-sans text-skin-inverted">{{ __('Biographie') }}</h3>
                <p class="mt-2 text-skin-base font-normal">
                    {{ $user->bio ?? '...' }}
                </p>
                <div class="mt-4 mb-6 flex items-center gap-x-4">
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

                    @if ($user->linkedin())
                        <a href="https://www.linkedin.com/in/{{ $user->linkedin() }}" class="text-skin-base hover:text-[#004182]">
                            <x-icon.linkedin class="w-6 h-6" />
                        </a>
                    @endif
                </div>
            </div>
            <div>
                <dl class="grid grid-cols-1 gap-x-3 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-skin-base font-sans">
                            {{ __('Localisation') }}
                        </dt>
                        <dd class="mt-1 text-skin-inverted-muted font-normal">
                            {{ $user->location ?? '...' }}
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-skin-base font-sans">
                            {{ __('Site internet') }}
                        </dt>
                        <dd class="mt-1 text-skin-inverted-muted font-normal">
                            @if ($user->website)
                                <a href="{{ $user->website }}" target="_blank" class="inline-flex items-center text-skin-primary hover:text-skin-primary-hover">
                                    {{ $user->website }}
                                    <svg class="ml-1.5 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                    </svg>
                                </a>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="relative border-t border-skin-base mt-6 pt-6 sm:pt-0 sm:border-0 lg:grid lg:grid-cols-8 lg:gap-12">
            <div
                class="lg:col-span-6"
                x-data="{
                    tabSelected: 1,
                    tabId: $id('tabs'),
                    tabButtonClicked(tabButton) {
                        this.tabSelected = tabButton.id.replace(this.tabId + '-', '')
                        this.tabRepositionMarker(tabButton)
                    },
                    tabRepositionMarker(tabButton) {
                        this.$refs.tabMarker.style.width = tabButton.offsetWidth + 'px'
                        this.$refs.tabMarker.style.height = tabButton.offsetHeight + 'px'
                        this.$refs.tabMarker.style.left = tabButton.offsetLeft + 'px'
                    },
                    tabContentActive(tabContent) {
                        return this.tabSelected == tabContent.id.replace(this.tabId + '-content-', '')
                    }
                }"
                x-init="tabRepositionMarker($refs.tabButtons.firstElementChild)"
            >
                <div class="relative w-full">
                    <div x-ref="tabButtons" class="relative w-full lg:max-w-md inline-grid items-center justify-center w-full h-10 grid-cols-3 p-1 text-skin-base bg-skin-card rounded-lg select-none">
                        <button :id="$id(tabId)" @click="tabButtonClicked($el)" type="button" class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-medium transition-all rounded-md cursor-pointer whitespace-nowrap">
                            {{ __('Articles') }}
                        </button>
                        <button :id="$id(tabId)" @click="tabButtonClicked($el)" type="button" class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-medium transition-all rounded-md cursor-pointer whitespace-nowrap">
                            {{ __('Discussions') }}
                        </button>
                        <button :id="$id(tabId)" @click="tabButtonClicked($el)" type="button" class="relative z-20 inline-flex items-center justify-center w-full h-8 px-3 text-sm font-medium transition-all rounded-md cursor-pointer whitespace-nowrap">
                            {{ __('Questions') }}
                        </button>
                        <div x-ref="tabMarker" class="absolute left-0 z-10 w-1/2 h-full duration-300 ease-out" x-cloak>
                            <div class="w-full h-full bg-skin-body rounded-md shadow-sm"></div>
                        </div>
                    </div>

                    <div class="mt-8 content">
                        <div :id="$id(tabId + '-content')" x-show="tabContentActive($el)">
                            <x-user.articles :user="$user" :articles="$articles" />
                        </div>
                        <div x-cloak :id="$id(tabId + '-content')" x-show="tabContentActive($el)">
                            <x-user.discussions :user="$user" :discussions="$discussions" />
                        </div>
                        <div x-cloak :id="$id(tabId + '-content')" x-show="tabContentActive($el)">
                            <x-user.threads :user="$user" :threads="$threads" />
                        </div>
                        <div x-cloak :id="$id(tabId + '-content')" x-show="tabContentActive($el)">
                            <div class="flex items-center justify-between rounded-md border border-skin-base border-dashed py-8 px-6">
                                <div class="text-center max-w-sm mx-auto">
                                    <svg class="h-10 w-10 text-skin-primary mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                    </svg>
                                    <p class="mt-1 text-skin-base text-sm leading-5">
                                        {{ __(':name ne possède aucun badge', ['name' => $user->name]) }}
                                    </p>
                                    <x-button link="#" class="mt-4">
                                        {{ __('Voir tous les badges') }}
                                    </x-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container>

@endsection
