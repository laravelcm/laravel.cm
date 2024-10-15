<section aria-labelledby="moderators-title">
    <div class="overflow-hidden rounded-xl bg-skin-card shadow">
        <div class="p-6">
            <h2 class="font-heading text-base font-medium text-gray-900" id="moderators-title">Modérateurs</h2>
            <div class="mt-6 flow-root">
                <ul role="list" class="-my-5 divide-y divide-skin-base">
                    @foreach ($moderators as $moderator)
                        <li class="py-4">
                            <div class="flex items-center space-x-4">
                                <div class="shrink-0">
                                    <x-user.avatar :user="$moderator" class="size-8" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-gray-900">
                                        {{ $moderator->name }}
                                    </p>
                                    <p class="truncate text-sm text-gray-500 dark:text-gray-400">
                                        {{ '@' . $moderator->username }}
                                    </p>
                                </div>
                                <div>
                                    <a
                                        href="{{ route('profile', $moderator->username) }}"
                                        class="inline-flex items-center rounded-full border border-skin-base bg-skin-card px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 dark:text-gray-300 shadow-sm hover:bg-skin-footer"
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
