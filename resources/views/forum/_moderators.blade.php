<section aria-labelledby="moderators-title">
    <div class="rounded-lg bg-skin-card overflow-hidden shadow">
        <div class="p-6">
            <h2 class="text-base font-medium text-skin-inverted font-heading" id="moderators-title">
                {{ __('Modérateurs') }}
            </h2>
            <div class="flow-root mt-6">
                <ul role="list" class="-my-5 divide-y divide-skin-base">
                    @foreach($moderators as $moderator)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="shrink-0">
                                    <x-user.avatar :user="$moderator" class="h-8 w-8" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-skin-inverted truncate">
                                        {{ $moderator->name }}
                                    </p>
                                    <p class="text-sm text-skin-base truncate">
                                        {{ '@' . $moderator->username }}
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ route('profile', $moderator->username) }}" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-skin-base text-sm leading-5 font-medium rounded-full text-skin-inverted-muted bg-skin-card hover:bg-skin-footer">
                                        {{ __('Voir') }}
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
