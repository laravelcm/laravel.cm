<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Thread>
 */
final class ThreadFactory extends Factory
{
    protected $model = Thread::class;

    public function definition(): array
    {
        return [
            'title' => fake()->text(20),
            'body' => fake()->text(),
            'slug' => fake()->unique()->slug(),
            'user_id' => $attributes['user_id'] ?? User::factory(),
        ];
    }

    public function old(): self
    {
        return $this->state(['created_at' => now()->subMonths(7)]);
    }
}
