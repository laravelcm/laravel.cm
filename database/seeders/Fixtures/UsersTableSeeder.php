<?php

declare(strict_types=1);

namespace Database\Seeders\Fixtures;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class UsersTableSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = User::factory()->count(20)->create();

        foreach ($users as $user) {
            $user->assignRole('user');
        }
    }
}
