@props([
    'offset' => '5rem',
])

<aside {{ $attributes->twMerge(['class' => 'sticky']) }} style="top: calc({{ $offset }} + var(--banner-height))">
    {{ $slot }}
</aside>
