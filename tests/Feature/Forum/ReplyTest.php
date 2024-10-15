<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;

it('records activity when a reply is send', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['user_id' => $user->id]);
    $reply->to($thread);
    $reply->save();

    Activity::factory()->create([
        'type' => 'created_reply',
        'user_id' => $user->id,
        'subject_id' => $reply->id,
        'subject_type' => 'reply',
    ]);

    $activity = Activity::first();

    $this->assertEquals($activity->subject->id, $reply->id);

    $this->assertEquals(
        $user->activities()
            ->where('type', 'created_reply')
            ->get()
            ->count(),
        1
    );
})->skip();
