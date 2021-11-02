<div class="flow-root">
    <h3 class="mt-4 text-lg leading-6 font-medium text-skin-inverted font-sans">
        Dernières activités de {{ $user->name }}
    </h3>
    <ul role="list" class="mt-6 -mb-8">
        @forelse($activities as $activity)
            <x-dynamic-component :component="'feeds.' . $activity->type" :activity="$activity" />
        @empty
            <x-feeds.placeholder />
        @endforelse
    </ul>
</div>
