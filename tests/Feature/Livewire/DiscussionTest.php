<?php

declare(strict_types=1);

use App\Livewire\Discussions\Create;
use App\Models\Discussion;
use App\Notifications\PostDiscussionToTelegram;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
});

describe(Create::class, function (): void {
    it('should save a discussion and send Telegram notification', function (): void {
        Notification::fake();

        Livewire::test(Create::class)
            ->set('title', 'My Discussion')
            ->set('body', '## My Discussion content')
            ->call('store');

        expect(Discussion::query()->count())
            ->toBe(1);

        Notification::assertSentTo(
            notifiable: $this->user,
            notification: PostDiscussionToTelegram::class
        );

        Notification::assertCount(1);
    });
});
