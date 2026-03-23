<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Livewire\Components\Spotlight;
use App\Models\Discussion;
use App\Spotlight\SpotlightCommand;
use App\Spotlight\SpotlightCommandDependencies;
use App\Spotlight\SpotlightCommandDependency;
use App\Spotlight\SpotlightSearchResult;
use Illuminate\Support\Collection;

final class SearchDiscussions extends SpotlightCommand
{
    protected string $name = 'Rechercher une discussion';

    protected string $description = '';

    protected ?string $icon = 'phosphor-chat-circle-dots-duotone';

    protected ?string $group = 'search';

    protected array $synonyms = ['search discussion', 'chercher discussion'];

    public function dependencies(): SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('discussion')
                    ->setPlaceholder(__('global.search').'...')
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchDiscussion(string $query): Collection
    {
        return Discussion::search($query)
            ->query(fn ($q) => $q->with('user'))
            ->get()
            ->take(10)
            ->map(fn (Discussion $discussion): SpotlightSearchResult => new SpotlightSearchResult(
                id: $discussion->id,
                name: $discussion->title,
                description: $discussion->user?->name,
            ));
    }

    public function execute(Spotlight $spotlight, int|string $discussion): void
    {
        $model = Discussion::query()->findOrFail($discussion);

        $spotlight->redirect(route('discussions.show', $model->slug), navigate: true);
    }

    public function getUrl(): string
    {
        return route('discussions.index');
    }
}
