<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('sitemap:blog-generate')->dailyAt('01:00');
Schedule::command('sitemap:discussion-generate')->dailyAt('01:10');
Schedule::command('sitemap:generate')->dailyAt('02:00');
