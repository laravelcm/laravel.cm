@props([
    'title',
    'url',
    'soon' => false,
])

<li>
    <x-link href="{{ $url }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white">
        {{ $title }}
        @if ($soon)
            <span class="inline-flex rounded-full bg-green-100 px-1.5 py-0.5 text-xs leading-4 text-green-800">
                {{ __('global.soon') }}
            </span>
        @endif
    </x-link>
</li>
