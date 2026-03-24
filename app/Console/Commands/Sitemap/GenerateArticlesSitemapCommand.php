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

        $appUrl = config('app.url');
        $appHost = is_string($appUrl) ? parse_url($appUrl, PHP_URL_HOST) : null;

        Article::query()
            ->whereNotNull('approved_at')
            ->each(function (Article $article) use ($sitemap, $appHost): void { // @phpstan-ignore argument.type
                if ($article->canonical_url && parse_url($article->canonical_url, PHP_URL_HOST) !== $appHost) {
                    return;
                }

                $sitemap->add($article);
            });

        $sitemap->writeToFile(public_path('sitemaps/blog_sitemap.xml'));
    }
}
