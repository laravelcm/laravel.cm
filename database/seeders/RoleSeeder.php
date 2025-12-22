<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

final class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => UserRole::Admin->value]);
        Role::create(['name' => UserRole::Moderator->value]);
        Role::create(['name' => UserRole::User->value]);
        Role::create(['name' => UserRole::Company->value]);
    }
}
