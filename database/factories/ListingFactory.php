<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ListingFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        return [
            'title' => fake()->sentence(),
            'tags' => 'api, laravel, backend',
            'company' => fake()->company(),
            'email' => fake()->unique()->safeEmail(),
            'website' => fake()->unique()->url(),
            'location' => fake()->city(),
            'description' => fake()->paragraph(5),
        ];
    }
}
