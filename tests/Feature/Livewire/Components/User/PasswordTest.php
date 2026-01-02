<?php

declare(strict_types=1);

use App\Livewire\Pages\Account\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->user = $this->login();
});

describe(Password::class, function (): void {
    it('renders successfully', function (): void {
        Livewire::test(Password::class)
            ->assertStatus(200);
    });

    it('user can change password', function (): void {
        $newPassword = 'NewSecureP@ssw0rd123!';

        Livewire::test(Password::class)
            ->set('current_password', 'password')
            ->set('password', $newPassword)
            ->set('password_confirmation', $newPassword)
            ->call('changePassword')
            ->assertHasNoErrors();

        $this->user->refresh();

        expect(Hash::check($newPassword, $this->user->password))->toBeTrue();
    });

    it('requires current password when user has password', function (): void {
        Livewire::test(Password::class)
            ->set('password', 'NewSecureP@ssw0rd123!')
            ->set('password_confirmation', 'NewSecureP@ssw0rd123!')
            ->call('changePassword')
            ->assertHasErrors(['current_password' => 'required']);
    });

    it('requires password confirmation', function (): void {
        Livewire::test(Password::class)
            ->set('current_password', 'password')
            ->set('password', 'NewSecureP@ssw0rd123!')
            ->set('password_confirmation', 'DifferentPassword123!')
            ->call('changePassword')
            ->assertHasErrors(['password' => 'confirmed']);
    });

    it('validates password strength requirements', function (): void {
        Livewire::test(Password::class)
            ->set('current_password', 'password')
            ->set('password', 'weak')
            ->set('password_confirmation', 'weak')
            ->call('changePassword')
            ->assertHasErrors('password');
    });

    it('resets form fields after successful password change', function (): void {
        $newPassword = 'NewSecureP@ssw0rd123!';

        $component = Livewire::test(Password::class)
            ->set('current_password', 'password')
            ->set('password', $newPassword)
            ->set('password_confirmation', $newPassword)
            ->call('changePassword');

        expect($component->get('current_password'))->toBe('')
            ->and($component->get('password'))->toBe('')
            ->and($component->get('password_confirmation'))->toBe('');
    });

    it('does not require current password for users without password', function (): void {
        $userWithoutPassword = User::factory()->create(['password' => null]);
        $this->actingAs($userWithoutPassword);

        $newPassword = 'NewSecureP@ssw0rd123!';

        Livewire::test(Password::class)
            ->set('password', $newPassword)
            ->set('password_confirmation', $newPassword)
            ->call('changePassword')
            ->assertHasNoErrors();

        $userWithoutPassword->refresh();

        expect(Hash::check($newPassword, $userWithoutPassword->password))->toBeTrue();
    });
});
