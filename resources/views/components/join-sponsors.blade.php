@props([
    'title',
])

<div class="py-12 sm:py-16 lg:py-24">
    <p class="text-center text-lg font-medium leading-8 text-gray-700 dark:text-gray-300">
        {{ $title }}
    </p>
    <div class="mt-4 py-6 relative flex items-center justify-center border-y border-dotted border-gray-300 dark:border-white/10 lg:py-10">
        <div class="inline-flex flex-wrap items-center justify-center">
            <div class="flex items-center justify-center px-4 py-2.5 lg:px-6">
                <a href="https://shopperlabs.co" target="_blank" class="flex items-center">
                    <x-icon.shopper-labs class="h-6 w-auto text-gray-900 dark:text-white" aria-hidden="true" />
                </a>
            </div>
            <div class="flex items-center justify-center px-4 py-2.5 lg:px-6">
                <a href="https://gdg.community.dev/gdg-douala" class="flex items-center" target="_blank">
                    <x-icon.gdg class="h-6 text-gray-900 dark:text-white" aria-hidden="true" />
                </a>
            </div>
            <div class="flex items-center justify-center px-4 py-2.5 lg:px-6">
                <a href="https://notchpay.co" class="flex items-center" target="_blank">
                    <x-icon.notchpay class="h-6 w-auto text-gray-900 dark:text-white" aria-hidden="true" />
                </a>
            </div>
            <div class="flex items-center justify-center px-4 py-2.5 lg:px-6">
                <a href="https://sharuco.lndev.me" class="flex items-center" target="_blank">
                    <x-icon.sharuco class="h-6 w-auto text-gray-900 dark:text-white" aria-hidden="true" />
                    <span class="ml-1 text-xl font-mono font-bold text-gray-900 dark:text-white">Sharuco</span>
                </a>
            </div>
        </div>
    </div>
    <div class="mt-6 text-center">
        <x-link
            class="text-sm leading-5 text-primary-500 hover:text-primary-600 hover:underline hover:decoration-1 hover:decoration-dotted hover:decoration-primary-500"
            target="_blank"
            :href="route('sponsors')"
        >
            {{ __('pages/home.view_logo_question') }}
        </x-link>
    </div>
</div>
