<?php

declare(strict_types=1);

use App\Livewire\Pages\Auth\Login;
use App\Models\User;
use Livewire\Livewire;

/**
 * @var Tests\TestCase $this
 */
describe('Authentication', function (): void {
    test('login screen can be rendered', function (): void {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSeeLivewire(Login::class);
    });

    test('users can authenticate using the login screen', function (): void {
        $user = User::factory()->create();

        $component = Livewire::test(Login::class)
            ->set('form.email', $user->email)
            ->set('form.password', 'password');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    });

    test('users can not authenticate with invalid password', function (): void {
        $user = User::factory()->create();

        $component = Livewire::test(Login::class)
            ->set('form.email', $user->email)
            ->set('form.password', 'wrong-password');

        $component->call('login');

        $component
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();
    });

    test('users can logout', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Livewire::test('components.logout');

        $component->call('logout');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
    });
});
