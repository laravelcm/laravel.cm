@props([
    'title',
    'href',
])

<li>
    <x-link :$href class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white">
        {{ $title }}
    </x-link>
</li>
