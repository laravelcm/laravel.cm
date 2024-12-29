<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

final class PublishArticles extends Command
{
    protected $signature = 'lcd:publish-articles';

    protected $description = 'Published all articles already submitted and approved';

    public function handle(): void
    {
        $this->info('Published all submitted articles...');

        $articles = Article::submitted()->approved()->whereNull('published_at')->get();

        foreach ($articles as $article) {
            /** @var Article $article */
            $article->published_at = $article->submitted_at;
            $article->save();
        }

        $count = $articles->count();

        $this->comment("Published {$count} articles.");

        $this->info('All done!');
    }
}
