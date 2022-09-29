@props(['isSponsored'])

@if($isSponsored)
    <span class="inline-flex items-center leading-none px-2.5 py-2 text-sm font-medium text-white rounded-full bg-gradient-to-r from-[#413626] to-[#7E5D36] font-sans">
        {{ __('Sponsorisé') }}
    </span>
@endif
