<?php

namespace Database\Factories;

use App\Models\Coupon;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->regexify('[A-Z]{10}'),
            'link' => $this->faker->url(),
            'description' => $this->faker->sentence(6),
            'store_id' => Store::inRandomOrder()->first()->id,
            'is_top' => $this->faker->boolean(20),
            'expires_at' => $this->faker->optional()->dateTimeBetween('now', '+3 months'),
        ];
    }

    public function fromStore(Store $store): static
    {
        return $this->afterMaking(function (Coupon $coupon) use ($store) {
            $coupon->store()->associate($store);
        });
    }
}
