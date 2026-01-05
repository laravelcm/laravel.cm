<?php

declare(strict_types=1);

namespace Tests;

use App\Enums\UserRole;
use App\Models\Article;
use App\Models\User;

trait CreatesUsers
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function login(array $attributes = []): User
    {
        $user = $this->createUser($attributes);

        $this->be($user);

        return $user;
    }

    public function loginAs(User $user): void
    {
        $this->be($user);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function createUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function createAdmin(array $attributes = []): User
    {
        $admin = $this->createUser($attributes);

        $admin->assignRole(UserRole::Admin->value);

        return $admin;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function createPost(array $attributes = []): Article
    {
        return Article::factory()->create(array_merge([
            'title' => 'Dummy post title',
            'body' => 'I am the content on dummy post',
            'user_id' => 1,
        ], $attributes));
    }
}
