<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->userName(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'avatar_type' => 'avatar',
        ];
    }

    public function unverified(): self
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }

    public function lastMonth(): self
    {
        return $this->state(fn (array $attributes): array => [
            'created_at' => now()->subMonth(),
        ]);
    }

    public function banned(): self
    {
        return $this->state(fn (array $attributes): array => [
            'banned_at' => now(),
            'banned_reason' => 'Violation des règles de la communauté',
        ]);
    }

    public function unbanned(): self
    {
        return $this->state(fn (array $attributes): array => [
            'banned_at' => null,
            'banned_reason' => null,
        ]);
    }
}
