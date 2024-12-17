<?php

declare(strict_types=1);

use App\Console\Commands\Cleanup\DeleteOldUnverifiedUsers;
use App\Models\User;
use Spatie\TestTime\TestTime;

beforeEach(fn () => TestTime::freeze('Y-m-d H:i:s', '2021-05-01 00:00:01'));

it('will delete unverified users after some days', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => null,
    ]);

    TestTime::addDays(10);

    $this->artisan(DeleteOldUnverifiedUsers::class);
    $this->assertTrue($user->exists());

    TestTime::addSecond();

    $this->artisan(DeleteOldUnverifiedUsers::class);
    $this->assertFalse($user->exists());
});

it('will not delete verified users', function (): void {
    $user = User::factory()->create([
        'email_verified_at' => now(),
    ]);

    TestTime::addDays(20);

    $this->artisan(DeleteOldUnverifiedUsers::class);
    $this->assertTrue($user->exists());
});
