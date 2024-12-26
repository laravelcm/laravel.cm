<?php

declare(strict_types=1);

use App\Actions\Forum\CreateReplyAction;
use App\Actions\ReportSpamAction;
use App\Exceptions\CanReportSpamException;
use App\Models\Reply;
use App\Models\SpamReport;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

/**
 * @var \Tests\TestCase $this
 */
beforeEach(function (): void {
    $this->user = $this->login();

    Event::fake();
    Notification::fake();
});

describe(ReportSpamAction::class, function (): void {
    it('can save report in database', function (): void {
        $user = User::factory()->create();
        $thread = Thread::factory()->create();

        app(CreateReplyAction::class)->execute(
            body: fake()->sentence(),
            model: $thread,
        );

        app(ReportSpamAction::class)->execute(
            user: $user,
            model: Reply::query()->first(),
            content: fake()->sentence(),
        );

        $report = SpamReport::query()->first();

        expect(SpamReport::query()->count())
            ->toEqual(1)
            ->and($report)
            ->not()
            ->toBeNull()
            ->and($report->reportable_type)
            ->toBe('reply');
    });

    it('can report twice the same resource', function (): void {
        $user = User::factory()->create();
        $reply = Reply::factory(['user_id' => $this->user->id])->create();

        SpamReport::query()->create([
            'reason' => null,
            'user_id' => $user->id,
            'reportable_type' => 'reply',
            'reportable_id' => $reply->id,
        ]);

        app(ReportSpamAction::class)->execute(
            user: $user,
            model: $reply,
        );
    })->throws(CanReportSpamException::class);
});
