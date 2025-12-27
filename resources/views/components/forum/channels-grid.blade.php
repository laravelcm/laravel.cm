@props([
    'channels',
])

<div {{ $attributes->twMerge(['class' => 'mt-5 grid gap-4 lg:grid-cols-2']) }}>
    @foreach($channels as $channel)
        <div class="relative rounded-lg transition bg-white duration-200 ease-in-out ring-1 ring-gray-200/70 dark:ring-gray-800 dark:bg-gray-800 px-4 py-3 hover:ring-gray-300 dark:hover:ring-white/20">
            <header class="flex items-center">
                <div class="flex flex-1 items-center gap-2">
                    @if ($channel->color)
                        <span class="block h-4 w-1 rounded-full" style="background-color: {{ $channel->color }}"></span>
                    @endif

                    <x-link href="{{ route('forum.index') }}?channel={{ $channel->slug }}">
                        <span class="font-medium text-gray-700 dark:text-white">{{ $channel->name }}</span>
                        <span class="absolute inset-0"></span>
                    </x-link>
                </div>
                <span class="text-xs font-mono leading-5 text-gray-400 dark:text-gray-500">
                    {{ __('pages/forum.threads_count', ['count' => $channel->threads_count]) }}
                </span>
            </header>
            @if ($channel->description)
                <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                    {{ $channel->description }}
                </p>
            @endif
        </div>
    @endforeach
</div>
