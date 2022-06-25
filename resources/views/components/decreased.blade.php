@props(['value'])

<p {{ $attributes->merge(['class' => 'flex items-baseline text-sm font-semibold text-red-600']) }}>
    <x-heroicon-s-arrow-sm-down class="self-center shrink-0 h-5 w-5 text-red-500" />
    <span class="sr-only">Decreased by</span> {{ $value }}
</p>
