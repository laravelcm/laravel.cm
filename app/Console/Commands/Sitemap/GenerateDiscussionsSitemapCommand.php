<?php

declare(strict_types=1);

namespace App\Console\Commands\Sitemap;

use App\Models\Discussion;
use Illuminate\Console\Command;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

#[\Illuminate\Console\Attributes\Description('Generate the discussions sitemaps.')]
#[\Illuminate\Console\Attributes\Signature('sitemap:discussion-generate')]
final class GenerateDiscussionsSitemapCommand extends Command
{
    public function handle(): void
    {
        $sitemap = Sitemap::create();

        Discussion::query()->whereHas('replies')->each(function (string|Url|Sitemapable|iterable $discussion) use ($sitemap): void {
            $sitemap->add($discussion);
        });

        $sitemap->writeToFile(public_path('sitemaps/discussion_sitemap.xml'));
    }
}
