@props([
    'activity',
])

<x-feeds.feed :date="$activity->created_at">
    <x-slot:icon>
        <x-untitledui-annotation-dots
            class="size-5 text-gray-400 dark:text-gray-500"
            stroke-width="1.5"
            aria-hidden="true"
        />
    </x-slot:icon>

    {{ __('pages/account.activities.answer_reply') }}

    <x-link
        :href="url(
            ($activity->subject->replyable_type === 'discussion' ? '/discussions/' : '/forum/')
            . $activity->subject->replyAble->slug . '#reply-'. $activity->subject->id
        )"
        class="font-medium text-primary-600 hover:text-primary-700 dark:text-primary-500 dark:hover:text-primary-600"
    >
        {{ $activity->subject->replyAble->title }}
    </x-link>

    @if (strlen($activity->subject->excerpt()) > 3)
        <x-slot:content>
            {{ $activity->subject->excerpt() }}
        </x-slot:content>
    @endif
</x-feeds.feed>
