<section aria-labelledby="moderators-title">
    <div class="overflow-hidden rounded-xl bg-skin-card shadow">
        <div class="p-6">
            <h2 class="font-heading text-base font-medium text-skin-inverted" id="moderators-title">Modérateurs</h2>
            <div class="mt-6 flow-root">
                <ul role="list" class="-my-5 divide-y divide-skin-base">
                    @foreach ($moderators as $moderator)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="shrink-0">
                                    <x-user.avatar :user="$moderator" class="h-8 w-8" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-skin-inverted">
                                        {{ $moderator->name }}
                                    </p>
                                    <p class="truncate text-sm text-skin-base">
                                        {{ '@' . $moderator->username }}
                                    </p>
                                </div>
                                <div>
                                    <a
                                        href="{{ route('profile', $moderator->username) }}"
                                        class="inline-flex items-center rounded-full border border-skin-base bg-skin-card px-2.5 py-0.5 text-sm font-medium leading-5 text-skin-inverted-muted shadow-sm hover:bg-skin-footer"
                                    >
                                        Voir
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
