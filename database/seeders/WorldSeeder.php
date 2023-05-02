<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nnjeim\World\Actions\SeedAction;

class WorldSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SeedAction::class,
        ]);
    }
}
