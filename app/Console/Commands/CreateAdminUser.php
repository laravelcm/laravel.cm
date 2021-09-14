<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lcm:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user with admin role and all permissions.';

    public function handle()
    {
        $this->info('Create Admin User.');
        $this->createUser();
        $this->info('User created successfully.');
    }

    protected function createUser(): void
    {
        $email = $this->ask('Email Address', 'admin@laravel.cm');
        $name = $this->ask('Name', 'Laravel Cameroun');
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
        $model = config('auth.providers.users.model');

        try {
            $user = tap((new $model)->forceFill($userData))->save();

            $user->assignRole('admin');
        } catch (\Exception | QueryException $e) {
            $this->error($e->getMessage());
        }
    }
}
