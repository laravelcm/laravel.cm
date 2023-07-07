<?php

declare(strict_types=1);

namespace App\Spotlight;

use App\Models\Discussion as DiscussionModel;
use Illuminate\Support\Collection;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

final class Discussion extends SpotlightCommand
{
    protected string $name = 'Discussion';

    protected string $description = 'rechercher une discussion spécifique';

    protected array $synonyms = [];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('discussion')
                    ->setPlaceholder('Rechercher une discussion spécifique')
            );
    }

    public function searchDiscussion(string $query): Collection
    {
        return DiscussionModel::with('user')
            ->where('title', 'like', "%{$query}%")
            ->get()
            ->map(fn (DiscussionModel $discussion) => new SpotlightSearchResult(
                $discussion->slug(),
                $discussion->title,
                sprintf('par @%s', $discussion->user?->username)
            ));
    }

    public function execute(Spotlight $spotlight, DiscussionModel $discussion): void
    {
        $spotlight->redirectRoute('discussions.show', $discussion);
    }
}
