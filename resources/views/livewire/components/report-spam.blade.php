<div class="flex flex-1 items-end justify-end">
    <div class="opacity-0 group-hover:opacity-100">
        {{ $this->reportAction }}
    </div>

    <template x-teleport="body">
        <x-filament-actions::modals />
    </template>
</div>
