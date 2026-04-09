<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Providers;

use Laravelcm\Sentinel\Console\AutoFixExpiredIssuesCommand;
use Laravelcm\Sentinel\Console\CheckCanonicalUrlsCommand;
use Laravelcm\Sentinel\Console\NotifyContentIssuesCommand;
use Laravelcm\Sentinel\Console\ScanContentQualityCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class SentinelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('sentinel')
            ->hasConfigFile()
            ->hasMigration('2026_03_24_130000_create_content_issues_table')
            ->hasTranslations()
            ->hasViews()
            ->hasCommands([
                ScanContentQualityCommand::class,
                NotifyContentIssuesCommand::class,
                AutoFixExpiredIssuesCommand::class,
                CheckCanonicalUrlsCommand::class,
            ]);
    }
}
