<?php

declare(strict_types=1);

use App\Actions\Article\ArticleDeleteAction;
use App\Actions\Discussion\DeleteDiscussionAction;
use App\Models\Article;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

new class extends Component {

    use WithPagination, WithoutUrlPagination;

    #[Computed]
    public function articles(): LengthAwarePaginator
    {
        return Article::query()
            ->where('user_id', Auth::id())
            ->with(['user', 'tags', 'reactions'])
            ->latest()
            ->paginate(3);
    }

    public function deleteArticle(Article $article): void
    {
        app(ArticleDeleteAction::class)->handle($article);

        Notification::make()
            ->title('Article supprimé avec succès')
            ->success()
            ->send();
    }

};
?>

<div xmlns:x-filament-action="http://www.w3.org/1999/html">
    <main class="lg:col-span-9">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <h2 class="font-heading text-lg font-bold leading-7 text-gray-900 sm:truncate sm:text-xl">
                    {{ __('pages/article.your_article') }}
                </h2>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <x-buttons.primary class="justify-items-center" type="button"
                                   onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.article-form' })">
                    <x-untitledui-message-text-square class="size-5 mr-2" aria-hidden="true" />
                    {{ __('Rédiger un article') }}
                </x-buttons.primary>
            </div>
        </div>

        <div class="mt-5 space-y-4">

            @forelse ($this->articles as $article)
                <div
                    class="rounded-xl mb-8 p-6 cursor-pointer bg-white transition duration-200 ease-in-out dark:bg-gray-800 dark:ring-gray-800 dark:hover:bg-white/10 lg:py-5 lg:px-6">
                    <div class="flex justify-between space-x-3">
                        <div class="flex-1">
                            @if ($article->isNotPublished())
                                <span
                                    class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                            {{ __('pages/article.draft') }}
                            </span>
                            @endif

                            @foreach ($article->tags as $tag)
                                <x-tag :tag="$tag" />
                            @endforeach
                        </div>
                        <div>
                            @if ($article->isNotPublished())
                                <button type="button"
                                        class="inline-flex rounded bg-warning-500 px-2.5 py-0.5 text-xs font-medium text-yellow-800"
                                        onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.article-form', arguments: { articleId: {{ $article->id }} }})">
                                    {{ __('actions.edit') }}
                                </button>
                            @endif

                        {{--          Mettre le bouton delete ici                  --}}

                        </div>
                    </div>

                    <a href="{{ route('articles.show', $article->slug) }}" class="block">
                        <div class="mt-4 flex items-center justify-between">
                            <h3 class="font-heading/7 text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $article->title }}
                            </h3>

                            <div class="flex items-center font-sans text-gray-400 dark:text-gray-500">
                                @if ($article->isPublished())
                                    <a href="{{ route('articles.show', $article->slug) }}"
                                       class="hover:text-gray-500 dark:text-gray-400 hover:underline">
                                        Voir
                                    </a>
                                    <span class="mx-1">&middot;</span>
                                @endif
                            </div>
                        </div>

                        <p class="mt-3 text-base font-normal leading-6 text-gray-500 dark:text-white">
                            {{ $article->excerpt() }}
                        </p>
                    </a>

                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <a href="{{ route('profile', $article->user->username) }}" class="shrink-0">
                                <img class="size-10 rounded-full object-cover"
                                     src="{{ $article->user->profile_photo_url }}"
                                     alt="{{ $article->user->username }}" />
                            </a>

                            <div class="ml-3 font-sans">
                                <p class="text-sm font-medium leading-5 text-gray-700 dark:text-white">
                                    <a href="{{ route('profile', $article->user->username) }}" class="hover:underline">
                                        {{ $article->user->name }}
                                    </a>
                                </p>

                                <div class="flex text-sm leading-5 text-gray-500 dark:text-gray-400">
                                    @if ($article->isPublished())
                                        <time datetime="{{ $article->submitted_at->format('Y-m-d') }}">
                                            {{ __('Publié le :date', ['date' => $article->submitted_at->format('j M, Y')]) }}
                                        </time>
                                    @else
                                        @if ($article->isAwaitingApproval())
                                            <span>En attente d'approbation</span>
                                        @else
                                            <time datetime="{{ $article->updated_at->format('Y-m-d') }}">
                                                Rédigé
                                                <time-ago time="{{ $article->updated_at->getTimestamp() }}" />
                                            </time>
                                        @endif
                                    @endif

                                    <span class="mx-1">&middot;</span>
                                    <span>{{ $article->readTime() }} min de lecture</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                            <span class="mr-2 text-xl">👏</span>
                            {{ count($article->reactions) }}
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-base text-gray-500 dark:text-gray-400">Vous n'avez pas encore créé d'articles.</p>
            @endforelse

        </div>
    </main>
</div>
