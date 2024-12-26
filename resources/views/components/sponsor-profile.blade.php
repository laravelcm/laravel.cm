@props([
    'sponsor',
])

@php
    $isUser = data_get($sponsor->getMetadata('merchant'), 'laravel_cm_id')
@endphp

<div x-data id="{{ $sponsor->id }}">
    <template x-ref="template">
        <div class="w-full max-w-xs px-3 py-2">
            <div class="flex items-center space-x-2">
                @if ($isUser)
                    <x-user.avatar :user="$sponsor->user" class="size-6" />
                @else
                    <svg class="size-6 text-gray-400 dark:text-gray-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path
                            fill-rule="evenodd"
                            d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                @endif

                <div class="flex items-center text-xs/5 text-gray-400">
                    @if ($isUser)
                        <span>{{ $sponsor->user->username }} -</span>
                        <span class="ml-1 font-medium text-gray-300">{{ $sponsor->user->name }}</span>
                    @endif

                    @if(!$isUser && data_get($sponsor->getMetadata('merchant'), 'name'))
                        <span>{{ $sponsor->getMetadata('merchant')['name'] }}</span>
                    @endisset
                </div>
            </div>
            @if ($isUser)
                <p class="line-clamp-2 text-xs/5 text-white">
                    {{ $sponsor->user->bio ? \Illuminate\Support\Str::limit($sponsor->user->bio, 50) : '' }}
                </p>
            @endif
        </div>
    </template>
    <a
        x-tooltip="{
            content: () => $refs.template.innerHTML,
            allowHTML: true,
            appendTo: $root,
        }"
        class="relative inline-flex items-center"
        href="{{ $isUser ? route('profile', $sponsor->user) : '#' }}"
    >
        @if ($isUser)
            <x-user.avatar :user="$sponsor->user" class="size-8" />
        @else
            <span class="flex size-10 items-center">
                <svg class="h-full w-full text-gray-400 dark:text-gray-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path
                        fill-rule="evenodd"
                        d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                        clip-rule="evenodd"
                    />
                </svg>
            </span>
        @endif
    </a>
</div>
