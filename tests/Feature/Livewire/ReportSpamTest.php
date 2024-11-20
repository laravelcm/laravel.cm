<?php

declare(strict_types=1);

use App\Livewire\ReportSpam;
use App\Models\SpamReport;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\ReportedSpamToTelegram;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

beforeEach(function (): void {
    Role::create(['name' => 'admin']);

    Notification::fake();
});

describe(ReportSpam::class, function (): void {
    it('guest user cannot report spam', function (): void {
        $thread = Thread::factory()->create();

        Livewire::test(ReportSpam::class, ['model' => $thread])
            ->assertActionHidden('report');
    });

    it('user can report a thread as spam', function (): void {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->login();
        $thread = Thread::factory()->create();

        Livewire::test(ReportSpam::class, ['model' => $thread])
            ->callAction('report');

        expect(SpamReport::query()->count())
            ->toBe(1)
            ->and(SpamReport::query()->first()->reportable_type)
            ->toBe('thread');

        Notification::assertNotSentTo(
            [$user],
            ReportedSpamToTelegram::class
        );

        Notification::assertCount(1);
    });

    it('user cannot report twice as spam', function (): void {
        $thread = Thread::factory()->create();
        $user = $this->login();

        SpamReport::query()->create([
            'reason' => null,
            'user_id' => $user->id,
            'reportable_type' => 'thread',
            'reportable_id' => $thread->id,
        ]);

        expect($thread->spamReports()->count())
            ->toBe(1)
            ->and($thread->spamReports()->whereBelongsTo($user)->exists())
            ->toBeTrue();

        Livewire::test(ReportSpam::class, ['model' => $thread])
            ->callAction('report');

        expect($thread->spamReports()->count())
            ->toBe(1);
    });

    it('user cannot report a spam with unverified e-mail', function (): void {
        $this->login(['email_verified_at' => null]);

        $thread = Thread::factory()->create();

        Livewire::test(ReportSpam::class, ['model' => $thread])
            ->assertActionHidden('report');
    });
});
