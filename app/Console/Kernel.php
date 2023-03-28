<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Cleanup\DeleteOldUnverifiedUsers::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('media-library:delete-old-temporary-uploads')->daily();
        $schedule->command('lcm:delete-old-unverified-users')->daily();

        if (app()->environment('production')) {
            $schedule->command('lcm:post-article-to-twitter')->everyFourHours();
            $schedule->command('lcm:post-article-to-telegram')->everyFourHours();
            $schedule->command('lcm:send-unverified-mails')->weeklyOn(1, '8:00');
            $schedule->command('sitemap:generate')->daily();
        }
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
