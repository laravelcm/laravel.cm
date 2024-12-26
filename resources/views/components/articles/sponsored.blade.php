@props([
    'isSponsored',
])

@if ($isSponsored)
    <span
        class="inline-flex items-center rounded-full bg-gradient-to-r from-[#413626] to-[#7E5D36] px-2.5 py-2 font-sans text-sm font-medium leading-none text-white"
    >
        {{ __('global.sponsored') }}
    </span>
@endif
