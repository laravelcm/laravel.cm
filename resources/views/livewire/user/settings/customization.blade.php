<div class="pb-20">
    <div class="flex items-center">
        <div class="flex-1">
            <h3 class="text-lg leading-6 font-medium text-skin-inverted">
                Profil
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-skin-base font-normal">
                Vous trouverez ci-dessous les informations de votre profil pour votre compte.
            </p>
        </div>
        <div>
            <x-loader wire:loading wire:target="theme" class="text-flag-green ml-3 mr-0"/>
        </div>
    </div>
    <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
        <div class="sm:items-start sm:border-t sm:border-skin-base sm:pt-5">
            <fieldset x-data="{ value: '', active: @entangle('theme') }">
                <legend class="sr-only">Selection du thème</legend>

                <div class="sm:grid sm:grid-cols-3 sm:gap-10">
                    <label class="relative block overflow-hidden rounded-md border border-skin-input bg-skin-card shadow-sm cursor-pointer hover:border-skin-base focus:outline-none" :class="{ 'ring-1 ring-green-500': (active === 'theme-light'), 'undefined': !(active === 'theme-light') }">
                        <input type="radio" wire:model="theme" name="theme" value="theme-light" class="sr-only" aria-labelledby="theme-0-label" aria-describedby="theme-0-description-0 theme-0-description-1">
                        <div class="aspect-w-3 aspect-h-2">
                            <img class="object-cover " src="{{ asset('/images/themes/theme-light.png') }}" alt="Theme light">
                        </div>
                        <div class="px-3 py-2">
                            <div class="text-sm">
                                <div id="theme-0-label" class="flex items-center space-x-3 font-medium text-skin-inverted">
                                    <h4 class="flex items-center items-center"><x-heroicon-o-sun class="h-5 w-5 mr-2 text-yellow-500" /> Thème Light</h4>
                                    @if($theme === 'theme-light')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div id="theme-0-description-0" class="mt-2 text-xs text-skin-muted leading-4 font-sans">
                                <span>Ce thème sera actif par défaut lorsque votre système sera réglé sur « Mode light »</span>
                            </div>
                        </div>
                        <div class="absolute -inset-px rounded-md border-2 pointer-events-none border-transparent" aria-hidden="true" :class="{ 'border-green-500': (value === 'theme-light'), 'border-transparent': !(value === 'theme-light') }"></div>
                    </label>

                    <label class="mt-5 relative block overflow-hidden rounded-md border border-skin-input bg-skin-card shadow-sm cursor-pointer hover:border-skin-base focus:outline-none sm:mt-0" :class="{ 'ring-1 ring-green-500': (active === 'theme-dark'), 'undefined': !(active === 'theme-dark') }">
                        <input type="radio" wire:model="theme" name="theme" value="theme-dark" class="sr-only" aria-labelledby="theme-1-label" aria-describedby="theme-1-description-0 theme-1-description-1">
                        <div class="aspect-w-3 aspect-h-2">
                            <img class="object-cover " src="{{ asset('/images/themes/theme-dark.png') }}" alt="Theme dark">
                        </div>
                        <div class="px-3 py-2">
                            <div class="text-sm">
                                <div id="theme-1-label" class="flex items-center space-x-3 font-medium text-skin-inverted">
                                    <h4 class="flex items-center items-center"><x-heroicon-o-moon class="h-5 w-5 mr-2 text-skin-inverted-muted" /> Thème Dark</h4>
                                    @if($theme === 'theme-dark')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div id="theme-1-description-0" class="mt-2 text-xs text-skin-muted leading-4 font-sans">
                                <span>Ce thème sera actif par défaut lorsque votre système sera réglé sur « Mode dark »</span>
                            </div>
                        </div>
                        <div class="absolute -inset-px rounded-md border-2 pointer-events-none border-green-500" aria-hidden="true" :class="{ 'border-green-500': (value === 'theme-dark'), 'border-transparent': !(value === 'theme-dark') }"></div>
                    </label>
                </div>
            </fieldset>
        </div>
    </div>
</div>
