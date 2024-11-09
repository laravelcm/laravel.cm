<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User;

trait CreatesUsers
{
    protected function login(array $attributes = []): User
    {
        $user = $this->createUser($attributes);

        $this->be($user);

        return $user;
    }

    protected function loginAs(User $user): void
    {
        $this->be($user);
    }

    protected function createUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }
}
