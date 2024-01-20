@props(['user', 'activities'])

<div class="flow-root">
    <h3 class="mt-4 text-lg leading-6 font-medium text-skin-inverted font-heading">
        Dernières activités de {{ $user->name }}
    </h3>
    <ul role="list" class="mt-6 -mb-8">
        @forelse($activities as $activity)
            @if(! str_ends_with($activity->type, 'reply'))
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
