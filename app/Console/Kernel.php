<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\Cleanup\DeleteOldUnverifiedUsers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

final class Kernel extends ConsoleKernel
{
    protected $commands = [
        DeleteOldUnverifiedUsers::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
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
