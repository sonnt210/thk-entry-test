<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hotel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::inRandomOrder()->first()->hotel_id,
            'customer_name' => $this->faker->name(),
            'customer_contact' => $this->faker->phoneNumber(),
            'checkin_time' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'checkout_time' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['checkin_time'], (clone $attributes['checkin_time'])->modify('+5 days'));
            },
        ];
    }
}
