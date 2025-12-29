@props([
    'sponsor',
])

@php
    $isUser = data_get($sponsor->getMetadata('merchant'), 'laravel_cm_id')
@endphp

<div id="{{ $sponsor->id }}">
    <x-link
        href="{{ $isUser ? route('profile', $sponsor->user) : '#' }}"
    >
        @if ($isUser)
            <x-user.avatar
                :user="$sponsor->user"
                :tooltip="$sponsor->user->name"
                size="sm"
            />
        @else
            <flux:avatar
                :name="$sponsor->getMetadata('merchant')['name']"
                :tooltip="$sponsor->getMetadata('merchant')['name']"
                color="emerald"
                size="sm"
                circle
            />
        @endif
    </x-link>
</div>
