@props([
    'isSponsored',
])

@if ($isSponsored)
    <span
        class="inline-flex items-center rounded-md bg-linear-to-r from-[#413626] to-[#7E5D36] px-2 py-1.5 text-xs font-medium leading-none text-white"
    >
        {{ __('global.sponsored') }}
    </span>
@endif
