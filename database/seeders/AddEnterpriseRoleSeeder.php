<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

final class AddEnterpriseRoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'company']);
    }
}
