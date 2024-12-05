<div>
    <h3 class="font-heading font-medium text-lg/7 text-gray-900 dark:text-white">
        {{ __('pages/account.activities.latest_of', ['name' => $user->name]) }}
    </h3>
    <ul role="list" class="mt-6 -mb-8">
        @forelse($activities as $activity)
            @if($activity->subject)
                <li>
                    <x-dynamic-component
                        :component="'feeds.' . $activity->type"
                        :folder="$activity->getTable()"
                        :activity="$activity"
                    />
                </li>
            @endif
        @empty
            <li>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('pages/account.activities.empty') }}
                    </p>
                </div>
            </li>
        @endforelse
    </ul>
</div>
