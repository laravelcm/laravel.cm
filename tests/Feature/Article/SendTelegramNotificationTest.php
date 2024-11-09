<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Notification;

beforeEach(function (): void {
    $this->user = $this->login();
});

test('Send notification on telegram after submission on article', function (): void {
    Notification::fake();

    // @ToDo: Rewrite this test
});
