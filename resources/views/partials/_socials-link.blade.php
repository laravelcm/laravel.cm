<div>
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-skin-base"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="bg-skin-body px-2 text-gray-500 dark:text-gray-400">Ou continuer avec</span>
        </div>
    </div>

    <div class="mt-6">
        <div>
            <x-default-button :link="route('social.auth', ['provider' => 'github'])" class="w-full">
                <span class="sr-only">Continuer avec Github</span>
                <x-icon.github class="-ml-1 mr-2 size-5" />
                Github
            </x-default-button>
        </div>
    </div>
</div>
