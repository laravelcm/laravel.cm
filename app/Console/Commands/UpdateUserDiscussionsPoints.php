<?php

namespace App\Console\Commands;

use App\Gamify\Points\DiscussionCreated;
use App\Models\Discussion;
use Illuminate\Console\Command;

class UpdateUserDiscussionsPoints extends Command
{
    protected $signature = 'lcm:update-users-discussions-points';

    protected $description = 'Update users discussions reputation points';

    public function handle()
    {
        $this->info('Updating users discussions reputations...');

        foreach (Discussion::all() as $discussion) {
            givePoint(new DiscussionCreated($discussion), $discussion->author);
        }

        $this->info('All done!');
    }
}
