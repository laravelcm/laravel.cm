<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(TagSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ReactionSeeder::class);
        $this->call(ChannelSeeder::class);

        if (! App::environment('production')) {
            $this->call(UserSeeder::class);
        }
    }
}
