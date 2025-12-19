<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Channel>
 */
final class ChannelFactory extends Factory
{
    protected $model = Channel::class;

    public function definition(): array
    {
        return [
            'name' => fake()->text(15),
            'slug' => fake()->unique()->slug(),
        ];
    }
}
