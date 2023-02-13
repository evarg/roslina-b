<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\packet>
 */
class PacketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'desc' => fake()->name(),
            'name_polish' => fake()->name(),
            'name_latin' => fake()->name(),
            'producer' => fake()->name(),
            'expiration_date' => fake()->date('Y_m_d','2030-03-01'),
            'purchase_date'  => fake()->date(),
        ];
    }
}
