<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Psr\Http\Message\UriInterface;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

final class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Crawl the site to generate a sitemap.xml file';

    /**
     * @var array|string[]
     */
    private array $noIndexPaths = [
        '/forum/channels',
        '/forum/channels/*',
        '/user',
        '/user/*',
        '/dashboard/*',
        '/rules',
        '/terms',
        '/privacy',
        '/faq',
        '/auth/github',
    ];

    public function handle(): void
    {
        SitemapGenerator::create(config('app.url'))
            ->shouldCrawl(fn (UriInterface $url) => $this->shouldIndex($url->getPath()))
            ->hasCrawled(function (Url $url) {
                if ($this->shouldNotIndex($url->path())) {
                    return;
                }

                return $url;
            })
            ->writeToFile(public_path('sitemap.xml'));
    }

    private function shouldNotIndex(string $path): bool
    {
        return Str::is($this->noIndexPaths, $path);
    }

    private function shouldIndex(string $path): bool
    {
        return ! $this->shouldNotIndex($path);
    }
}
