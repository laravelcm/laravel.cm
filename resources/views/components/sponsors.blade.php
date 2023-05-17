<div {{ $attributes->merge(['class' => 'text-right']) }}>
    <h4 class="text-skin-inverted text-sm leading-5 font-semibold uppercase tracking-wide font-sans">
        {{ __('Sponsors') }}
    </h4>
    <div class="mt-5 space-y-5">
        <a href="https://laravelshopper.io" class="flex items-center justify-end">
            <img class="h-10 logo-white" src="{{ asset('/images/sponsors/shopper-logo.svg') }}" alt="Laravel Shopper">
            <img class="h-10 logo-dark" src="{{ asset('/images/sponsors/shopper-logo-light.svg') }}" alt="Laravel Shopper">
        </a>
        <a href="https://gdg.community.dev/gdg-douala" class="flex items-center justify-end py-2">
            <x-icon.gdg class="w-auto h-5 text-skin-inverted"/>
        </a>
        <a href="https://notchpay.co" class="flex items-center justify-end py-2">
            <x-icon.notchpay class="w-auto h-6 text-skin-inverted"/>
        </a>
        <a href="https://www.dark-code.cm" class="flex items-center justify-end py-2">
            <x-icon.darkcode class="w-auto h-4 text-skin-inverted"/>
        </a>
        <a href="https://sharuco.lndev.me" class="flex items-center justify-end py-2">
            <x-icon.sharuco class="w-auto h-6 text-skin-inverted"/>
            <span class="ml-1 text-xl text-skin-inverted font-bold">Sharuco</span>
        </a>
    </div>
</div>
