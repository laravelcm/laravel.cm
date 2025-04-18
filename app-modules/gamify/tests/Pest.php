<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)>in('Feature');

function createUser(array $attributes = []): User
{
    $user = new User();

    $user->forceFill(array_merge($attributes, [
        'name' => 'Demo',
        'email' => 'demo@laravelcm.com',
        'password' => 'password',
    ]))->save();

    return $user->fresh();
}