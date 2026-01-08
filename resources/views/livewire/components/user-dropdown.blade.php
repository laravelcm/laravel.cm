<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    #[Computed(persist: true)]
    public function user(): User
    {
        return Auth::user()->loadMissing('providers:id,user_id,provider,avatar');
    }
}; ?>

@php
    $user = $this->user;
@endphp

<el-dropdown class="inline-block">
    <button
        type="button"
        class="flex rounded-full bg-white text-sm dark:bg-gray-800 focus:outline-hidden focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900"
    >
        <span class="sr-only">{{ __('global.open_navigation') }}</span>
        <x-user.avatar :$user class="size-7" />
    </button>

    <el-menu
        anchor="bottom end"
        class="m-0 w-60 origin-top-right divide-y divide-gray-200 dark:divide-white/10 rounded-lg  bg-white py-1 shadow ring-1 ring-black/5 dark:bg-gray-900 dark:ring-white/10 transition [--anchor-gap:theme(spacing.2)] [transition-behavior:allow-discrete] data-[closed]:scale-95 data-[closed]:transform data-[closed]:opacity-0 data-[enter]:duration-100 data-[leave]:duration-75 data-[enter]:ease-out data-[leave]:ease-in"
        popover
    >
        <div class="px-3.5 py-3">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ __('global.signed_as') }}
            </p>
            <p class="truncate text-sm font-medium text-gray-900 dark:text-white">
                {{ $user->email }}
            </p>
        </div>

        @if ($user->isAdmin() || $user->isModerator())
            <div class="px-3.5 py-1.5" role="menu">
                <a
                    href="{{ route('filament.cpanel.pages.dashboard') }}"
                    class="group flex items-center gap-2 py-1.5 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white"
                    role="menuitem"
                    tabindex="-1"
                >
                    <img loading="lazy"  class="size-5 object-cover" src="{{ asset('images/filament-icon.png') }}" alt="Filament icon" />
                    {{ __('Administration') }}
                </a>
            </div>
        @endif

        {{--@feature('job_profile')
            <div class="px-3.5 py-2" role="none">
                <div class="flex items-center justify-between">
                    <h5 class="text-sm leading-5 text-gray-500 dark:text-gray-400">Profil Développeur</h5>
                    <span
                        class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-800"
                    >
                        <svg class="mr-1.5 h-2 w-2 text-orange-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                        </svg>
                        Off
                    </span>
                </div>
                <div class="5 py-1">
                    <a
                        href="#"
                        class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >
                        <x-icon.user-edit
                            class="mr-3 size-5 flex-none text-gray-400 dark:gray-500 group-hover:text-primary-600"
                            aria-hidden="true"
                        />
                        Mon compte
                    </a>
                    <a
                        href="#"
                        class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >
                        <x-icon.file-attachment
                            class="mr-3 size-5 flex-none text-gray-400 dark:gray-500 group-hover:text-primary-600"
                            aria-hidden="true"
                        />
                        Mes candidatures
                    </a>
                    <a
                        href="#"
                        class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >
                        <x-icon.clipboard-document
                            class="mr-3 size-5 flex-none text-gray-400 dark:gray-500 group-hover:text-primary-600"
                            aria-hidden="true"
                        />
                        Mes compétences
                    </a>
                    <a
                        href="#"
                        class="group flex items-center py-1.5 text-sm font-normal text-gray-500 dark:text-gray-400 hover:text-primary-600"
                        role="menuitem"
                        tabindex="-1"
                        id="user-menu-item-0"
                    >
                        <x-icon.adjustments
                            class="mr-3 size-5 flex-none text-gray-400 dark:gray-500 group-hover:text-primary-600"
                            aria-hidden="true"
                        />
                        Préférences
                    </a>
                </div>
                <div class="my-2 rounded-md border border-skin-base px-3 py-2.5">
                    <h6 class="inline-flex items-center text-sm font-medium leading-5 text-gray-700 dark:text-gray-300">
                        Profil incomplet !
                        <svg
                            class="ml-1.5 size-4 text-sky-500"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </h6>
                    <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">
                        Nous avons besoin de plus d'informations pour vous mettre en relation avec les entreprises.
                    </p>
                    <a
                        href="#"
                        class="mt-3 inline-block w-full rounded-md border border-skin-base px-1.5 py-2 text-center text-sm font-medium leading-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-300"
                    >
                        Compléter mon profil
                    </a>
                </div>
            </div>
        @endfeature--}}

        <div class="px-3.5 space-y-1.5 py-1.5" role="menu">
            <x-link
                :href="route('dashboard.index')"
                class="group flex items-center gap-2 py-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white"
                role="menuitem"
                tabindex="-1"
            >
                <x-untitledui-grid
                    class="size-5 text-gray-400 dark:gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-300"
                    stroke-width="1.5"
                    aria-hidden="true"
                />
                {{ __('global.navigation.dashboard') }}
            </x-link>
            <x-link
                :href="route('profile', $user)"
                class="group flex items-center gap-2 py-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white"
                role="menuitem"
                tabindex="-1"
            >
                <x-untitledui-user-circle
                    class="size-5 text-gray-400 dark:gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-300"
                    stroke-width="1.5"
                    aria-hidden="true"
                />
                {{ __('global.navigation.profile') }}
            </x-link>
            <x-link
                :href="route('account.index')"
                class="group flex items-center gap-2 py-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white"
                tabindex="-1"
            >
                <x-untitledui-sliders
                    class="size-5 text-gray-400 dark:gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-300"
                    stroke-width="1.5"
                    aria-hidden="true"
                />
                {{ __('global.navigation.account') }}
            </x-link>

            <livewire:components.logout />
        </div>
    </el-menu>
</el-dropdown>
