<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiscussionFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => $attributes['user_id'] ?? User::factory(),
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraphs(3, true),
            'slug' => $this->faker->unique()->slug(),
        ];
    }
}
