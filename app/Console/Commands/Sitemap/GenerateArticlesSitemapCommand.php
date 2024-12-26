<?php

declare(strict_types=1);

namespace App\Console\Commands\Sitemap;

use App\Models\Article;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;

final class GenerateArticlesSitemapCommand extends Command
{
    protected $signature = 'sitemap:blog-generate';

    protected $description = 'Generate the articles sitemaps.';

    public function handle(): void
    {
        $sitemap = Sitemap::create();

        Article::query()->whereNotNull('approved_at')->each(function ($article) use ($sitemap): void {
            $sitemap->add($article); // @phpstan-ignore-line
        });

        $sitemap->writeToFile(public_path('sitemaps/blog_sitemap.xml'));
    }
}
