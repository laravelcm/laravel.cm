@props(['mode', 'isViewMode' => false])

<x-default-button
    type="button"
    wire:click="changeViewMode('{{ $mode }}')"
    @class([
        'border-skin-base shadow-none focus:ring-1',
        'relative bg-skin-button-hover' => $isViewMode,
        'bg-transparent' => ! $isViewMode,
    ])
>
    @if($isViewMode)
        <span class="flex absolute h-3 w-3 top-0 right-0 -mt-1 -mr-1">
            <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
        </span>
    @endif

        {{ $slot }}
</x-default-button>
