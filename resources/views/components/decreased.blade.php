@props([
    'value',
])

<p {{ $attributes->twMerge(['class' => 'flex items-baseline text-sm font-semibold text-red-600']) }}>
    <x-untitledui-trend-down class="size-5 shrink-0 self-center text-red-500" />
    <span class="sr-only">Diminué de</span>
    {{ $value }}
</p>
