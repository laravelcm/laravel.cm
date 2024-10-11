<x-app-layout :title="$discussion->title">
    <x-container class="py-12">
        <div class="relative lg:grid lg:grid-cols-12 lg:gap-8">
            <div class="lg:col-span-8">
                <header class="space-y-5 border-b border-skin-base">
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 font-heading sm:text-3xl sm:leading-8">
                            {{ $discussion->title }}
                        </h1>
                        <div class="mt-2 space-x-4 sm:flex sm:items-center">
                            <span
                                class="inline-flex items-center justify-center text-gray-500 rounded-full size-8 bg-skin-card-gray dark:text-gray-400"
                            >
                                <x-heroicon-s-tag class="size-5" />
                            </span>
                            @if ($discussion->tags->isNotEmpty())
                                <div class="flex items-center space-x-2">
                                    @foreach ($discussion->tags as $tag)
                                        <x-tag :tag="$tag" />
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="relative pb-8">
                        <div class="relative sm:flex sm:space-x-3">
                            <div class="flex items-center sm:items-start">
                                <div class="relative">
                                    <img
                                        class="object-cover rounded-full size-10 bg-skin-card-gray ring-8 ring-body"
                                        src="{{ $discussion->user->profile_photo_url }}"
                                        alt="{{ $discussion->user->name }}"
                                    />
                                    <span class="absolute -right-1 top-5 rounded-tl bg-skin-body px-0.5 py-px">
                                        <svg
                                            class="size-5 text-skin-muted"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M12 2.25c-2.429 0-4.817.178-7.152.521C2.87 3.061 1.5 4.795 1.5 6.741v6.018c0 1.946 1.37 3.68 3.348 3.97.877.129 1.761.234 2.652.316V21a.75.75 0 001.28.53l4.184-4.183a.39.39 0 01.266-.112c2.006-.05 3.982-.22 5.922-.506 1.978-.29 3.348-2.023 3.348-3.97V6.741c0-1.947-1.37-3.68-3.348-3.97A49.145 49.145 0 0012 2.25zM8.25 8.625a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25zm2.625 1.125a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0zm4.875-1.125a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </span>
                                </div>
                                <div class="ml-4 sm:hidden">
                                    <a href="{{ route('profile', $discussion->user->username) }}">
                                        <h4 class="inline-flex items-center text-sm font-medium text-gray-900">
                                            {{ $discussion->user->name }}
                                            @if ($discussion->user->hasAnyRole('admin', 'moderator'))
                                                <x-user.status />
                                            @endif
                                        </h4>
                                    </a>
                                    <div class="text-sm font-normal whitespace-nowrap text-skin-muted">
                                        <time
                                            class="sr-only"
                                            datetime="{{ $discussion->created_at->format('Y-m-d') }}"
                                        >
                                            {{ $discussion->created_at->diffForHumans() }}
                                        </time>
                                        Crée
                                        <time-ago time="{{ $discussion->created_at->getTimestamp() }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="hidden sm:block">
                                    <a href="{{ route('profile', $discussion->user->username) }}">
                                        <h4 class="inline-flex items-center text-sm font-medium text-gray-900">
                                            {{ $discussion->user->name }}
                                            @if ($discussion->user->hasAnyRole('admin', 'moderator'))
                                                <x-user.status />
                                            @endif
                                        </h4>
                                    </a>
                                    <div class="text-sm font-normal whitespace-nowrap text-skin-muted">
                                        <time
                                            class="sr-only"
                                            datetime="{{ $discussion->created_at->format('Y-m-d') }}"
                                        >
                                            {{ $discussion->created_at->diffForHumans() }}
                                        </time>
                                        Crée
                                        <time-ago time="{{ $discussion->created_at->getTimestamp() }}" />
                                    </div>
                                </div>
                                <x-markdown-content
                                    class="mx-auto mt-3 text-sm prose text-gray-500 prose-green max-w-none dark:text-gray-400 md:prose-lg"
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
                                @can(App\Policies\DiscussionPolicy::UPDATE, $discussion)
                                    <div class="flex items-center mt-2 space-x-2">
                                        <a
                                            href="{{ route('discussions.edit', $discussion) }}"
                                            class="font-sans text-sm leading-5 text-gray-500 dark:text-gray-400 hover:underline focus:outline-none"
                                        >
                                            {{ __('Éditer') }}
                                        </a>
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
                    <p class="font-sans font-semibold text-gray-900" id="comments-count">
                        {{ __('Commentaires (:count)', ['count' => $discussion->count_all_replies_with_child]) }}
                    </p>
                    @auth
                        <livewire:discussions.subscribe :discussion="$discussion" />
                    @endauth
                </div>

                <livewire:discussions.comments :discussion="$discussion" />
            </div>
            <div class="hidden lg:col-span-3 lg:col-start-10 lg:block">
                @include('discussions._contributions')
            </div>
        </div>
    </x-container>
</x-app-layout>
