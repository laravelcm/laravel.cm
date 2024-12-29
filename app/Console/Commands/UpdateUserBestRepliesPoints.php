<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Gamify\Points\BestReply;
use App\Models\Thread;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

final class UpdateUserBestRepliesPoints extends Command
{
    protected $signature = 'lcd:update-users-bests-replies-points';

    protected $description = 'Updating users bests replies reputation points';

    public function handle(): void
    {
        $this->info('Updating users bests replies reputations...');

        /** @var Collection | Thread[] $resolvedThread */
        $resolvedThread = Thread::with('solutionReply')->scopes('resolved')->get();

        foreach ($resolvedThread as $thread) {
            givePoint(new BestReply($thread->solutionReply)); // @phpstan-ignore-line
        }

        $this->info('All done!');
    }
}
