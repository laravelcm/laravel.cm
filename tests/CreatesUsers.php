<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Article;
use App\Models\User;

trait CreatesUsers
{
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

    public function createUser(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ], $attributes));
    }

    public function createPost(array $attributes = []): Article
    {
        return Article::factory()->create(array_merge([
            'title' => 'Dummy post title',
            'body' => 'I am the content on dummy post',
            'user_id' => 1,
        ], $attributes));
    }
}
