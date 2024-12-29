<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Gamify\Points\DiscussionCreated;
use App\Models\Discussion;
use Illuminate\Console\Command;

final class UpdateUserDiscussionsPoints extends Command
{
    protected $signature = 'lcd:update-users-discussions-points';

    protected $description = 'Update users discussions reputation points';

    public function handle(): void
    {
        $this->info('Updating users discussions reputations...');

        foreach (Discussion::all() as $discussion) {
            // @phpstan-ignore-next-line
            givePoint(new DiscussionCreated($discussion), $discussion->author);
        }

        $this->info('All done!');
    }
}
