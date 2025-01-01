@props([
    'title',
])

<x-container class="py-12 sm:py-16 lg:py-24">
    <p class="text-center text-lg font-medium leading-8 text-gray-700 dark:text-gray-300">
        {{ $title }}
    </p>
    <div class="mt-5 flex flex-wrap items-center justify-center gap-8">
        <div class="flex items-center justify-center px-2">
            <a href="https://laravelshopper.dev" target="_blank" class="flex items-center">
                <img
                    loading="lazy"
                    class="h-12 dark:hidden"
                    src="{{ asset('/images/sponsors/shopper-logo.svg') }}"
                    alt="Laravel Shopper"
                />
                <img
                    loading="lazy"
                    class="hidden h-12 dark:block"
                    src="{{ asset('/images/sponsors/shopper-logo-light.svg') }}"
                    alt="Laravel Shopper"
                />
            </a>
        </div>
        <div class="flex items-center justify-center px-2">
            <a href="https://gdg.community.dev/gdg-douala" class="flex items-center" target="_blank">
                <x-icon.gdg class="h-7 text-gray-900 dark:text-white" aria-hidden="true" />
            </a>
        </div>
        <div class="flex items-center justify-center px-2">
            <a href="https://notchpay.co" class="flex items-center" target="_blank">
                <x-icon.notchpay class="h-8 w-auto text-gray-900 dark:text-white" aria-hidden="true" />
            </a>
        </div>
        <div class="flex items-center justify-center px-2">
            <a href="https://sharuco.lndev.me" class="flex items-center" target="_blank">
                <x-icon.sharuco class="h-7 w-auto text-gray-900 dark:text-white" aria-hidden="true" />
                <span class="ml-1 text-2xl font-bold text-gray-900 dark:text-white">Sharuco</span>
            </a>
        </div>
    </div>
    <div class="mt-6 text-center lg:mt-10">
        <x-link
            class="text-sm leading-5 text-flag-green hover:text-green-600 hover:underline"
            target="_blank"
            :href="route('sponsors')"
        >
            {{ __('pages/home.view_logo_question') }}
        </x-link>
    </div>
</x-container>
