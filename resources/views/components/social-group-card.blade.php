<div {{ $attributes->merge(['class' => 'relative isolate overflow-hidden flex items-center justify-center mb-6 shadow-md rounded-lg aspect-[2/1] w-full sm:mb-0 xl:mb-6 bg-gradient-to-b']) }}>
    <svg class="absolute inset-0 -z-10 h-full w-full stroke-gray-200/30 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
        <defs>
            <pattern id="0787a7c5-978c-4f66-83c7-11c213f99cb7" width="50" height="50" x="50%" y="-1" patternUnits="userSpaceOnUse">
                <path d="M.5 200V.5H200" fill="none" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" stroke-width="0" fill="url(#0787a7c5-978c-4f66-83c7-11c213f99cb7)" />
    </svg>
    {{ $slot }}
</div>
