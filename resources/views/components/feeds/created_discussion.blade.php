@props([
    'activity',
])

<x-feeds.feed :date="$activity->created_at">
    <x-slot:icon>
        <x-untitledui-rss
            class="size-5 text-gray-400 dark:text-gray-500"
            stroke-width="1.5"
            aria-hidden="true"
        />
    </x-slot:icon>

    {{ __('pages/account.activities.create_discussion') }}
    <x-link
        :href="route('discussions.show', $activity->subject)"
        class="font-medium text-primary-600 hover:text-primary-700 dark:text-primary-500 dark:hover:text-primary-600"
    >
        {{ $activity->subject->title }}
    </x-link>
</x-feeds.feed>
