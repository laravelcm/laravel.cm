<div x-data>
    @can('create', App\Models\Discussion::class)
        <div class="flex items-center justify-end mt-4">
            <flux:button
                variant="primary"
                wire:click="$dispatch('openPanel', { component: 'components.slideovers.article-form' })"
                class="border-0"
            >
                {{ __('global.launch_modal.article_action') }}
            </flux:button>
        </div>
    @endcan

    <div class="mt-5 space-y-4">
        @forelse ($this->articles as $article)
            <div wire:key="{{ $article->id }}" class="rounded-xl p-5 bg-white transition duration-200 ease-in-out ring-1 ring-gray-200/50 dark:bg-gray-800 dark:ring-white/10 dark:hover:bg-white/10">
                <div class="flex justify-between gap-3">
                    <div class="flex items-center gap-2 flex-1">
                        @if ($article->isNotPublished())
                            <flux:badge size="sm" color="amber">
                                {{ __('pages/article.draft') }}
                            </flux:badge>
                        @endif

                        @foreach ($article->tags as $tag)
                            <x-tag :$tag />
                        @endforeach
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($article->isNotPublished() && Auth::user()->can('update', $article))
                            <flux:button
                                size="xs"
                                variant="ghost"
                                wire:click="$dispatch(
                                    'openPanel',
                                    { component: 'components.slideovers.article-form', arguments: {'article': {{ $article->id }}} },
                                )"
                            >
                                {{ __('actions.edit') }}
                            </flux:button>
                        @endif

                        @can('delete', $article)
                            <flux:button
                                size="xs"
                                variant="danger"
                                class="border-0"
                                wire:click="confirmDelete({{ $article->id }})"
                            >
                                {{ __('actions.delete') }}
                            </flux:button>
                        @endcan
                    </div>
                </div>

                <x-link :href="route('articles.show', $article->slug)" class="block">
                    <div class="mt-4 flex items-center justify-between">
                        <h3 class="font-heading/7 text-xl font-semibold text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-500">
                            {{ $article->title }}
                        </h3>
                    </div>

                    <p class="mt-3 text-base/6 text-gray-500 dark:text-gray-400">
                        {{ $article->excerpt() }}
                    </p>
                </x-link>

                <div class="mt-6 flex items-center justify-between">
                    <div class="flex text-sm leading-5 text-gray-500 dark:text-gray-400">
                        @if ($article->isPublished())
                            <time datetime="{{ $article->submitted_at->format('Y-m-d') }}">
                                {{ __('Publié le :date', ['date' => $article->submitted_at->format('j M, Y')]) }}
                            </time>
                        @else
                            @if ($article->isAwaitingApproval())
                                <span> {{ __('pages/article.awaiting_text') }} </span>
                            @else
                                <time datetime="{{ $article->created_at->format('Y-m-d') }}">
                                    {{ __('pages/article.write') }}
                                    <span>{{ $article->created_at->diffForHumans() }}</span>
                                </time>
                            @endif
                        @endif

                        <span class="mx-1">&middot;</span>
                        <span>{{ __('global.read_time', ['time' => $article->readTime()]) }}</span>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <x-untitledui-heart class="size-5" aria-hidden="true" />
                        {{ $article->reactions_count }}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-base text-gray-500 dark:text-gray-400">
                {{ __('pages/article.not_article_created') }}
            </p>
        @endforelse
    </div>

    <div class="mt-10 py-10">
        {{ $this->articles->links() }}
    </div>

    <flux:modal name="confirm-delete-article" class="max-w-md">
        <div>
            <flux:heading size="lg">{{ __('actions.confirm_delete_title') }}</flux:heading>
            <flux:subheading>
                <p class="mt-2">
                    {{ __('actions.confirm_delete_article_message') }}
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
