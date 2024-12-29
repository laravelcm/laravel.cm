<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

final class CreateAdminUser extends Command
{
    protected $signature = 'lcd:admin';

    protected $description = 'Create user with admin role and all permissions.';

    public function handle(): void
    {
        $this->info('Create Admin User.');
        $this->createUser();
        $this->info('User created successfully.');
    }

    protected function createUser(): void
    {
        $email = $this->ask('Email Address', 'admin@laravel.cd');
        $name = $this->ask('Name', 'Laravel DRC');
        $username = $this->ask('Username', 'admin');
        $password = $this->secret('Password');
        $confirmPassword = $this->secret('Confirm Password');

        // Passwords don't match
        if ($password !== $confirmPassword) {
            $this->info('Passwords don\'t match');
        }

        $this->info('Creating admin account...');

        $userData = [
            'email' => $email,
            'name' => $name,
            'username' => $username,
            'password' => Hash::make($password),
            'email_verified_at' => now()->toDateTimeString(),
        ];

        try {
            /** @var User $user */
            $user = User::query()->create($userData);

            $user->assignRole('admin');
        } catch (Exception|QueryException $e) {
            $this->error($e->getMessage());
        }
    }
}
