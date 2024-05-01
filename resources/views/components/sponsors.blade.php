<div {{ $attributes->twMerge(['class' => 'text-right']) }}>
    <h4 class="font-sans text-sm font-semibold uppercase leading-5 tracking-wide text-skin-inverted">Sponsors</h4>
    <div class="mt-5 space-y-5">
        <a href="https://laravelshopper.io" class="flex items-center justify-end">
            <img
                class="logo-white h-10"
                src="{{ asset('/images/sponsors/shopper-logo.svg') }}"
                alt="Laravel Shopper"
            />
            <img
                class="logo-dark h-10"
                src="{{ asset('/images/sponsors/shopper-logo-light.svg') }}"
                alt="Laravel Shopper"
            />
        </a>
        <a href="https://gdg.community.dev/gdg-douala" class="flex items-center justify-end py-2">
            <x-icon.gdg class="h-5 w-auto text-skin-inverted" />
        </a>
        <a href="https://notchpay.co" class="flex items-center justify-end py-2">
            <x-icon.notchpay class="h-6 w-auto text-skin-inverted" />
        </a>
        <a href="https://www.dark-code.cm" class="flex items-center justify-end py-2">
            <x-icon.darkcode class="h-4 w-auto text-skin-inverted" />
        </a>
        <a href="https://sharuco.lndev.me" class="flex items-center justify-end py-2">
            <x-icon.sharuco class="h-6 w-auto text-skin-inverted" />
            <span class="ml-1 text-xl font-bold text-skin-inverted">Sharuco</span>
        </a>
    </div>
</div>
