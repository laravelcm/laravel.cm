<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enterprise>
 */
final class EnterpriseFactory extends Factory
{
    protected $model = Enterprise::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'slug' => fake()->unique()->slug(),
            'website' => fake()->unique()->url(),
            'about' => fake()->words(250, true),
            'address' => fake()->address(),
            'description' => fake()->sentence(10),
            'founded_in' => fake()->date('Y'),
            'ceo' => fake()->firstName(),
            'is_featured' => array_rand([true, false]),
            'is_certified' => array_rand([true, false]),
            'is_public' => array_rand([true, false]),
            'user_id' => User::factory(),
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (Enterprise $enterprise): void {
            $enterprise->addMediaFromUrl('https://source.unsplash.com/random/800x800/?img='.$enterprise->id)
                ->toMediaCollection('logo');
        });
    }
}
