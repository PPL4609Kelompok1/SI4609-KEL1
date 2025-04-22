<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Produk ' . fake()->word(),
            'marketplace_url' => 'https://shopee.com/' . Str::slug(fake()->sentence(3)),
            'image_url' => fake()->imageUrl(640, 480, 'technology', true),
            'category' => fake()->randomElement(['solar', 'wind', 'bioenergy']),
            'brand' => fake()->company(),
            'price' => fake()->randomFloat(2, 100000, 5000000),
            'description' => fake()->paragraph(),
        ];
    }
}
