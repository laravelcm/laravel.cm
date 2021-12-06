<div {{ $attributes->merge(['class' => 'text-right']) }}>
    <h4 class="text-skin-inverted text-sm leading-5 font-semibold uppercase tracking-wide font-sans">Sponsors</h4>
    <div class="mt-5 space-y-6">
        <a href="https://twitter.com/DarkCodeCompany" class="flex items-center justify-end">
            <x-icon.darkcode class="h-5 text-skin-inverted"/>
        </a>
        <a href="https://laravelshopper.io" class="flex items-center justify-end">
            <img class="h-10 logo-white" src="{{ asset('/images/sponsors/shopper-logo.svg') }}" alt="Laravel Shopper">
            <img class="h-10 logo-dark" src="{{ asset('/images/sponsors/shopper-logo-light.svg') }}" alt="Laravel Shopper">
        </a>
        <a href="https://gdg.community.dev/gdg-douala" class="flex items-center justify-end">
            <x-icon.gdg class="w-auto h-5 text-skin-inverted"/>
        </a>
    </div>
</div>
