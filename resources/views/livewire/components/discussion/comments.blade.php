<div class="divide-y divide-dotted divide-gray-200 dark:divide-white/20">
    @if ($this->comments->isNotEmpty())
        <ul role="list">
            @foreach ($this->comments as $comment)
                <li class="comment" id="reply-{{ $comment->id }}">
                    <livewire:components.discussion.comment :$comment :key="$comment->id" />
                </li>
            @endforeach
        </ul>
    @endif

    @auth
        <div @class([
            'p-4 relative flex gap-3',
        ])>
            <x-user.avatar :user="auth()->user()" />

            <form wire:submit="save" class="min-w-0 flex-1">
                <x-markdown-editor
                    wire:model="body"
                    height="200px"
                    :toolbarItems="[
                        ['bold', 'italic'],
                        ['ul', 'ol'],
                        ['link'],
                        ['code', 'codeblock'],
                    ]"
                />

                <div class="mt-3 flex items-center justify-end">
                    <flux:button type="submit" variant="primary" class="border-0">
                        {{ __('actions.save') }}
                    </flux:button>
                </div>
            </form>
        </div>
    @else
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
    @endauth
</div>
