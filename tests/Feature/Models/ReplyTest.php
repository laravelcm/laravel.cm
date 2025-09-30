<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;

describe(Reply::class, function (): void {
    it('records activity when a reply is send', function (): void {
        $user = $this->login();

        $thread = Thread::factory()->create();
        $reply = Reply::factory()->create(['user_id' => $user->id]);
        $reply->to($thread);
        $reply->save();

        /** @var Activity $activity */
        $activity = Activity::query()->latest()->first();

        expect($activity->subject->id)
            ->toBe($reply->id)
            ->and(
                $user->activities()
                    ->where('type', 'created_reply')
                    ->get()
                    ->count()
            )->toBe(1);

        $this->assertEquals(
            $user->activities()
                ->where('type', 'created_reply')
                ->get()
                ->count(),
            1
        );
    })->skip();
});
