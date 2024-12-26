@php
    /**
    * This files load variables from ViewComposer in AppServiceProvider
    *
    * @see \App\View\Composers\TopContributorsComposer
    * @see \App\View\Composers\InactiveDiscussionsComposer
    */
@endphp

<x-sticky-content class="space-y-12">
    <div>
        <h4 class="font-heading text-lg font-semibold leading-6 text-gray-900 dark:text-white">
            {{ __('pages/discussion.contributors.top') }}
        </h4>
        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
            {{ __('pages/discussion.contributors.description') }}
        </p>
        <div class="mt-6">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($topContributors as $contributor)
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <x-link
                                :href="route('profile', $contributor->username)"
                                class="flex min-w-0 flex-1 items-center"
                            >
                                <div class="shrink-0">
                                    <x-user.avatar :user="$contributor" class="size-8" />
                                </div>
                                <div class="ml-3.5 text-sm">
                                    <p class="truncate font-medium text-gray-900 dark:text-white">
                                        {{ $contributor->name }}
                                    </p>
                                    <p class="truncate text-gray-500 dark:text-gray-400">
                                        {{ '@' . $contributor->username }}
                                    </p>
                                </div>
                            </x-link>
                            <p class="inline-flex items-center gap-1.5">
                                <x-untitledui-message-circle class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                                {{ $contributor->discussions_count }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div>
        <h4 class="font-heading text-lg font-semibold leading-6 text-gray-900">
            {{ __('pages/discussion.empty') }}
        </h4>
        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">
            {{ __('pages/discussion.empty_description') }}
        </p>

        <div class="mt-6">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($discussions as $discussion)
                    <li class="py-4">
                        <div class="flex gap-3">
                            <x-user.avatar :user="$discussion->user" class="size-6" />
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-heading text-sm font-medium text-gray-900 dark:text-white">
                                        <x-link :href="route('profile', $discussion->user->username)" class="hover:underline">
                                            {{ $discussion->user->name }}
                                        </x-link>
                                    </h3>
                                    <time class="truncate text-xs text-gray-400 dark:text-gray-500" datetime="{{ $discussion->created_at }}">
                                        {{ $discussion->created_at->diffForHumans() }}
                                    </time>
                                </div>
                                <x-link
                                    :href="route('discussions.show', $discussion)"
                                    class="inline-flex text-sm leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white"
                                >
                                    {{ $discussion->title }}
                                </x-link>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-sticky-content>
