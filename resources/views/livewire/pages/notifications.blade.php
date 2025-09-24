<div>
    <x-container class="py-12">
        <div>
            <x-user.breadcrumb section="Notifications" />

            <h2
                class="inline-flex items-center gap-x-2 font-heading text-xl font-bold leading-7 text-gray-900 dark:text-white sm:truncate sm:text-2xl"
            >
                {{ __('Notifications') }}
                <livewire:components.notification-count />
            </h2>
        </div>

        <section class="relative mt-8">
            <div>
                @forelse ($notifications as $date => $record)
                    <div class="pb-10">
                        <div>
                            <h2
                                id="notification-date-{{ Str::slug($date) }}"
                                class="inline-flex items-center gap-x-3 rounded-full bg-primary-600/20 px-2.5 py-1.5 font-heading text-sm font-medium text-white"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="size-5"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"
                                    />
                                </svg>
                                {{ $date }}
                            </h2>
                        </div>

                        <div class="mt-4 flow-root">
                            <ul role="list" class="-mb-2">
                                @foreach ($record as $notification)
                                    @includeIf("components.notifications.{$notification->data['type']}")
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @empty
                    <div
                        class="mx-auto flex max-w-lg items-center justify-between rounded-lg border border-dashed border-gray-200 dark:border-white/10 px-6 py-8"
                    >
                        <div class="mx-auto max-w-sm text-center">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="mx-auto size-10 text-primary-600"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                                />
                            </svg>
                            <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">
                                {{ __('pages/notification.empty') }}
                            </p>
                        </div>
                    </div>

                    <div class="mx-auto mt-10 max-w-lg">
                        <h2 class="font-heading text-lg font-medium text-gray-900 dark:text-white">
                            {{ __('pages/notification.new_content') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('pages/notification.choose_content') }}
                        </p>
                        <ul role="list" class="mt-6 divide-y divide-gray-200 dark:divide-white/10 border-b border-t border-gray-200 dark:border-white/10">
                            <li>
                                <div class="group relative flex items-start space-x-3 py-4">
                                    <div class="shrink-0">
                                        <span class="inline-flex size-10 items-center justify-center rounded-lg bg-flag-green">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="size-6 text-white"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12.75 19.5v-.75a7.5 7.5 0 00-7.5-7.5H4.5m0-6.75h.75c7.87 0 14.25 6.38 14.25 14.25v.75M6 18.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
                                                />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            <a href="#" onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.article-form' })">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                {{ __('pages/notification.article_action') }}
                                            </a>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('pages/notification.share_content') }}
                                        </p>
                                    </div>
                                    <div class="shrink-0 self-center">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="size-5 text-gray-400 group-hover:text-gray-500 dark:text-gray-400"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="group relative flex items-start space-x-3 py-4">
                                    <div class="shrink-0">
                                        <span class="inline-flex size-10 items-center justify-center rounded-lg bg-flag-red">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="size-6 text-white"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"
                                                />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            <a href="#" onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.discussion-form' })">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                {{ __('pages/notification.start_discussion') }}
                                            </a>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('pages/notification.start_discussion_description_text') }}
                                        </p>
                                    </div>
                                    <div class="shrink-0 self-center">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="size-5 text-gray-400 group-hover:text-gray-500 dark:text-gray-400"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="group relative flex items-start space-x-3 py-4">
                                    <div class="shrink-0">
                                        <span class="inline-flex size-10 items-center justify-center rounded-lg bg-yellow-500">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="size-6 text-white"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"
                                                />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            <a href="#" onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.thread-form' })">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                {{ __('pages/notification.ask_help') }}
                                            </a>
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('pages/notification.ask_help_description') }}
                                        </p>
                                    </div>
                                    <div class="shrink-0 self-center">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="size-5 text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-400"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                        </svg>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                @endforelse
            </div>
        </section>
    </x-container>
</div>
