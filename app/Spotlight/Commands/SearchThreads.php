<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Livewire\Components\Spotlight;
use App\Models\Thread;
use App\Spotlight\SpotlightCommand;
use App\Spotlight\SpotlightCommandDependencies;
use App\Spotlight\SpotlightCommandDependency;
use App\Spotlight\SpotlightSearchResult;
use Illuminate\Support\Collection;

final class SearchThreads extends SpotlightCommand
{
    protected ?string $icon = 'phosphor-chats';

    protected ?string $group = null;

    protected array $synonyms = ['thread', 'question', 'sujet', 'forum', 'search'];

    public function getName(): string
    {
        return __('global.navigation.questions');
    }

    public function dependencies(): SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('thread')
                    ->setPlaceholder(__('command-palette.placeholder'))
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchThread(string $query): Collection
    {
        return Thread::search($query)
            ->take(10)
            ->query(fn ($q) => $q->with('user'))
            ->get()
            ->map(fn (Thread $thread): SpotlightSearchResult => new SpotlightSearchResult(
                id: $thread->id,
                name: $thread->title,
                description: $thread->user->name,
            ));
    }

    public function execute(Spotlight $spotlight, int|string $thread): void
    {
        $model = Thread::query()->find($thread);

        if (! $model instanceof Thread) {
            return;
        }

        $spotlight->redirect(route('forum.show', $model->slug), navigate: true);
    }
}
