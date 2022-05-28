<div>
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-skin-base"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-skin-body text-skin-base font-normal">
                {{ __('Ou continuer avec') }}
            </span>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-2 gap-2">
        <div>
            <x-default-button :link="route('social.auth', ['provider' => 'github'])" class="w-full font-normal">
                <span class="sr-only">{{ __('Continuer avec Github') }}</span>
                <x-icon.github class="w-5 h-5 mr-2 -ml-1" />
                Github
            </x-default-button>
        </div>

        <div>
            <x-default-button :link="route('social.auth', ['provider' => 'twitter'])" class="w-full font-normal">
                <span class="sr-only">{{ __('Continuer avec Twitter') }}</span>
                <x-icon.twitter class="w-5 h-5 mr-2 -ml-1 text-[#1E9DEA]" />
                Twitter
            </x-default-button>
        </div>
    </div>
</div>
