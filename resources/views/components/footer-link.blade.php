@props(['title', 'url', 'soon' => false])

<li>
    <a href="{{ $url }}" class="inline-flex items-center text-base text-skin-base hover:text-skin-menu-hover" title="{{ $title }}">
        {{ $title }}
        @if($soon)
            <span class="inline-flex ml-2 text-xs leading-4 text-green-800 bg-green-100 py-0.5 px-1.5 rounded-full">
                {{ __('Bientôt') }}
            </span>
        @endif
    </a>
</li>
