<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Gamify\Points\PostCreated;
use App\Models\Article;
use Illuminate\Console\Command;

final class UpdateUserPostsPoints extends Command
{
    protected $signature = 'lcd:update-users-posts-points';

    protected $description = 'Update users posts reputation points';

    public function handle(): void
    {
        $this->info('Updating users posts reputations...');

        foreach (Article::published()->get() as $article) {
            // @phpstan-ignore-next-line
            givePoint(new PostCreated($article), $article->author);
        }

        $this->info('All done!');
    }
}
