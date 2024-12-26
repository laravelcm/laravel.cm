<?php

declare(strict_types=1);

namespace App\Console\Commands\Sitemap;

use App\Models\Discussion;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;

final class GenerateDiscussionsSitemapCommand extends Command
{
    protected $signature = 'sitemap:discussion-generate';

    protected $description = 'Generate the discussions sitemaps.';

    public function handle(): void
    {
        $sitemap = Sitemap::create();

        Discussion::query()->whereHas('replies')->each(function ($discussion) use ($sitemap): void {
            $sitemap->add($discussion); // @phpstan-ignore-line
        });

        $sitemap->writeToFile(public_path('sitemaps/discussion_sitemap.xml'));
    }
}
