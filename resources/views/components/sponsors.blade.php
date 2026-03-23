@props([
    'title',
])

<div {{ $attributes->twMerge(['class' => 'relative bg-white flex divide-x divide-gray-200 dark:divide-white/20 dark:bg-line-black']) }}>
    <div class="hidden px-6 py-4 w-full max-w-xs lg:flex lg:items-center">
        <p class="font-medium font-mono text-gray-900 dark:text-white">
            {{ $title }}
        </p>
    </div>
    <div class="p-6 relative flex-1 flex items-center justify-center lg:col-span-4 lg:py-10">
        <div class="inline-flex flex-wrap items-center justify-center">
            <div class="flex items-center justify-center px-4 py-2.5 lg:px-6">
                <a href="https://certificationforlaravel.com" target="_blank" class="flex items-center">
                    <x-icon.certification-for-laravel class="h-10 w-auto text-gray-900 dark:text-white lg:h-14" aria-hidden="true" />
                </a>
            </div>
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
        </div>
    </div>
</div>
