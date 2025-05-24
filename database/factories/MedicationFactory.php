<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medication>
 */
class MedicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

                        'name' => $this->faker->unique()->word(),
            'category_id' => Category::factory(),
            'dosage_form' => $this->faker->randomElement(['Tablet', 'Capsule', 'Syrup', 'Injection', 'Ointment']),
            'strength' => $this->faker->randomElement(['500mg', '250mg', '100mg', '50mg', '10mg']),
            'generic_name' => $this->faker->word(),
            'barcode' => $this->faker->optional()->ean13(),
            'price' => $this->faker->numberBetween(50, 1000),
            'quantity' => $this->faker->numberBetween(0, 1000),
            'pharmacy_id' => Pharmacy::factory(),
        ];
    }
}
