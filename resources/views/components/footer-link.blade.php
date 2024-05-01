@props([
    'title',
    'url',
    'soon' => false,
])

<li>
    <a
        href="{{ $url }}"
        class="inline-flex items-center text-base text-skin-base hover:text-skin-menu-hover"
        title="{{ $title }}"
    >
        {{ $title }}
        @if ($soon)
            <span class="ml-2 inline-flex rounded-full bg-green-100 px-1.5 py-0.5 text-xs leading-4 text-green-800">
                Bientôt
            </span>
        @endif
    </a>
</li>
