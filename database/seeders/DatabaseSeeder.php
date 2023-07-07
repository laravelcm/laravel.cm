<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TagSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AddEnterpriseRoleSeeder::class);
        $this->call(ReactionSeeder::class);
        $this->call(ChannelSeeder::class);
        $this->call(DeveloperPremiumPlanSeeder::class);
        $this->call(WorldSeeder::class);
        $this->call(FeatureTableSeeder::class);

        if ( ! App::environment('production')) {
            $this->call(UserSeeder::class);
        }
    }
}
