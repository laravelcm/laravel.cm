<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Livewire\Volt\Volt;

/**
 * @var \Tests\TestCase $this
 */
describe('Registration', function (): void {
    test('registration screen can be rendered', function (): void {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.register');
    })->skip();

    test('new users can register', function (): void {
        $component = Volt::test('pages.auth.register')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password');

        $component->call('register');

        $this->assertGuest();
    });
});
