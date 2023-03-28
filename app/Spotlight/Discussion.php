<?php

declare(strict_types=1);

namespace App\Spotlight;

use App\Models\Discussion as DiscussionModel;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

class Discussion extends SpotlightCommand
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

    public function searchDiscussion($query)
    {
        return DiscussionModel::where('title', 'like', "%$query%")
            ->get()
            ->map(function (DiscussionModel $discussion) {
                return new SpotlightSearchResult(
                    $discussion->slug(),
                    $discussion->title,
                    sprintf('par @%s', $discussion->author->username)
                );
            });
    }

    public function execute(Spotlight $spotlight, DiscussionModel $discussion)
    {
        $spotlight->redirectRoute('discussions.show', $discussion);
    }
}
