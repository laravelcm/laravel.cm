@props([
    'user',
])

<flux:avatar
    {{ $attributes }}
    :src="$user->profile_photo_url"
    :name="$user->username"
    circle
/>
