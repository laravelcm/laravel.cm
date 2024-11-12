<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Volt\Volt;

// @ToDo: Update this file to match the actual user update password view

/**
 * @var \Tests\TestCase $this
 */
describe('Auth/PasswordUpdate', function (): void {
    test('password can be updated', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.update-password-form')
            ->set('current_password', 'password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('updatePassword');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    });

    test('correct password must be provided to update password', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.update-password-form')
            ->set('current_password', 'wrong-password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('updatePassword');

        $component
            ->assertHasErrors(['current_password'])
            ->assertNoRedirect();
    });
})->skip();
