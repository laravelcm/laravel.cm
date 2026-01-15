<div x-data class="relative">
    <x-schema.qa-page :$thread />

    <x-slot:buttons>
        @auth
            <div class="space-y-3 px-4">
                <flux:button
                    variant="primary"
                    onclick="Livewire.dispatchTo('components.forum.reply-form', 'replyForm')"
                    class="w-full border-0"
                >
                    {{ __('pages/forum.reply_thread') }}
                </flux:button>
                <livewire:components.forum.subscribe :$thread />
            </div>
        @endauth
    </x-slot:buttons>

    <div>
        <div class="flow-root p-4">
            <div role="listbox" class="-mb-8">
                <div class="relative pb-8">
                    <span class="hidden absolute left-4 top-5 -ml-px h-full w-0.5 bg-gray-100 dark:bg-white/20 lg:block" aria-hidden="true"></span>
                    <div class="relative flex items-start gap-6">
                        <div class="hidden sticky top-20 flex-col justify-center items-center gap-y-5 lg:flex">
                            <x-user.avatar :user="$thread->user" size="sm" />
                            <div class="inline-flex flex-col gap-y-3 ring-1 ring-gray-200 bg-white py-3 px-1.5 rounded-full dark:bg-gray-800 dark:ring-white/20">
                                <livewire:components.reactions
                                    wire:key="$thread->id"
                                    :model="$thread"
                                    :with-place-holder="false"
                                    :with-background="false"
                                    direction="vertical"
                                />
                                <x-forum.thread-metadata :$thread class="gap-3 text-xs" vertical />
                            </div>
                        </div>
                        <div class="group min-w-0 flex-1 rounded-xl bg-white p-4 ring-1 ring-inset text-wrap overflow-hidden ring-gray-200 dark:bg-gray-800 dark:ring-white/10 lg:p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2">
                                    <x-user.avatar :user="$thread->user" size="md" />
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
                                <x-forum.thread-channels :$thread class="hidden lg:flex" />
                            </div>
                            <div class="mt-4 rounded-lg bg-gray-50 dark:bg-gray-900 py-2 px-4">
                                <h1 class="text-xl font-bold text-gray-900 dark:text-white leading-7">
                                    {{ $thread->title }}
                                </h1>
                            </div>

                            <x-markdown-content
                                :content="$thread->body"
                                class="mt-5 prose prose-emerald !prose-heading-off max-w-none text-gray-500 dark:text-gray-400 dark:prose-invert"
                            />

                            <div class="flex items-center justify-between gap-5">
                                @can('manage', $thread)
                                    <div class="mt-5 inline-flex gap-2">
                                        @can('update', $thread)
                                            <flux:button size="xs" variant="ghost" wire:click="edit">
                                                {{ __('actions.edit') }}
                                            </flux:button>
                                        @endcan

                                        @can('delete', $thread)
                                            <flux:button size="xs" variant="danger" class="border-0" wire:click="confirmDelete">
                                                {{ __('actions.delete') }}
                                            </flux:button>
                                        @endcan
                                    </div>
                                @endcan

                                @can('report', $thread)
                                    <livewire:components.report-spam :model="$thread" />
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                @if ($thread->replies->isNotEmpty())
                    @foreach ($thread->replies as $reply)
                        <livewire:components.forum.reply wire:key="$reply->id" :$thread :$reply />
                    @endforeach
                @endif
            </div>
        </div>

        @can('create', App\Models\Reply::class)
            @if ($thread->isConversationOld())
                <div class="p-4 relative">
                    <flux:callout icon="lock-closed" variant="secondary" inline>
                        <flux:callout.heading>{{ __('pages/forum.lock_thread') }}</flux:callout.heading>
                        <flux:callout.text>{{ __('pages/forum.old_thread') }}</flux:callout.text>
                        <x-slot name="actions">
                            <flux:button onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.thread-form' })">
                                {{ __('pages/forum.new_thread') }}
                            </flux:button>
                        </x-slot>
                    </flux:callout>
                </div>
            @else
                <livewire:components.forum.reply-form :$thread />
            @endif
        @else
            @guest
                <p class="py-8 text-center text-gray-500 dark:text-gray-400 lg:py-12">
                    {{ __('global.need') }}
                    <x-link :href="route('login')" class="text-primary-600 hover:text-primary-500 hover:underline">
                        {{ __('pages/auth.login.page_title') }}
                    </x-link>
                    {{ __('global.or') }}
                    <x-link :href="route('register')" class="text-primary-600 hover:text-primary-500 hover:underline">
                        {{ __('pages/auth.register.page_title') }}
                    </x-link>
                    {{ __('pages/forum.collaborate_thread') }}
                </p>
            @else
                <div class="mt-10 flex items-center justify-between gap-12">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('pages/forum.verify_account') }}
                    </p>

                    <form action="{{ route('verification.send') }}" method="POST" class="block">
                        @csrf
                        <flux:button type="submit" variant="primary" class="border-0">
                            {{ __('pages/forum.received_link') }}
                        </flux:button>
                    </form>
                </div>
            @endguest
        @endcan
    </div>

    <flux:modal name="confirm-delete-thread" class="max-w-md">
        <div>
            <flux:heading size="lg">{{ __('actions.confirm_delete_title') }}</flux:heading>
            <flux:subheading>
                <p class="mt-2">
                    {{ __('actions.confirm_delete_thread_message') }}
                </p>
            </flux:subheading>
        </div>

        <div class="mt-6 flex gap-2 justify-end">
            <flux:modal.close>
                <flux:button variant="ghost">{{ __('actions.cancel') }}</flux:button>
            </flux:modal.close>

            <flux:button variant="danger" wire:click="delete">
                {{ __('actions.delete') }}
            </flux:button>
        </div>
    </flux:modal>
</div>
