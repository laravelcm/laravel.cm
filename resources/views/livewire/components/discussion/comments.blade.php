<div>
    @if ($this->comments->isNotEmpty())
        <ul role="list" class="space-y-5">
            @foreach ($this->comments as $comment)
                <li class="comment" id="reply-{{ $comment->id }}">
                    <livewire:components.discussion.comment :$comment :key="$comment->id" />
                </li>
            @endforeach
        </ul>
    @endif

    @auth
        <div class="mt-6 relative flex gap-3">
            <x-user.avatar :user="\Illuminate\Support\Facades\Auth::user()" class="size-10" />

            <form wire:submit="save" class="min-w-0 flex-1">
                {{ $this->form }}

                <div class="mt-3 flex items-center justify-end">
                    <x-buttons.submit wire:loading.attr="data-loading">
                        {{ __('actions.save') }}
                    </x-buttons.submit>
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
