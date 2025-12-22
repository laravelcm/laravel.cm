<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TagSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(ReactionSeeder::class);
        $this->call(ChannelSeeder::class);
        $this->call(DeveloperPremiumPlanSeeder::class);
    }
}
