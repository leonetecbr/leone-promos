<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->slug(),
            'name' => $this->faker->company(),
            'image' => $this->faker->imageUrl(640, 480, 'business'),
            'link' => $this->faker->url(),
            'is_top' => $this->faker->boolean(20), // 20% chance to be true
        ];
    }
}
