<x-container class="py-12 lg:pb-20">
    <div class="relative lg:grid lg:grid-cols-7 lg:gap-12">
        <div class="lg:col-span-5 lg:max-w-3xl">
            <nav class="flex items-center gap-2 text-sm" aria-label="Breadcrumb">
                <x-link :href="route('home')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                    {{ __('global.navigation.home') }}
                </x-link>
                <span>
                    <x-untitledui-slash-divider
                        class="size-4 text-gray-400 dark:text-gray-500"
                        stroke-width="1.5"
                        aria-hidden="true"
                    />
                </span>
                <x-link :href="route('discussions.index')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white">
                    {{ __('global.navigation.discussions') }}
                </x-link>
            </nav>

            <header class="mt-8 space-y-5 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 font-heading sm:text-3xl sm:leading-8 dark:text-white">
                        {{ $discussion->title }}
                    </h1>
                    <div class="mt-4 space-x-4 sm:flex sm:items-center">
                        <span class="inline-flex items-center justify-center text-gray-500 rounded-full size-8 bg-white dark:text-gray-400 dark:bg-gray-800">
                            <x-heroicon-s-tag class="size-5" aria-hidden="true" />
                        </span>
                        @if ($discussion->tags->isNotEmpty())
                            <div class="flex items-center space-x-2">
                                @foreach ($discussion->tags as $tag)
                                    <x-tag
                                        :tag="$tag"
                                        :href="route('discussions.index', ['tag' => $tag->slug])"
                                    />
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="relative pb-8">
                    <div class="relative sm:flex sm:space-x-3">
                        <div class="flex items-center sm:items-start">
                            <div class="shrink-0">
                                <x-user.avatar :user="$discussion->user" class="size-10" />
                            </div>
                            <div class="ml-4 sm:hidden">
                                <x-link :href="route('profile', $discussion->user->username)">
                                    <h4 class="inline-flex items-center text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $discussion->user->name }}
                                        @if ($discussion->user->isAdmin() || $discussion->user->isModerator())
                                            <x-user.status />
                                        @endif
                                    </h4>
                                </x-link>
                                <div class="text-sm whitespace-nowrap text-gray-400 dark:text-gray-500">
                                    <time datetime="{{ $discussion->created_at->format('Y-m-d') }}">
                                        {{ $discussion->created_at->diffForHumans() }}
                                    </time>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="hidden sm:block">
                                <x-link :href="route('profile', $discussion->user->username)">
                                    <h4 class="inline-flex items-center text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $discussion->user->name }}
                                        @if ($discussion->user->hasAnyRole('admin', 'moderator'))
                                            <x-user.status />
                                        @endif
                                    </h4>
                                </x-link>
                                <div class="text-sm whitespace-nowrap text-gray-400 dark:text-gray-500">
                                    <time datetime="{{ $discussion->created_at->format('Y-m-d') }}">
                                        {{ $discussion->created_at->diffForHumans() }}
                                    </time>
                                </div>
                            </div>

                            <x-markdown-content
                                class="mx-auto mt-6 text-sm prose prose-sm prose-green max-w-none dark:prose-invert"
                                :content="$discussion->body"
                            />

                            <div class="relative inline-flex mt-3">
                                <livewire:reactions
                                    wire:key="{{ $discussion->id }}"
                                    :model="$discussion"
                                    :with-place-holder="false"
                                    :with-background="false"
                                />
                            </div>

                            @can('update', $discussion)
                                <div class="flex items-center mt-2 space-x-2">
                                    <x-link
                                        href="{{ route('discussions.edit', $discussion) }}"
                                        class="font-sans text-sm leading-5 text-gray-500 dark:text-gray-400 hover:underline focus:outline-none"
                                    >
                                        {{ __('Éditer') }}
                                    </x-link>
                                    <span class="font-medium text-gray-500 dark:text-gray-400">·</span>
                                    <button
                                        onclick="Livewire.dispatch('openModal', {component: 'modals.delete-discussion', arguments: {{ json_encode([$discussion->id]) }})"
                                        type="button"
                                        class="font-sans text-sm leading-5 text-red-500 hover:underline focus:outline-none"
                                    >
                                        {{ __('Supprimer') }}
                                    </button>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex items-center justify-between py-6">
                <p class="font-semibold text-gray-900 dark:text-white">
                    {{ __('pages/discussion.comments_count', ['count' => $discussion->count_all_replies_with_child]) }}
                </p>
                @auth
                    <livewire:discussions.subscribe :discussion="$discussion" />
                @endauth
            </div>

            <livewire:discussions.comments :discussion="$discussion" />
        </div>

        <div class="relative hidden lg:col-span-2 lg:block">
            @include('partials._contributions')
        </div>
    </div>
</x-container>
