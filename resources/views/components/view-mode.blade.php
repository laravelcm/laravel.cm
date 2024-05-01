@props([
    'mode',
    'isViewMode' => false,
])

<x-default-button
    type="button"
    wire:click="changeViewMode('{{ $mode }}')"
    @class([
        'border-skin-base shadow-none focus:ring-1',
        'relative bg-skin-button-hover' => $isViewMode,
        'bg-transparent' => ! $isViewMode,
    ])
>
    @if ($isViewMode)
        <span class="absolute right-0 top-0 -mr-1 -mt-1 flex h-3 w-3">
            <span class="relative inline-flex h-3 w-3 rounded-full bg-red-500"></span>
        </span>
    @endif

    {{ $slot }}
</x-default-button>
