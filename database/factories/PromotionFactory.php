<?php

namespace Database\Factories;

use App\Models\Promotion;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $installmentsValue = $this->faker->boolean() ? $this->faker->randomFloat(2, 1, 12) : null;

        return [
            'title' => $this->faker->sentence(3),
            'link' => $this->faker->url(),
            'image' => $this->faker->imageUrl(640, 480, 'technics'),
            'was' => $this->faker->randomFloat(2, 20, 500),
            'for' => $this->faker->randomFloat(2, 5, 200),
            'description' => $this->faker->optional()->paragraph(),
            'code' => $this->faker->optional()->regexify('[A-Z]{10}'),
            'is_top' => $this->faker->boolean(20),
            'store_id' => Store::inRandomOrder()->first()->id,
            'installments' => $installmentsValue,
            'times' => $installmentsValue ? intval($installmentsValue * ($this->faker->numberBetween(1, 5))) : null,
        ];
    }

    public function fromStore(Store $store): static
    {
        return $this->afterMaking(function (Promotion $promotion) use ($store) {
            $promotion->store()->associate($store);
        });
    }
}
