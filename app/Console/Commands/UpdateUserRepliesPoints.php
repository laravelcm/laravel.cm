<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Gamify\Points\ReplyCreated;
use App\Models\Reply;
use Illuminate\Console\Command;

final class UpdateUserRepliesPoints extends Command
{
    protected $signature = 'lcd:update-users-replies-points';

    protected $description = 'Updating users replies reputation points';

    public function handle(): void
    {
        $this->info('Updating users bests replies reputations...');

        foreach (Reply::all() as $reply) {
            givePoint(new ReplyCreated($reply->replyAble));
        }

        $this->info('All done!');
    }
}
