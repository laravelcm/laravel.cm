<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


if (app()->environment('production')) {
    Schedule::command('lcm:post-article-to-twitter')->everyFourHours();
    Schedule::command('lcm:post-article-to-telegram')->everyFourHours();
    Schedule::command('lcm:send-unverified-mails')->weeklyOn(1, '8:00');
    Schedule::command('lcm:notify-pending-articles')->cron('8 0 */2 * *');
}


Schedule::command('lcm:delete-old-unverified-users')->daily();
Schedule::command('sitemap:blog-generate')->dailyAt('01:00');
Schedule::command('sitemap:discussion-generate')->dailyAt('01:10');
Schedule::command('sitemap:generate')->dailyAt('02:00');
