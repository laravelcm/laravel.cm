<div x-data @scrollToComment.window="window.scrollTo({ top: 0, behavior: 'smooth' })">
    @if ($this->comments->isNotEmpty())
        <div class="mt-10">
            <ul role="list" class="space-y-4">
                @foreach ($this->comments as $comment)
                    <livewire:discussions.comment :comment="$comment" :key="$comment->id" />
                @endforeach
            </ul>
        </div>
    @endif

    @auth
        <livewire:discussions.add-comment :is-root="true" :discussion="$discussion" />
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
