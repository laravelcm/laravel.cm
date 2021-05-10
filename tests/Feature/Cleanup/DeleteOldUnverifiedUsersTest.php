<?php

namespace Tests\Feature\Cleanup;

use App\Console\Commands\Cleanup\DeleteOldUnverifiedUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class DeleteOldUnverifiedUsersTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        TestTime::freeze('Y-m-d H:i:s', '2021-05-01 00:00:01');
    }

    /** @test */
    public function it_will_delete_unverified_users_after_some_days()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        TestTime::addDays(10);

        $this->artisan(DeleteOldUnverifiedUsers::class);
        $this->assertTrue($user->exists());

        TestTime::addSecond();

        $this->artisan(DeleteOldUnverifiedUsers::class);
        $this->assertFalse($user->exists());
    }

    /** @test */
    public function it_will_not_delete_verified_users()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        TestTime::addDays(20);

        $this->artisan(DeleteOldUnverifiedUsers::class);
        $this->assertTrue($user->exists());
    }
}
