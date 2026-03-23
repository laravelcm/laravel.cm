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
    protected ?string $icon = 'phosphor-chat-circle-dots';

    protected ?string $group = null;

    protected array $synonyms = ['discussion', 'débat', 'échange', 'search'];

    public function getName(): string
    {
        return __('global.navigation.discussions');
    }

    public function dependencies(): SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('discussion')
                    ->setPlaceholder(__('command-palette.placeholder'))
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchDiscussion(string $query): Collection
    {
        return Discussion::search($query)
            ->take(10)
            ->query(fn ($q) => $q->with('user'))
            ->get()
            ->map(fn (Discussion $discussion): SpotlightSearchResult => new SpotlightSearchResult(
                id: $discussion->id,
                name: $discussion->title,
                description: $discussion->user->name,
            ));
    }

    public function execute(Spotlight $spotlight, int|string $discussion): void
    {
        $model = Discussion::query()->find($discussion);

        if (! $model instanceof Discussion) {
            return;
        }

        $spotlight->redirect(route('discussions.show', $model->slug), navigate: true);
    }
}
