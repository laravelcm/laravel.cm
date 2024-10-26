<div {{ $attributes->merge(['class' => 'rounded-lg bg-blue-50 p-4 dark:bg-blue-800/20']) }}>
    <div class="flex">
        <div class="shrink-0">
            <x-heroicon-s-information-circle class="size-5 text-blue-400" aria-hidden="true" />
        </div>
        <div class="ml-3 flex-1">
            {{ $slot }}
        </div>
    </div>
</div>
