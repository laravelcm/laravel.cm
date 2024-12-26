@props([
    'value',
])

<p {{ $attributes->twMerge(['class' => 'flex items-baseline text-sm font-semibold text-green-600']) }}>
    <x-untitledui-trend-up class="size-5 shrink-0 self-center text-green-500" />
    <span class="sr-only">Augmenté de</span>
    {{ $value }}
</p>
