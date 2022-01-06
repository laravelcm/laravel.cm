@props(['tag'])

<span class="inline-flex items-center leading-none px-2.5 py-1.5 text-sm font-medium text-skin-inverted rounded-full border border-skin-input">
    <svg class="mr-1.5 h-2 w-2 brand-{{ $tag->slug() }}" fill="currentColor" viewBox="0 0 8 8">
        <circle cx="4" cy="4" r="3" />
    </svg>
    {{ $tag->name() }}
</span>
