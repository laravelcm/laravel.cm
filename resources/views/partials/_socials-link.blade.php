<div>
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="bg-gray-50 px-2 text-gray-500 dark:text-gray-400 dark:bg-gray-900">
                Ou continuer avec
            </span>
        </div>
    </div>

    <div class="mt-6">
        <div>
            <x-buttons.default :link="route('social.auth', ['provider' => 'github'])" class="w-full gap-2">
                <span class="sr-only">Continuer avec Github</span>
                <x-icon.github class="size-5" aria-hidden="true" />
                Github
            </x-buttons.default>
        </div>
    </div>
</div>
