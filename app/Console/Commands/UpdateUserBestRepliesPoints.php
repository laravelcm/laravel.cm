<?php

namespace App\Console\Commands;

use App\Gamify\Points\BestReply;
use App\Models\Thread;
use Illuminate\Console\Command;

class UpdateUserBestRepliesPoints extends Command
{
    protected $signature = 'lcm:update-users-bests-replies-points';

    protected $description = 'Updating users bests replies reputation points';

    public function handle()
    {
        $this->info('Updating users bests replies reputations...');

        $resolvedThread = Thread::with('solutionReply')->resolved()->get();

        foreach ($resolvedThread as $thread) {
            givePoint(new BestReply($thread->solutionReply));
        }

        $this->info('All done!');
    }
}
