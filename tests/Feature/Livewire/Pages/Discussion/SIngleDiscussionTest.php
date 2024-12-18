<?php

declare(strict_types=1);

use App\Gamify\Points\DiscussionCreated;
use App\Livewire\Pages\Discussions\SingleDiscussion;
use App\Models\Discussion;
use App\Models\Tag;
use Livewire\Livewire;

it('delete user action can remove discussion point ', function (): void {
    $user = $this->login();
    $discussion = Discussion::factory()->create(['user_id' => $user->id]);
    $tags = Tag::factory()->count(3)->create();

    $discussion->tags()->attach($tags->modelKeys());

    givePoint(new DiscussionCreated($discussion));

    Livewire::test(SingleDiscussion::class, ['discussion' => $discussion])
        ->callAction('deleteAction')
        ->assertStatus(200);

    $user->refresh();

    expect($user->getPoints())
        ->toBe(0);

});
