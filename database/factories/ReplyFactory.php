<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ReplyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'body' => $this->faker->text(),
            'user_id' => $attributes['user_id'] ?? User::factory(),
            'replyable_id' => Thread::factory(),
            'replyable_type' => Thread::class,
        ];
    }
}
