<?php

declare(strict_types=1);

namespace App\Console\Commands\Sitemap;

use App\Models\Article;
use Illuminate\Console\Command;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

final class GenerateArticlesSitemapCommand extends Command
{
    protected $signature = 'sitemap:blog-generate';

    protected $description = 'Generate the articles sitemaps.';

    public function handle(): void
    {
        $sitemap = Sitemap::create();

        Article::query()->whereNotNull('approved_at')->each(function (string|Url|Sitemapable|iterable $article) use ($sitemap): void {
            $sitemap->add($article);
        });

        $sitemap->writeToFile(public_path('sitemaps/blog_sitemap.xml'));
    }
}
