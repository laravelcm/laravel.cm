<?php

declare(strict_types=1);

namespace App\Spotlight;

use App\Models\Thread;
use Illuminate\Support\Collection;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

final class Sujet extends SpotlightCommand
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

    public function searchThread(string $query): Collection
    {
        return Thread::with('user')
            ->where('title', 'like', "%{$query}%")
            ->get()
            ->map(fn (Thread $thread) => new SpotlightSearchResult(
                $thread->slug(),
                $thread->title,
                sprintf('par @%s', $thread->user?->username)
            ));
    }

    public function execute(Spotlight $spotlight, Thread $thread): void
    {
        $spotlight->redirectRoute('forum.show', $thread);
    }
}
