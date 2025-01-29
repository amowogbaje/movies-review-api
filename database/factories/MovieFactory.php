<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'thumbnail' => $this->faker->imageUrl(),
            'release_date' => $this->faker->date,
            'genre' => $this->faker->randomElement(['Action', 'Comedy', 'Drama']),
        ];
    }
}
