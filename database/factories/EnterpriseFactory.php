<?php

namespace Database\Factories;

use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enterprise>
 */
class EnterpriseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'slug' => $this->faker->unique()->slug(),
            'website' => $this->faker->unique()->url(),
            'about' => $this->faker->words(250, true),
            'address' => $this->faker->address(),
            'description' => $this->faker->sentence(10),
            'founded_in' => $this->faker->date('Y'),
            'ceo' => $this->faker->firstName(),
            'is_featured' => array_rand([true, false]),
            'is_certified' => array_rand([true, false]),
            'is_public' => array_rand([true, false]),
            'user_id' => array_rand(User::all()->modelKeys()),
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (Enterprise $enterprise) {
            $enterprise->addMediaFromUrl("https://source.unsplash.com/random/800x800/?img={$enterprise->id}")
                ->toMediaCollection('logo');
        });
    }
}
