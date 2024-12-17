<div class="relative pb-2">
    @if ($comment->allChildReplies->isNotEmpty())
        <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200 dark:bg-white/20" aria-hidden="true"></span>
    @endif

    <div class="relative flex gap-4">
        <x-user.avatar class="size-10" :user="$comment->user" />
        <div class="flex-1">
            <div class="text-sm flex items-center gap-3">
                <x-link
                    :href="route('profile', $comment->user)"
                    class="font-medium text-primary-600 hover:text-primary-500"
                >
                    {{ $comment->user->name }}
                </x-link>
                <span class="inline-flex items-center gap-2">
                    <x-filament::badge color="gray">
                        {{ $comment->user->getPoints() }} XP
                    </x-filament::badge>
                    <time
                        datetime="{{ $comment->created_at->format('Y-m-d') }}"
                        class="text-xs capitalize leading-5 text-gray-500 dark:text-gray-400"
                    >
                        {{ $comment->created_at->isoFormat('LL') }}
                    </time>
                </span>

                @can('delete', $comment)
                    <div class="mt-1 flex sm:mt-0">
                        <span class="hidden font-medium text-gray-500 dark:text-gray-400 sm:inline-block">·</span>
                        <div class="flex items-center space-x-2 divide-x divide-skin-base pl-2">
                            <button
                                type="button"
                                wire:click="delete"
                                wire:confirm="{{ __('pages/discussion.confirm_comment_remove') }}"
                                class="inline-flex items-center text-xs leading-5 text-danger-500 hover:underline focus:outline-none"
                            >
                                {{ __('actions.delete') }}
                            </button>
                        </div>
                    </div>
                @endcan
            </div>

            <x-markdown-content
                :content="$comment->body"
                class="prose prose-green mt-2 max-w-none text-sm dark:prose-invert"
            />

            <button
                type="button"
                @if(\Illuminate\Support\Facades\Auth::check())
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
</div>
