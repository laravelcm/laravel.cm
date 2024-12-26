<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

final class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the sitemap';

    public function handle(): void
    {
        Sitemap::create()
            ->add(
                Url::create(route('home'))
                    ->setLastModificationDate(now()->subMinutes(10))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.5)
            )
            ->add(
                Url::create(route('sponsors'))
                    ->setLastModificationDate(now()->subMinutes(10))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.5)
            )
            ->add(
                Url::create(route('about'))
                    ->setLastModificationDate(now()->subMinutes(10))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.5)
            )
            ->writeToFile(public_path('sitemaps/base_sitemap.xml'));

        $sitemap = SitemapIndex::create()
            ->add('/sitemaps/base_sitemap.xml')
            ->add('/sitemaps/discussion_sitemap.xml')
            ->add('/sitemaps/blog_sitemap.xml');

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
