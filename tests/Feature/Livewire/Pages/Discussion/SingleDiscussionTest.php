<?php

declare(strict_types=1);

use App\Actions\Discussion\CreateDiscussionAction;
use App\Data\CreateDiscussionData;
use App\Livewire\Pages\Discussions\SingleDiscussion;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function (): void {
    Notification::fake();
});

it('delete user action can remove discussion point ', function (): void {
    $user = $this->login();
    $discussionData = CreateDiscussionData::from([
        'title' => 'Discussion title',
        'body' => 'Discussion body',
        'tags' => [],
    ]);

    $discussion = app(CreateDiscussionAction::class)->execute($discussionData);

    Livewire::test(SingleDiscussion::class, ['discussion' => $discussion])
        ->callAction('deleteAction')
        ->assertStatus(200);

    $user->refresh();

    expect($user->getPoints())
        ->toBe(0);
});
