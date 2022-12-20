<?php

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;

it('records activity when a reply is send', function () {
    $this->login();

    $thread = Thread::factory()->create();
    $reply = Reply::factory()->create(['user_id' => auth()->id()]);
    $reply->to($thread);
    $reply->save();

    $this->assertDatabaseHas('activities', [
        'type' => 'created_reply',
        'user_id' => auth()->id(),
        'subject_id' => $reply->id,
        'subject_type' => 'reply',
    ]);

    $activity = Activity::first();

    $this->assertEquals($activity->subject->id, $reply->id);

    $this->assertEquals(auth()->user()
        ->activities()
        ->where('type', 'created_reply')
        ->get()
        ->count(), 1);
});
