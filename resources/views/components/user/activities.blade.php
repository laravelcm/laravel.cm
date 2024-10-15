@props([
    'user',
    'activities',
])

<div class="flow-root">
    <h3 class="mt-4 font-heading text-lg font-medium leading-6 text-gray-900">
        Dernières activités de {{ $user->name }}
    </h3>
    <ul role="list" class="-mb-8 mt-6">
        @forelse ($activities as $activity)
            @if (! str_ends_with($activity->type, 'reply'))
                <x-dynamic-component
                    :component="'feeds.' . $activity->type"
                    :folder="$activity->getTable()"
                    :activity="$activity"
                />
            @endif
        @empty
            <x-feeds.placeholder />
        @endforelse
    </ul>
</div>
