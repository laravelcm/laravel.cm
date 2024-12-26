@php
    $isSolution = $thread->isSolutionReply($reply);
@endphp

<div x-data class="relative pb-8" id="reply-{{ $reply->id }}">
    <span class="hidden absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-100 dark:bg-white/20 lg:block" aria-hidden="true"></span>
    <div class="relative flex items-start gap-6">
        <div class="hidden sticky top-10 lg:block">
            <x-user.avatar
                :user="$reply->user"
                class="size-10 ring-4 ring-white dark:ring-white/20"
                span="-right-1 size-3.5 -top-1"
            />
        </div>
        <div
            @class([
                'group min-w-0 flex-1 rounded-xl p-5 ring-1 ring-inset lg:py-6 lg:px-8',
                'ring-green-500 bg-green-50 ring-2 dark:bg-green-800/20 dark:ring-primary-600' => $isSolution,
                'ring-gray-200/60 bg-white dark:bg-gray-800 dark:ring-white/10' => ! $isSolution,
           ])
        >
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-2">
                    <x-user.avatar
                        :user="$reply->user"
                        class="size-8 lg:hidden"
                        span="-right-1 size-3.5 -top-1"
                    />
                    <div>
                        <div class="text-sm flex items-center gap-2">
                            <x-link :href="route('profile', $reply->user->username)" class="font-medium text-gray-900 dark:text-white">
                                {{ $reply->user->username }}
                            </x-link>
                            <x-user.points class="ring-1 ring-inset ring-gray-200 dark:ring-white/10" :author="$reply->user" />
                        </div>
                        <div class="flex items-center text-xs text-gray-500 flex-wrap gap-x-1 dark:text-gray-400 lg:mt-1">
                            <span>{{ __('global.posted') }}</span>
                            <time datetime="{{ $reply->created_at }}">
                                {{ $reply->created_at->diffForHumans() }}
                            </time>
                        </div>
                    </div>
                </div>
                @if($isSolution)
                    <div class="inline-flex items-center rounded-full px-4 py-1.5 text-xs font-medium text-white bg-flag-green">
                        {{ __('pages/forum.best_answer') }}
                    </div>
                @endif
            </div>
            <x-markdown-content
                class="mt-5 prose prose-green !prose-heading-off max-w-none space-y-3 text-gray-500 dark:text-gray-400 dark:prose-invert"
                :content="$reply->body"
            />
            <div class="mt-4 flex items-center justify-between">
                @if(! $thread->isSolutionReply($reply))
                    @can('manage', $reply)
                        <x-filament-actions::group
                            icon="untitledui-dots-horizontal"
                            color="gray"
                            :actions="[
                                $this->editAction,
                                $this->solutionAction,
                                $this->deleteAction,
                            ]"
                        />
                    @endcan

                    @can('report', $reply)
                        <livewire:report-spam :model="$reply" />
                    @endcan
                @endif
            </div>
        </div>
    </div>

    <template x-teleport="body">
        <x-filament-actions::modals />
    </template>
</div>
