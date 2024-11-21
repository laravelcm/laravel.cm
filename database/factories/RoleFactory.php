<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

final class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'guard_name' => 'web',
        ];
    }

    public function admin()
    {
        return $this->state([
            'name' => 'admin',
        ]);
    }

    public function moderator()
    {
        return $this->state([
            'name' => 'moderator',
        ]);
    }
}
