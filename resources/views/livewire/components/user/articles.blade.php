<div x-data>
    @can('create', App\Models\Discussion::class)
        <div class="flex items-center justify-end">
            <x-buttons.primary
                type="button"
                wire:click="$dispatch('openPanel', { component: 'components.slideovers.article-form' })"
            >
                {{ __('global.launch_modal.article_action') }}
            </x-buttons.primary>
        </div>
    @endcan

    <div class="mt-5 space-y-4">
        @forelse ($this->articles as $article)
            <div wire:key="{{ $article->id }}" class="rounded-xl p-5 bg-white transition duration-200 ease-in-out ring-1 ring-gray-200/50 dark:bg-gray-800 dark:ring-white/10 dark:hover:bg-white/10">
                <div class="flex justify-between gap-3">
                    <div class="flex items-center gap-2 flex-1">
                        @if ($article->isNotPublished())
                            <x-filament::badge size="lg" color="warning">
                                {{ __('pages/article.draft') }}
                            </x-filament::badge>
                        @endif

                        @foreach ($article->tags as $tag)
                            <x-tag :tag="$tag" />
                        @endforeach
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($article->isNotPublished() && Auth::user()->can('update', $article))
                            {{ $this->editAction()(['id' => $article->id]) }}
                        @endif

                        @can('delete', $article)
                            {{ $this->deleteAction()(['id' => $article->id]) }}
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
                                <span>En attente d'approbation</span>
                            @else
                                <time datetime="{{ $article->created_at->format('Y-m-d') }}">
                                    Rédigé
                                    <span>{{ $article->created_at->diffForHumans() }}</span>
                                </time>
                            @endif
                        @endif

                        <span class="mx-1">&middot;</span>
                        <span>{{ $article->readTime() }} min de lecture</span>
                    </div>

                    <div class="flex items-center text-gray-500 dark:text-gray-400">
                        <span class="text-xl">👏</span>
                        {{ count($article->reactions) }}
                    </div>
                </div>
            </div>
        @empty
            <p class="text-base text-gray-500 dark:text-gray-400">
                {{ __('pages/article.not_article_created') }}
            </p>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $this->articles->links() }}
    </div>

    <template x-teleport="#main-site">
        <x-filament-actions::modals />
    </template>
</div>
