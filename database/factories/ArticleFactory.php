<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'user_id' => $attributes['user_id'] ?? User::factory(),
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraphs(3, true),
            'slug' => $this->faker->unique()->slug(),
            'locale' => $this->faker->randomElement(['en', 'fr']),
        ];
    }

    public function approved(): self
    {
        return $this->state(function (array $attributes): array {
            return [
                'published_at' => now()->addDays(2),
                'submitted_at' => now(),
                'approved_at' => now(),
            ];
        });
    }

    public function submitted(): self
    {
        return $this->state(function (array $attributes): array {
            return [
                'submitted_at' => now(),
                'published_at' => now()->addDay(),
            ];
        });
    }
}
