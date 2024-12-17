@props([
    'sponsor',
])

<li x-data id="{{ $sponsor->id }}">
    <template x-ref="template">
        <div class="w-full max-w-xs rounded-md bg-skin-card px-4 py-2">
            <div class="flex items-center space-x-2">
                @if ($sponsor->getMetadata('merchant')['laravel_cm_id'])
                    <img
                        class="size-8 rounded-full object-cover"
                        src="{{ $sponsor->user->profile_photo_url }}"
                        alt=""
                    />
                @else
                    <svg class="size-8 text-gray-400 dark:text-gray-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path
                            fill-rule="evenodd"
                            d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                            clip-rule="evenodd"
                        />
                    </svg>
                @endif
                <div class="flex items-center text-sm leading-5 text-gray-500 dark:text-gray-400">
                    @if ($sponsor->getMetadata('merchant')['laravel_cm_id'])
                        <span>{{ $sponsor->user->username }}</span>
                        <span class="ml-1 font-medium text-gray-700 dark:text-gray-300">{{ $sponsor->user->name }}</span>
                    @else
                        <span>{{ $sponsor->getMetadata('merchant')['name'] }}</span>
                    @endif
                </div>
            </div>
            @if ($sponsor->getMetadata('merchant')['laravel_cm_id'])
                <p class="line-clamp-3 text-sm leading-5 text-gray-500 dark:text-gray-400">{{ $sponsor->user->bio ?? ' ' }}</p>
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
        href="{{ $sponsor->getMetadata('merchant')['laravel_cm_id'] ? route('profile', ['username' => $sponsor->user->username]) : '#' }}"
    >
        @if ($sponsor->getMetadata('merchant')['laravel_cm_id'])
            <img
                class="mx-auto size-10 rounded-full object-cover"
                src="{{ $sponsor->user->profile_photo_url }}"
                alt=""
            />
        @else
            <span class="flex h-11 w-11 items-center">
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
</li>
