@props(['value'])

<p {{ $attributes->merge(['class' => 'flex items-baseline text-sm font-semibold text-green-600']) }}>
    <x-heroicon-s-arrow-sm-up class="self-center shrink-0 h-5 w-5 text-green-500" />
    <span class="sr-only"> Increased by </span> {{ $value }}
</p>
