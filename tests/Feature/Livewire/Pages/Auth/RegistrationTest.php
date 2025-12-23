<?php

declare(strict_types=1);

use App\Livewire\Pages\Auth\Register;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

/**
 * @var Tests\TestCase $this
 */
describe('Registration', function (): void {
    test('registration screen can be rendered', function (): void {
        $response = $this->get('/register');

        $response
            ->assertOk()
            ->assertSeeLivewire(Register::class);
    });

    test('new users can register', function (): void {
        Mail::fake();

        $email = fake()->unique()->safeEmail();
        $username = fake()->unique()->userName();
        $name = fake()->name();
        $password = 'StrongP@ssw0rd123!';

        $component = Livewire::test(Register::class)
            ->set('form.name', $name)
            ->set('form.email', $email)
            ->set('form.username', $username)
            ->set('form.password', $password);

        $component->call('register');

        $component->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'username' => $username,
            'name' => $name,
        ]);

        $this->assertGuest();
    });
});
