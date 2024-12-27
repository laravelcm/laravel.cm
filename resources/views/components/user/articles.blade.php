@props([
    'user',
    'articles',
])

<div>
    @if ($articles->isNotEmpty())
        <div class="-mt-6 divide-y divide-gray-200 dark:divide-white/20">
            @foreach ($articles as $article)
                <div class="py-6">
                    <x-articles.card :article="$article" is-summary />
                </div>
            @endforeach
        </div>
    @else
        <x-empty-state>
            <div class="relative">
                <div class="absolute scale-90 shadow inset-x-0 -top-4 flex items-start -z-10 bg-white gap-3 p-3 rounded-lg ring-1 ring-gray-200/50 dark:bg-gray-900 dark:ring-white/10">
                </div>
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-flag-green to-flag-red rounded-lg blur opacity-25"></div>
                    <div class="relative flex items-start z-20 bg-white gap-3 p-3 rounded-lg ring-1 ring-gray-200/50 dark:bg-gray-900 dark:ring-white/10">
                        <div class="w-1/4 h-20 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-lg dark:bg-gray-800"></div>
                        <div class="w-3/4 pt-2 space-y-2">
                            <div class="grid grid-cols-3 gap-2 w-2/3">
                                <div class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800"></div>
                                <div class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800"></div>
                                <div class="h-3 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded dark:bg-gray-800"></div>
                            </div>
                            <div class="h-4 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800"></div>
                            <div class="h-6 bg-gray-50 ring-1 ring-gray-200/50 dark:ring-white/20 rounded-md dark:bg-gray-800"></div>
                        </div>
                    </div>
                </div>
                <div class="absolute scale-[0.8] inset-x-0 -z-10 shadow -bottom-3 flex items-start bg-white gap-3 p-3 rounded-lg ring-1 ring-gray-200/50 dark:bg-gray-900 dark:ring-white/10">
                </div>
            </div>
            <div class="mt-8 space-y-4">
                <p class="mt-8 text-base text-gray-500 dark:text-gray-400">
                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ $user->name }}</span>
                    {{ __('pages/account.activities.empty_articles') }}
                </p>

                @if ($user->isLoggedInUser())
                    @can('create', \App\Models\Article::class)
                        <x-buttons.primary
                            type="button"
                            onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.article-form' })"
                        >
                            <x-untitledui-file-06 class="size-5" aria-hidden="true" />
                            {{ __('global.launch_modal.article_action') }}
                        </x-buttons.primary>
                    @endcan
                @endif
            </div>
        </x-empty-state>
    @endif
</div>
