@props(['value'])

<p {{ $attributes->twMerge(['class' => 'flex items-baseline text-sm font-semibold text-red-600']) }}>
    <x-untitledui-trend-down class="self-center shrink-0 h-5 w-5 text-red-500" />
    <span class="sr-only">Diminué de</span> {{ $value }}
</p>
