<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ThreadFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(20),
            'body' => $this->faker->text(),
            'slug' => $this->faker->unique()->slug(),
            'user_id' => $attributes['user_id'] ?? User::factory(),
        ];
    }

    public function old(): self
    {
        return $this->state(['created_at' => now()->subMonths(7)]);
    }
}
