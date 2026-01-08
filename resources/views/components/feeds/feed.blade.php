@props([
    'date',
    'icon',
    'content' => null,
])

<div class="relative pb-8">
    <span class="absolute left-3.5 top-5 h-full w-px bg-gray-200 dark:bg-white/20" aria-hidden="true"></span>
    <div class="relative flex gap-4">
        <div class="shrink-0">
            <span class="flex size-7 items-center justify-center rounded-full bg-gray-50 dark:bg-gray-900">
                {{ $icon }}
            </span>
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $slot }}
            </p>
            <div class="mt-1.5 whitespace-nowrap text-sm text-gray-400 dark:text-gray-500">
                <time datetime="{{ $date->format('Y-m-d') }}">
                    {{ $date->diffForHumans() }}
                </time>
            </div>

            @if ($content)
                <div class="mt-2 px-2 py-1.5 ring-1 ring-gray-200 overflow-hidden dark:ring-white/10 rounded-md bg-white dark:bg-gray-800 text-sm text-gray-500 dark:text-gray-400">
                    {!! $content !!}
                </div>
            @endif
        </div>
    </div>
</div>
