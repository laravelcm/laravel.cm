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
                            @if($user->isAdmin())
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-green-100 text-green-800">
                                    Admin
                                </span>
                            @endif
                            @if($user->isModerator())
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                                    Modérateur
                                </span>
                            @endif
                        </h1>
                        <p class="text-sm font-medium text-skin-base font-normal">
                            {{ __('Inscrit depuis') }} <time datetime="{{ $user->created_at->format('Y-m-d') }}">{{ $user->created_at->toFormattedDateString() }}</time>
                        </p>
                    </div>
                    <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                        @if ($user->isLoggedInUser())
                            <x-default-button :link="route('user.settings')">
                                <x-heroicon-o-pencil class="-ml-1 mr-2 h-5 w-5 text-skin-muted" />
                                Edit
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
                    {{ __('Inscrit depuis') }} <time datetime="{{ $user->created_at->format('Y-m-d') }}">{{ $user->created_at->toFormattedDateString() }}</time>
                </p>
            </div>
        </x-container>
    </div>

    <x-container class="py-10 max-w-7xl mx-auto px-4">
        <div class="space-y-6 sm:grid sm:grid-cols-2 sm:gap-6 sm:space-y-0">
            <div>
                <h3 class="text-lg leading-6 font-medium font-sans text-skin-inverted">{{ __('Biographie') }}</h3>
                <p class="mt-2 text-skin-base font-normal">
                    {{ $user->bio }}
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
                            {{ $user->location }}
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

        <div class="relative lg:grid lg:grid-cols-8 lg:gap-12">
            <div class="lg:col-span-5">
                <div>
                    <div class="sm:hidden">
                        <label for="tabs" class="sr-only">Select a tab</label>
                        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                        <select id="tabs" name="tabs" class="block w-full pl-3 pr-10 py-2 text-base border-skin-base focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                            <option>My Account</option>

                            <option>Company</option>

                            <option selected>Team Members</option>

                            <option>Billing</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="border-b border-skin-base">
                            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                <!-- Current: "border-green-500 text-green-600", Default: "border-transparent text-skin-base hover:text-skin-inverted-muted hover:border-skin-base" -->
                                <button type="button" class="border-transparent text-skin-base hover:text-skin-inverted-muted hover:border-skin-base whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Articles
                                </button>

                                <button type="button" class="border-transparent text-skin-base hover:text-skin-inverted-muted hover:border-skin-base whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Discussions
                                </button>

                                <button type="button" class="border-green-500 text-green-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
                                    Threads
                                </button>

                                <button type="button" class="border-transparent text-skin-base hover:text-skin-inverted-muted hover:border-skin-base whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Badges
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden lg:block lg:col-span-3">
                <aside aria-label="Sidebar" class="sticky top-4">
                    <div class="flow-root">
                        <h3 class="mt-4 text-lg leading-6 font-medium text-skin-inverted font-sans">
                            Dernières activités de {{ $user->name }}
                        </h3>
                        <ul role="list" class="mt-6 -mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <img class="h-10 w-10 rounded-full bg-skin-card flex items-center justify-center ring-8 ring-card" src="https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="">
                                            <span class="absolute -bottom-0.5 -right-1 bg-skin-card rounded-tl px-0.5 py-px">
                                                <x-heroicon-s-chat-alt class="h-5 w-5 text-skin-muted" />
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <div class="text-sm">
                                                    <a href="#" class="font-medium text-skin-inverted font-sans">Eduardo Benz</a>
                                                </div>
                                                <p class="mt-0.5 text-sm text-skin-base font-sans">
                                                    Commented 6d ago
                                                </p>
                                            </div>
                                            <div class="mt-2 text-sm text-skin-inverted-muted font-normal">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt nunc ipsum tempor purus vitae id. Morbi in vestibulum nec varius. Et diam cursus quis sed purus nam.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
                                    <div class="relative flex items-start space-x-3">
                                        <div>
                                            <div class="relative px-1">
                                                <div class="h-8 w-8 bg-skin-card rounded-full ring-8 ring-card flex items-center justify-center">
                                                    <x-heroicon-s-user-circle class="h-5 w-5 text-skin-base" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1 py-1.5">
                                            <div class="text-sm text-skin-base">
                                                <a href="#" class="font-medium text-skin-inverted font-sans">Hilary Mahy</a>
                                                assigned
                                                <a href="#" class="font-medium text-skin-inverted font-sans">Kristin Watson</a>
                                                <span class="whitespace-nowrap font-sans">2d ago</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
                                    <div class="relative flex items-start space-x-3">
                                        <div>
                                            <div class="relative px-1">
                                                <div class="h-8 w-8 bg-skin-card rounded-full ring-8 ring-card flex items-center justify-center">
                                                    <x-heroicon-s-tag class="h-5 w-5 text-skin-base" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1 py-0">
                                            <div class="text-sm leading-8 text-skin-base">
                                                <span class="mr-0.5">
                                                    <a href="#" class="font-medium text-skin-inverted font-sans">Hilary Mahy</a>
                                                    added tags
                                                </span>
                                                <span class="mr-0.5">
                                                    <a href="#" class="relative inline-flex items-center rounded-full border border-skin-base px-3 py-0.5 text-sm">
                                                      <span class="absolute flex-shrink-0 flex items-center justify-center">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-pink-500" aria-hidden="true"></span>
                                                      </span>
                                                      <span class="ml-3.5 font-medium text-skin-inverted font-sans">Bug</span>
                                                    </a>
                                                    <a href="#" class="relative inline-flex items-center rounded-full border border-skin-base px-3 py-0.5 text-sm">
                                                      <span class="absolute flex-shrink-0 flex items-center justify-center">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-500" aria-hidden="true"></span>
                                                      </span>
                                                      <span class="ml-3.5 font-medium text-skin-inverted font-sans">Accessibility</span>
                                                    </a>
                                                  </span>
                                                <span class="whitespace-nowrap">6h ago</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex items-start space-x-3">
                                        <div class="relative">
                                            <img class="h-10 w-10 rounded-full bg-skin-muted flex items-center justify-center ring-8 ring-card" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80" alt="">

                                            <span class="absolute -bottom-0.5 -right-1 bg-skin-card rounded-tl px-0.5 py-px">
                                                <x-heroicon-s-chat-alt class="h-5 w-5 text-skin-muted" />
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div>
                                                <div class="text-sm">
                                                    <a href="#" class="font-medium text-skin-inverted font-sans">Jason Meyers</a>
                                                </div>
                                                <p class="mt-0.5 text-sm text-skin-base font-sans">
                                                    Commented 2h ago
                                                </p>
                                            </div>
                                            <div class="mt-2 text-sm text-skin-inverted-muted font-normal">
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt nunc ipsum tempor purus vitae id. Morbi in vestibulum nec varius. Et diam cursus quis sed purus nam. Scelerisque amet elit non sit ut tincidunt condimentum. Nisl ultrices eu venenatis diam.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </aside>
            </div>
        </div>

    </x-container>

@endsection
