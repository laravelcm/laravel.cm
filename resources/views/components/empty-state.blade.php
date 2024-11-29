@php
    $id = uniqid();
@endphp

<div {{ $attributes->twMerge(['class' => 'relative isolate overflow-hidden flex items-center justify-center rounded-xl px-6 py-20 bg-white ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-white/20']) }}>
    <div class="mx-auto max-w-sm text-center">
        <svg class="absolute inset-0 -z-10 h-1/2 w-full stroke-gray-200 dark:stroke-white/10 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
            <defs>
                <pattern id="983e3e4c-de6d-4c3f-8d64-b9761d1534cc{{ $id }}" width="75" height="75" x="50%" y="-1" patternUnits="userSpaceOnUse">
                    <path d="M.5 200V.5H200" fill="none" />
                </pattern>
            </defs>
            <svg x="50%" y="-1" class="overflow-visible fill-gray-50 dark:fill-gray-900">
                <path d="M-200 0h201v201h-201Z M600 0h201v201h-201Z M-400 600h201v201h-201Z M200 800h201v201h-201Z" stroke-width="0" />
            </svg>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#983e3e4c-de6d-4c3f-8d64-b9761d1534cc{{ $id }})" />
        </svg>

        {{ $slot }}
    </div>
</div>
