<x-container class="px-0 lg:line-x">
    <x-schema.discussion :$discussion />

    <div class="pt-20 pb-16 lg:pt-28 " x-data>
        <div class="relative lg:grid lg:grid-cols-7 lg:gap-12">
            <div class="lg:col-span-5 lg:max-w-4xl lg:border-y lg:border-line lg:border-r">
                <div class="px-4 border-b border-line">
                    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('discussions') }}

                    <header class="mt-4">
                        <div>
                            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 font-heading sm:text-3xl sm:leading-8 dark:text-white">
                                {{ $discussion->title }}
                            </h1>
                            <div class="mt-4 flex items-center flex-wrap gap-2">
                                <span class="inline-flex items-center justify-center text-gray-500 rounded-full size-8 bg-white ring-1 ring-gray-200 dark:ring-white/10 dark:text-gray-400 dark:bg-gray-800">
                                    <x-heroicon-s-tag class="size-5" aria-hidden="true" />
                                </span>

                                @if ($discussion->tags->isNotEmpty())
                                    <div class="flex items-center gap-x-2">
                                        @foreach ($discussion->tags as $tag)
                                            <x-tag :$tag :href="route('discussions.index', ['tag' => $tag->slug])" />
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="mt-6 relative group">
                            <div class="flex items-start gap-3">
                                <div class="shrink-0">
                                    <x-user.avatar :user="$discussion->user" />
                                </div>
                                <div>
                                    <x-link
                                        :href="route('profile', $discussion->user->username)"
                                        class="inline-flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >
                                        {{ $discussion->user->name }}

                                        @if ($discussion->user->isAdmin() || $discussion->user->isModerator())
                                            <x-user.status />
                                        @endif
                                    </x-link>
                                    <div class="text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                        <time datetime="{{ $discussion->created_at->format('Y-m-d') }}">
                                            {{ $discussion->created_at->diffForHumans() }}
                                        </time>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 flex-1 min-w-0">
                                <x-markdown-content
                                    class="mx-auto mt-6 text-sm prose prose-emerald max-w-none dark:prose-invert"
                                    :content="$discussion->body"
                                />

                                <div class="relative inline-flex mt-3">
                                    <livewire:components.reactions
                                        wire:key="{{ $discussion->id }}"
                                        :model="$discussion"
                                        :with-place-holder="false"
                                        :with-background="false"
                                    />
                                </div>

                                <div class="mt-6 flex items-center gap-4">
                                    {{--@can('manage', $discussion)
                                        <x-filament-actions::group
                                            icon="untitledui-dots-horizontal"
                                            color="gray"
                                            :actions="[
                                                $this->editAction,
                                                $this->convertedToThreadAction,
                                                $this->deleteAction,
                                            ]"
                                        />
                                    @endcan--}}

                                    @can('report', $discussion)
                                        <livewire:components.report-spam :model="$discussion" />
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </header>
                </div>

                <div class="divide-y ml-px divide-dotted divide-gray-300 dark:divide-white/20">
                    <div class="flex items-start gap-2 dark:bg-gray-950/60 px-4 py-2">
                        <x-phosphor-chats-duotone class="size-5 shrink-0 text-primary-600 dark:text-primary-500" aria-hidden="true" />
                        <p class="text-gray-700 dark:text-gray-400 tracking-wider text-xs font-mono uppercase">
                            {{ __('pages/discussion.comments_count') }}
                        </p>
                    </div>

                    <livewire:components.discussion.comments :$discussion />
                </div>
            </div>

            <div class="hidden relative border-l border-y border-line lg:col-span-2 lg:block">
                <x-sticky-content class="space-y-12 bg-dotted after:border-0">
                    <livewire:components.discussion.top-contributors />

                    <livewire:components.discussion.no-comment-discussions />
                </x-sticky-content>
            </div>
        </div>
    </div>
</x-container>
