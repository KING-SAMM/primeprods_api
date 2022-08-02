<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prototype>
 */
class PrototypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(2),
            // 'image' => fake()->imageUrl(),
            'tags' => fake()->sentence(2),
            'company' => fake()->company(),
            'location' => fake()->city(),
            'email' => fake()->companyEmail(),
            // 'logo' => fake()->imageUrl(),
            'website' => fake()->domainName(),
            'description' => fake()->paragraph(5),
        ];
    }
}
