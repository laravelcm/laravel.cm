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
    protected string $name = 'Rechercher dans le forum';

    protected string $description = '';

    protected ?string $icon = 'phosphor-chats-duotone';

    protected ?string $group = 'search';

    protected array $synonyms = ['search thread', 'chercher thread', 'chercher forum'];

    public function dependencies(): SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('thread')
                    ->setPlaceholder(__('global.search').'...')
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchThread(string $query): Collection
    {
        return Thread::search($query)
            ->query(fn ($q) => $q->with('user'))
            ->get()
            ->take(10)
            ->map(fn (Thread $thread): SpotlightSearchResult => new SpotlightSearchResult(
                id: $thread->id,
                name: $thread->title,
                description: $thread->user?->name,
            ));
    }

    public function execute(Spotlight $spotlight, int|string $thread): void
    {
        $model = Thread::query()->findOrFail($thread);

        $spotlight->redirect(route('forum.show', $model->slug), navigate: true);
    }

    public function getUrl(): string
    {
        return route('forum.index');
    }
}
