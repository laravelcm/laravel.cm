<?php

declare(strict_types=1);

use Livewire\Volt\Volt;

beforeEach(function (): void {
    $this->user = $this->login();
});

it('renders successfully', function (): void {
    Volt::test('components.notification-indicator')
        ->assertStatus(200);
});

it('mask indicator if user can have unread notification', function (): void {
    Volt::test('components.notification-indicator')
        ->assertSet('hasNotification', false);
});
