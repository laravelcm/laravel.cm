<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;

it('records activity when a reply is send', function (): void {
    $user = $this->login();

    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['user_id' => $user->id]);
    $reply->to($thread);
    $reply->save();

    $activity = Activity::query()->first();

    $this->assertEquals($activity->subject->id, $reply->id);

    $this->assertEquals(
        $user->activities()
            ->where('type', 'created_reply')
            ->get()
            ->count(),
        1
    );
});
