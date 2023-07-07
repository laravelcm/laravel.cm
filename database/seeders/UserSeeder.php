<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    public function run(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Arthur Doe',
            'email' => 'user@laravel.cm',
            'username' => 'johndoe',
            'github_profile' => 'johndoe',
            'twitter_profile' => 'johndoe',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('admin');
    }
}
