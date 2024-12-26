<div {{ $attributes->twMerge(['class' => 'rounded-lg bg-gray-100 ring-1 ring-gray-200 p-4 dark:bg-gray-800 dark:ring-white/20']) }}>
    <div class="flex">
        <div class="shrink-0">
            <x-untitledui-lock class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
        </div>
        <div class="ml-3 flex-1 text-gray-500 dark:text-gray-400">
            {{ $slot }}
        </div>
    </div>
</div>
