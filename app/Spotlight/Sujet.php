<?php

namespace App\Spotlight;

use App\Models\Thread;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

class Sujet extends SpotlightCommand
{
    protected string $name = 'Sujet';

    protected string $description = 'Rechercher un sujet dans le forum';

    protected array $synonyms = [
        'topic',
        'sujet',
        'forum',
        'thread',
    ];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('thread')
                    ->setPlaceholder('Rechercher un sujet dans le forum')
            );
    }

    public function searchThread($query)
    {
        return Thread::where('title', 'like', "%$query%")
            ->get()
            ->map(function (Thread $thread) {
                // You must map your search result into SpotlightSearchResult objects
                return new SpotlightSearchResult(
                    $thread->slug(),
                    $thread->name,
                    sprintf('par @%s', $thread->author->username)
                );
            });
    }

    public function execute(Spotlight $spotlight, Thread $thread)
    {
        $spotlight->redirectRoute('forum.show', $thread);
    }
}
