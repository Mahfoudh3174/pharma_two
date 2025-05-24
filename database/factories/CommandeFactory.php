<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commande>
 */
class CommandeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'user_id' => User::factory(),
            'pharmacy_id' => Pharmacy::factory(),
            'status' => $this->faker->randomElement(['inProgress', 'validated', 'rejected']),
            'reject_reason' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}
