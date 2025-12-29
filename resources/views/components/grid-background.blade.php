@php
    $patternId = 'grid-pattern-' . uniqid();
@endphp

<svg {{ $attributes->twMerge(['class' => 'absolute inset-0 size-full']) }} xmlns="http://www.w3.org/2000/svg">
    <defs>
        <pattern id="{{ $patternId }}" x="0" y="0" width="156" height="144" patternUnits="userSpaceOnUse">
            <g fill="currentColor">
                <circle cx="6" cy="6" r="3" fill-opacity=".12"/>
                <circle cx="18" cy="6" r="3" fill-opacity=".12"/>
                <circle cx="30" cy="6" r="3" fill-opacity=".04"/>
                <circle cx="42" cy="6" r="3" fill-opacity=".04"/>
                <circle cx="54" cy="6" r="3" fill-opacity=".08"/>
                <circle cx="66" cy="6" r="3" fill-opacity=".04"/>
                <circle cx="78" cy="6" r="3" fill-opacity=".04"/>
                <circle cx="90" cy="6" r="3" fill-opacity=".12"/>
                <circle cx="102" cy="6" r="3" fill-opacity=".08"/>
                <circle cx="114" cy="6" r="3" fill-opacity=".12"/>
                <circle cx="126" cy="6" r="3" fill-opacity=".12"/>
                <circle cx="138" cy="6" r="3" fill-opacity=".04"/>
                <circle cx="150" cy="6" r="3" fill-opacity=".12"/>

                <circle cx="6" cy="18" r="3" fill-opacity=".08"/>
                <circle cx="18" cy="18" r="3" fill-opacity=".08"/>
                <circle cx="30" cy="18" r="3" fill-opacity=".04"/>
                <circle cx="42" cy="18" r="3" fill-opacity=".04"/>
                <circle cx="54" cy="18" r="3" fill-opacity=".12"/>
                <circle cx="66" cy="18" r="3" fill-opacity=".08"/>
                <circle cx="78" cy="18" r="3" fill-opacity=".12"/>
                <circle cx="90" cy="18" r="3" fill-opacity=".04"/>
                <circle cx="102" cy="18" r="3" fill-opacity=".04"/>
                <circle cx="114" cy="18" r="3" fill-opacity=".08"/>
                <circle cx="126" cy="18" r="3" fill-opacity=".12"/>
                <circle cx="138" cy="18" r="3" fill-opacity=".04"/>
                <circle cx="150" cy="18" r="3" fill-opacity=".12"/>

                <circle cx="6" cy="30" r="3" fill-opacity=".08"/>
                <circle cx="18" cy="30" r="3" fill-opacity=".04"/>
                <circle cx="30" cy="30" r="3" fill-opacity=".08"/>
                <circle cx="42" cy="30" r="3" fill-opacity=".04"/>
                <circle cx="54" cy="30" r="3" fill-opacity=".12"/>
                <circle cx="66" cy="30" r="3" fill-opacity=".08"/>
                <circle cx="78" cy="30" r="3" fill-opacity=".04"/>
                <circle cx="90" cy="30" r="3" fill-opacity=".08"/>
                <circle cx="102" cy="30" r="3" fill-opacity=".04"/>
                <circle cx="114" cy="30" r="3" fill-opacity=".12"/>
                <circle cx="126" cy="30" r="3" fill-opacity=".04"/>
                <circle cx="138" cy="30" r="3" fill-opacity=".12"/>
                <circle cx="150" cy="30" r="3" fill-opacity=".04"/>

                <circle cx="6" cy="42" r="3" fill-opacity=".04"/>
                <circle cx="18" cy="42" r="3" fill-opacity=".04"/>
                <circle cx="30" cy="42" r="3" fill-opacity=".04"/>
                <circle cx="42" cy="42" r="3" fill-opacity=".12"/>
                <circle cx="54" cy="42" r="3" fill-opacity=".08"/>
                <circle cx="66" cy="42" r="3" fill-opacity=".12"/>
                <circle cx="78" cy="42" r="3" fill-opacity=".08"/>
                <circle cx="90" cy="42" r="3" fill-opacity=".04"/>
                <circle cx="102" cy="42" r="3" fill-opacity=".04"/>
                <circle cx="114" cy="42" r="3" fill-opacity=".12"/>
                <circle cx="126" cy="42" r="3" fill-opacity=".08"/>
                <circle cx="138" cy="42" r="3" fill-opacity=".12"/>
                <circle cx="150" cy="42" r="3" fill-opacity=".12"/>

                <circle cx="6" cy="54" r="3" fill-opacity=".08"/>
                <circle cx="18" cy="54" r="3" fill-opacity=".12"/>
                <circle cx="30" cy="54" r="3" fill-opacity=".12"/>
                <circle cx="42" cy="54" r="3" fill-opacity=".08"/>
                <circle cx="54" cy="54" r="3" fill-opacity=".04"/>
                <circle cx="66" cy="54" r="3" fill-opacity=".12"/>
                <circle cx="78" cy="54" r="3" fill-opacity=".12"/>
                <circle cx="90" cy="54" r="3" fill-opacity=".08"/>
                <circle cx="102" cy="54" r="3" fill-opacity=".04"/>
                <circle cx="114" cy="54" r="3" fill-opacity=".08"/>
                <circle cx="126" cy="54" r="3" fill-opacity=".04"/>
                <circle cx="138" cy="54" r="3" fill-opacity=".12"/>
                <circle cx="150" cy="54" r="3" fill-opacity=".04"/>

                <circle cx="6" cy="66" r="3" fill-opacity=".08"/>
                <circle cx="18" cy="66" r="3" fill-opacity=".12"/>
                <circle cx="30" cy="66" r="3" fill-opacity=".12"/>
                <circle cx="42" cy="66" r="3" fill-opacity=".04"/>
                <circle cx="54" cy="66" r="3" fill-opacity=".12"/>
                <circle cx="66" cy="66" r="3" fill-opacity=".12"/>
                <circle cx="78" cy="66" r="3" fill-opacity=".08"/>
                <circle cx="90" cy="66" r="3" fill-opacity=".04"/>
                <circle cx="102" cy="66" r="3" fill-opacity=".04"/>
                <circle cx="114" cy="66" r="3" fill-opacity=".04"/>
                <circle cx="126" cy="66" r="3" fill-opacity=".12"/>
                <circle cx="138" cy="66" r="3" fill-opacity=".12"/>
                <circle cx="150" cy="66" r="3" fill-opacity=".12"/>

                <circle cx="6" cy="78" r="3" fill-opacity=".04"/>
                <circle cx="18" cy="78" r="3" fill-opacity=".12"/>
                <circle cx="30" cy="78" r="3" fill-opacity=".08"/>
                <circle cx="42" cy="78" r="3" fill-opacity=".04"/>
                <circle cx="54" cy="78" r="3" fill-opacity=".08"/>
                <circle cx="66" cy="78" r="3" fill-opacity=".12"/>
                <circle cx="78" cy="78" r="3" fill-opacity=".12"/>
                <circle cx="90" cy="78" r="3" fill-opacity=".08"/>
                <circle cx="102" cy="78" r="3" fill-opacity=".04"/>
                <circle cx="114" cy="78" r="3" fill-opacity=".04"/>
                <circle cx="126" cy="78" r="3" fill-opacity=".04"/>
                <circle cx="138" cy="78" r="3" fill-opacity=".12"/>
                <circle cx="150" cy="78" r="3" fill-opacity=".08"/>

                <circle cx="6" cy="90" r="3" fill-opacity=".04"/>
                <circle cx="18" cy="90" r="3" fill-opacity=".12"/>
                <circle cx="30" cy="90" r="3" fill-opacity=".12"/>
                <circle cx="42" cy="90" r="3" fill-opacity=".04"/>
                <circle cx="54" cy="90" r="3" fill-opacity=".12"/>
                <circle cx="66" cy="90" r="3" fill-opacity=".08"/>
                <circle cx="78" cy="90" r="3" fill-opacity=".08"/>
                <circle cx="90" cy="90" r="3" fill-opacity=".12"/>
                <circle cx="102" cy="90" r="3" fill-opacity=".08"/>
                <circle cx="114" cy="90" r="3" fill-opacity=".08"/>
                <circle cx="126" cy="90" r="3" fill-opacity=".08"/>
                <circle cx="138" cy="90" r="3" fill-opacity=".04"/>
                <circle cx="150" cy="90" r="3" fill-opacity=".04"/>

                <circle cx="6" cy="102" r="3" fill-opacity=".08"/>
                <circle cx="18" cy="102" r="3" fill-opacity=".08"/>
                <circle cx="30" cy="102" r="3" fill-opacity=".04"/>
                <circle cx="42" cy="102" r="3" fill-opacity=".04"/>
                <circle cx="54" cy="102" r="3" fill-opacity=".08"/>
                <circle cx="66" cy="102" r="3" fill-opacity=".04"/>
                <circle cx="78" cy="102" r="3" fill-opacity=".12"/>
                <circle cx="90" cy="102" r="3" fill-opacity=".08"/>
                <circle cx="102" cy="102" r="3" fill-opacity=".08"/>
                <circle cx="114" cy="102" r="3" fill-opacity=".04"/>
                <circle cx="126" cy="102" r="3" fill-opacity=".04"/>
                <circle cx="138" cy="102" r="3" fill-opacity=".04"/>
                <circle cx="150" cy="102" r="3" fill-opacity=".04"/>

                <circle cx="6" cy="114" r="3" fill-opacity=".04"/>
                <circle cx="18" cy="114" r="3" fill-opacity=".12"/>
                <circle cx="30" cy="114" r="3" fill-opacity=".12"/>
                <circle cx="42" cy="114" r="3" fill-opacity=".04"/>
                <circle cx="54" cy="114" r="3" fill-opacity=".04"/>
                <circle cx="66" cy="114" r="3" fill-opacity=".08"/>
                <circle cx="78" cy="114" r="3" fill-opacity=".12"/>
                <circle cx="90" cy="114" r="3" fill-opacity=".04"/>
                <circle cx="102" cy="114" r="3" fill-opacity=".08"/>
                <circle cx="114" cy="114" r="3" fill-opacity=".12"/>
                <circle cx="126" cy="114" r="3" fill-opacity=".04"/>
                <circle cx="138" cy="114" r="3" fill-opacity=".08"/>
                <circle cx="150" cy="114" r="3" fill-opacity=".08"/>

                <circle cx="6" cy="126" r="3" fill-opacity=".12"/>
                <circle cx="18" cy="126" r="3" fill-opacity=".04"/>
                <circle cx="30" cy="126" r="3" fill-opacity=".08"/>
                <circle cx="42" cy="126" r="3" fill-opacity=".04"/>
                <circle cx="54" cy="126" r="3" fill-opacity=".04"/>
                <circle cx="66" cy="126" r="3" fill-opacity=".12"/>
                <circle cx="78" cy="126" r="3" fill-opacity=".04"/>
                <circle cx="90" cy="126" r="3" fill-opacity=".04"/>
                <circle cx="102" cy="126" r="3" fill-opacity=".04"/>
                <circle cx="114" cy="126" r="3" fill-opacity=".08"/>
                <circle cx="126" cy="126" r="3" fill-opacity=".04"/>
                <circle cx="138" cy="126" r="3" fill-opacity=".08"/>
                <circle cx="150" cy="126" r="3" fill-opacity=".04"/>

                <circle cx="6" cy="138" r="3" fill-opacity=".12"/>
                <circle cx="18" cy="138" r="3" fill-opacity=".04"/>
                <circle cx="30" cy="138" r="3" fill-opacity=".04"/>
                <circle cx="42" cy="138" r="3" fill-opacity=".12"/>
                <circle cx="54" cy="138" r="3" fill-opacity=".12"/>
                <circle cx="66" cy="138" r="3" fill-opacity=".04"/>
                <circle cx="78" cy="138" r="3" fill-opacity=".12"/>
                <circle cx="90" cy="138" r="3" fill-opacity=".12"/>
                <circle cx="102" cy="138" r="3" fill-opacity=".08"/>
                <circle cx="114" cy="138" r="3" fill-opacity=".12"/>
                <circle cx="126" cy="138" r="3" fill-opacity=".04"/>
                <circle cx="138" cy="138" r="3" fill-opacity=".04"/>
                <circle cx="150" cy="138" r="3" fill-opacity=".04"/>
            </g>
        </pattern>
    </defs>
    <rect width="100%" height="100%" fill="url(#{{ $patternId }})" />
</svg>
