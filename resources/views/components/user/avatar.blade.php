@props([
    'user',
    'span' => '-right-1 top-0 size-4 ring-2',
    'container' => '',
])

<img
    loading="lazy"
    {{ $attributes->merge(['class' => 'object-cover rounded-full bg-gray-100 dark:bg-gray-900']) }}
    src="{{ $user->profile_photo_url }}"
    alt="{{ $user->username }}"
/>
