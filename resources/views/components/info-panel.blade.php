<div {{ $attributes->merge(['class' => 'rounded-md bg-blue-50 p-4']) }}>
    <div class="flex">
        <div class="shrink-0">
            <x-heroicon-s-information-circle class="h-5 w-5 text-blue-400" />
        </div>
        <div class="ml-3 flex-1">
            {{ $slot }}
        </div>
    </div>
</div>
