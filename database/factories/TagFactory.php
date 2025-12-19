<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
final class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => fake()->text(15),
            'slug' => fake()->slug(),
            'concerns' => ['post', 'discussion', 'tutorial'],
        ];
    }

    public function article(): self
    {
        return $this->state(['concerns' => ['post', 'tutorial']]);
    }

    public function discussion(): self
    {
        return $this->state(['concerns' => ['discussion']]);
    }
}
