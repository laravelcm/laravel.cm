<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Reply>
 */
final class ReplyFactory extends Factory
{
    protected $model = Reply::class;

    public function definition(): array
    {
        return [
            'body' => fake()->text(),
            'user_id' => $attributes['user_id'] ?? User::factory(),
            'replyable_id' => Thread::factory(),
            'replyable_type' => Thread::class,
        ];
    }
}
