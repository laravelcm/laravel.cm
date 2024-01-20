@props(['value'])

<p {{ $attributes->twMerge(['class' => 'flex items-baseline text-sm font-semibold text-green-600']) }}>
    <x-untitledui-trend-up class="self-center shrink-0 h-5 w-5 text-green-500" />
    <span class="sr-only">Augmenté de</span> {{ $value }}
</p>
