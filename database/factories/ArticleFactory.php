<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
final class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        return [
            'user_id' => $attributes['user_id'] ?? User::factory(),
            'title' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'slug' => fake()->unique()->slug(),
            'locale' => fake()->randomElement(['en', 'fr']),
        ];
    }

    public function approved(): self
    {
        return $this->state(fn (array $attributes): array => [
            'published_at' => now()->addDays(2),
            'submitted_at' => now(),
            'approved_at' => now(),
        ]);
    }

    public function submitted(): self
    {
        return $this->state(fn (array $attributes): array => [
            'submitted_at' => now(),
            'published_at' => now()->addDay(),
        ]);
    }
}
