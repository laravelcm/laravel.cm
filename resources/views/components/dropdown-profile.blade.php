<div @keydown.escape.stop="open = false;" @click.outside="open = false;" class="ml-4 relative shrink-0">
    <div>
        <button type="button" class="bg-skin-menu rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" id="user-menu-button" x-ref="button" @click="open =! open"  aria-expanded="false" aria-haspopup="true" x-bind:aria-expanded="open.toString()">
            <span class="sr-only">{{ __('Ouverture du menu') }}</span>
            <x-user.avatar :user="Auth::user()" class="h-8 w-8" />
        </button>
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="origin-top-right absolute right-0 mt-2 w-60 rounded-md shadow-lg py-1 bg-skin-menu divide-y divide-skin-light ring-1 ring-black ring-opacity-5 focus:outline-none"
         x-ref="menu-items"
         role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
         tabindex="-1"
         @keydown.tab="open = false"
         @keydown.enter.prevent="open = false;"
         @keyup.space.prevent="open = false;"
         style="display: none;">
        <div class="px-3.5 py-3" role="none">
            <p class="text-xs text-skin-base font-normal" role="none">
                {{ __('Connecté en tant que') }}
            </p>
            <p class="text-sm font-medium text-skin-inverted truncate" role="none">
                {{ Auth::user()->email }}
            </p>
        </div>

        @if(Auth::user()->hasRole(['admin', 'moderator']))
            <div class="py-1.5 px-3.5" role="none">
                <a href="{{ route('filament.pages.dashboard') }}" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                    <svg class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                    </svg>
                    {{ __('Administration') }}
                </a>
            </div>
        @endif

        @feature('job_profile')
            <div class="py-2 px-3.5" role="none">
                <div class="flex items-center justify-between">
                    <h5 class="text-sm leading-5 text-skin-base">{{ __('Profil Développeur') }}</h5>
                    <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-800">
                        <svg class="mr-1.5 h-2 w-2 text-orange-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                        </svg>
                        {{ __('Off') }}
                    </span>
                </div>
                <div class="py-1 5">
                    <a href="#" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                        <x-icon.user-edit class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" />
                        {{ __('Mon compte') }}
                    </a>
                    <a href="#" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                        <x-icon.file-attachment class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" />
                        {{ __('Mes candidatures') }}
                    </a>
                    <a href="#" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                        <x-icon.clipboard-document class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" />
                        {{ __('Mes compétences') }}
                    </a>
                    <a href="#" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                        <x-icon.adjustments class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" />
                        {{ __('Préférences') }}
                    </a>
                </div>
                <div class="my-2 px-3 py-2.5 border border-skin-base rounded-md">
                    <h6 class="inline-flex items-center text-sm leading-5 font-medium text-skin-inverted-muted">
                        {{ __('Profil incomplet!') }}
                        <svg class="ml-1.5 text-sky-500 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                        </svg>
                    </h6>
                    <p class="mt-1 text-sm leading-5 text-skin-base">
                        {{ __('Nous avons besoin de plus d\'informations pour vous mettre en relation avec les entreprises.') }}
                    </p>
                    <a href="#" class="inline-block rounded-md mt-3 w-full border border-skin-base px-1.5 py-2 text-center text-sm leading-4 font-medium text-skin-base hover:text-skin-inverted-muted">
                        {{ __('Compléter mon profil') }}
                    </a>
                </div>
            </div>
        @endfeature

        <div class="py-1.5 px-3.5" role="none">
            <a href="{{ route('dashboard') }}" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                <x-icon.grid class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" />
                {{ __('Tableau de bord') }}
            </a>
            <a href="{{ route('profile') }}" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-1">
                <x-icon.profile class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" />
                {{ __('Mon profil') }}
            </a>
            <a href="{{ route('user.settings') }}" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-2">
                <x-icon.settings class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" />
                {{ __('Paramètres') }}
            </a>
            <form method="POST" action="{{ route('logout') }}" role="form">
                @csrf
                <button type="submit" class="group flex items-center text-skin-base hover:text-skin-primary font-normal w-full text-left py-1.5 text-sm" role="menuitem" tabindex="-1" id="logout">
                    <x-icon.logout class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" />
                    {{ __('Se déconnecter') }}
                </button>
            </form>
        </div>
    </div>
</div>
