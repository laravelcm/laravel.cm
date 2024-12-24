<?php

declare(strict_types=1);

use Livewire\Volt\Volt;

beforeEach(function (): void {
    $this->user = $this->login();
});

it('renders successfully', function (): void {
    Volt::test('components.notification-count')
        ->assertStatus(200);
});

it('can display user count notification', function (): void {
    Volt::test('components.notification-count')
        ->assertSee($this->user->unreadNotifications()->count());
});
