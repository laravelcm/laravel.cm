<div class="relative flex p-4 gap-4">
    <x-user.avatar :user="$comment->user" />
    <div class="flex-1 min-w-0">
        <div class="space-y-2">
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="flex-1 flex items-center gap-2 min-w-0">
                    <x-link
                        :href="route('profile', $comment->user)"
                        class="font-medium truncate block text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white"
                    >
                        {{ $comment->user->name }}
                    </x-link>
                    <flux:badge size="sm" class="shrink-0">{{ $comment->user->getPoints() }} XP</flux:badge>
                </div>
                <time
                    datetime="{{ $comment->created_at->format('Y-m-d') }}"
                    class="text-xs shrink-0 capitalize leading-5 text-gray-500 dark:text-gray-400"
                >
                    {{ $comment->created_at->isoFormat('LL') }}
                </time>
            </div>

            @can ('delete', $comment)
                <button
                    type="button"
                    wire:click="delete"
                    wire:confirm="{{ __('pages/discussion.confirm_comment_remove') }}"
                    class="inline-flex items-center text-xs leading-5 text-red-500 hover:underline focus:outline-hidden"
                >
                    {{ __('actions.delete') }}
                </button>
            @endcan
        </div>

        <x-markdown-content
            :content="$comment->body"
            class="prose prose-emerald text-sm mt-2 max-w-none dark:prose-invert"
        />

        <button
            type="button"
            @if(auth()->check())
                wire:click="toggleLike"
            @endif
            @class([
                'inline-flex items-center mt-4 gap-2 text-sm hover:text-rose-500',
                'text-rose-500' => $count > 0,
                'text-gray-500 dark:text-gray-400' => $count === 0,
            ])
        >
            <x-phosphor-heart-half-duotone class="size-5" aria-hidden="true" />
            <span>{{ __('global.like', ['count' => $count]) }}</span>
        </button>
    </div>
</div>
