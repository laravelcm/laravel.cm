<div class="relative">
    <x-slot:buttons>
        <div class="space-y-3">
            <x-buttons.primary type="button" class="gap-2 w-full justify-center py-2.5">
                {{ __('pages/forum.reply_thread') }}
            </x-buttons.primary>

            @auth
                <livewire:forum.subscribe :thread="$thread" />
            @endauth
        </div>
    </x-slot:buttons>

    <div>
        <div class="flow-root">
            <div role="listbox" class="-mb-8">
                <div class="relative pb-8">
                    <span class="hidden absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-100 dark:bg-white/20 lg:block" aria-hidden="true"></span>
                    <div class="relative flex items-start gap-6">
                        <div class="hidden sticky top-10 lg:block">
                            <x-user.avatar
                                :user="$thread->user"
                                class="size-10 ring-4 ring-white dark:ring-white/20"
                                span="-right-1 size-3.5 -top-1"
                            />
                        </div>
                        <div class="min-w-0 flex-1 rounded-xl bg-white p-5 ring-1 ring-inset ring-gray-200/60 dark:bg-gray-800 dark:ring-white/10 lg:py-6 lg:px-8">
                            <div class="flex items-center gap-2">
                                <x-user.avatar
                                    :user="$thread->user"
                                    class="size-8 lg:hidden"
                                    span="-right-1 size-3.5 -top-1"
                                />
                                <div>
                                    <div class="text-sm flex items-center gap-2">
                                        <x-link :href="route('profile', $thread->user->username)" class="font-medium text-gray-900 dark:text-white">
                                            {{ $thread->user->username }}
                                        </x-link>
                                        <x-user.points class="ring-1 ring-inset ring-gray-200 dark:ring-white/10" :author="$thread->user" />
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500 flex-wrap gap-x-1 dark:text-gray-400 lg:mt-1">
                                        <span>{{ __('global.ask') }}</span>
                                        <time datetime="{{ $thread->created_at }}">
                                            {{ $thread->created_at->diffForHumans() }}
                                        </time>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 py-2 px-4">
                                <h1 class="text-xl font-heading font-bold text-gray-900 dark:text-white leading-7">
                                    {{ $thread->title }}
                                </h1>
                            </div>
                            <div class="mt-5 prose prose-primary max-w-none text-gray-500 dark:text-gray-400 dark:prose-invert">
                                <x-markdown-content :content="$thread->body" />
                            </div>
                            <div class="flex items-center gap-3">
                                <livewire:reactions
                                    wire:key="$thread->id"
                                    :model="$thread"
                                    :with-place-holder="false"
                                    :with-background="false"
                                />
                                <x-forum.thread-metadata :thread="$thread" class="gap-3" />
                            </div>
                        </div>
                    </div>
                </div>

                @if ($thread->replies->isNotEmpty())
                    @foreach ($thread->replies as $reply)
                        <livewire:forum.reply wire:key="$reply->id" :thread="$thread" :reply="$reply" />
                    @endforeach
                @endif
            </div>
        </div>

        @can('create', App\Models\Reply::class)
            @if ($thread->isConversationOld())
                <x-info-panel>
                    <p class="text-sm text-blue-700">
                        {{ __('pages/forum.old_thread') }}
                    </p>
                    <p class="mt-4 text-sm">
                        <x-buttons.default
                            type="button"
                            onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.thread-form' })"
                        >
                            {{ __('pages/forum.new_thread') }}
                            <span aria-hidden="true">&rarr;</span>
                        </x-buttons.default>
                    </p>
                </x-info-panel>
            @else
                <livewire:forum.create-reply :thread="$thread" />
            @endif
        @else
            @guest
                <p class="py-8 text-center text-gray-500 dark:text-gray-400 lg:py-12">
                    {{ __('global.need') }}
                    <x-link :href="route('login')" class="text-primary-600 hover:text-primary-600-hover hover:underline">
                        {{ __('pages/auth.login.page_title') }}
                    </x-link>
                    {{ __('global.or') }}
                    <x-link :href="route('register')" class="text-primary-600 hover:text-primary-600-hover hover:underline">
                        {{ __('pages/auth.register.page_title') }}
                    </x-link>
                    {{ __('pages/forum.collaborate_thread') }}
                </p>
            @else
                <div class="mt-10 flex items-center justify-between gap-x-12 text-gray-500 dark:text-gray-400">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('pages/forum.verify_account') }}
                    </p>

                    <form action="{{ route('verification.send') }}" method="POST" class="block">
                        @csrf
                        <x-buttons.primary type="submit" class="px-3 py-2 gap-2">
                            {{ __('pages/forum.received_link') }}
                            <x-heroicon-o-arrow-long-right class="size-5" aria-hidden="true" />
                        </x-buttons.primary>
                    </form>
                </div>
            @endguest
        @endcan
    </div>
</div>
