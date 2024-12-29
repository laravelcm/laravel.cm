@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <svg class="logo" width="32" height="33" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 33">
                <path d="M.16 3.316l6.08 3.473 6.08-3.473L6.24 0 .16 3.316z" fill="#099170" />
                <path d="M19.84 7.105l5.92 3.316 6.08-3.316-6.08-3.473-5.92 3.473z" fill="#FFDC44" />
                <path d="M0 25.895L12.48 33v-6.79l-6.56-3.79v-15L0 3.948v21.948z" fill="#099170" />
                <path
                    d="M26.08 11.053V18L32 14.526l-.016-6.79-5.904 3.317zM13.12 26.21V33l12.32-7.105v-6.79L13.12 26.21z"
                    fill="#FFDC44"
                />
                <path d="M6.56 7.421v14.21l5.92-3.473V3.948L6.56 7.42z" fill="#E21B30" />
                <path d="M19.52 14.526L25.44 18v-6.947l-5.92-3.316v6.79z" fill="#FFDC44" />
                <path d="M6.8 22.184l6 3.395 12.32-7.026L19.2 15 6.8 22.184z" fill="#E21B30" />
            </svg>
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <span style="display: block; margin: 0px 0px 10px 0px">
                Vous recevez cet e-mail, car vous êtes devenu un membre précieux de la communauté Laravel DRC.
            </span>
            <span>
                © {{ date('Y') }} {{ config('app.name') }}.
                @lang('Tous droits reservés.')
            </span>
            <span style="display: block; margin: 10px 0px 0px 0px">Kinshasa - RDC.</span>
        @endcomponent
    @endslot
@endcomponent
