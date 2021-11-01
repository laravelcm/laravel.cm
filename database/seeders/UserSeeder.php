<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
