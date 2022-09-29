<div @keydown.escape.stop="open = false;" @click.outside="open = false;" class="ml-4 relative shrink-0">
    <div>
        <button type="button" class="bg-skin-menu rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" id="user-menu-button" x-ref="button" @click="open =! open"  aria-expanded="false" aria-haspopup="true" x-bind:aria-expanded="open.toString()">
            <span class="sr-only">Open user menu</span>
            <img class="h-8 w-8 object-cover rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
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
                <a href="{{ route('cpanel.home') }}" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                    <svg class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                    </svg>
                    {{ __('Administration') }}
                </a>
            </div>
        @endif
        <div class="py-1.5 px-3.5" role="none">
            <a href="{{ route('dashboard') }}" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
                {{ __('Dashboard') }}
            </a>
            <a href="{{ route('profile') }}" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                {{ __('Mon profil') }}
            </a>
            <a href="{{ route('user.settings') }}" class="group flex items-center py-1.5 text-sm text-skin-base hover:text-skin-primary font-normal" role="menuitem" tabindex="-1" id="user-menu-item-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ __('Paramètres') }}
            </a>
        </div>
        <div class="py-1.5 px-3.5" role="none">
            <form method="POST" action="{{ route('logout') }}" role="form">
                @csrf
                <button type="submit" class="group flex items-center text-skin-base hover:text-skin-primary font-normal w-full text-left py-1.5 text-sm" role="menuitem" tabindex="-1" id="logout">
                    <svg stroke="currentColor" fill="none" class="flex-none h-5 w-5 mr-3 text-skin-muted group-hover:text-skin-primary" viewBox="0 0 20 20">
                        <path d="M10.25 3.75H9A6.25 6.25 0 002.75 10v0A6.25 6.25 0 009 16.25h1.25M10.75 10h6.5M14.75 12.25l2.5-2.25-2.5-2.25" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {{ __('Se déconnecter') }}
                </button>
            </form>
        </div>
    </div>
</div>
