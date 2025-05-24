<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Commande;
use App\Models\Medication;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('0'),
        ]);

        // Create regular users
        $users = User::factory(10)->create();
        
        // Create categories
        $categories = Category::factory(10)->create();
        
        // Create pharmacies with owners
        $pharmacies = Pharmacy::factory(10)->create([
            'user_id' => fn() => $users->random()->id,
        ]);
        
        // Create medications
        $medications = Medication::factory(50)->create([
            'category_id' => fn() => $categories->random()->id,
            'pharmacy_id' => fn() => $pharmacies->random()->id,
        ]);
        
        // Create orders
        $commandes = Commande::factory(20)->create([
            'pharmacy_id' => fn() => $pharmacies->random()->id,
            'status' => fn() => $faker->randomElement(['inProgress', 'validated', 'rejected']),
            'user_id' => fn() => $users->random()->id,
            'reject_reason' => fn(array $attributes) => 
                $attributes['status'] === 'rejected' 
                    ? $faker->sentence() 
                    : null,
        ]);

        // Attach medications to orders - CORRECTED VERSION
        $commandes->each(function ($commande) use ($medications, $faker) {
            $medsToAttach = $medications->random(rand(1, 5));
            
            $medsToAttach->each(function ($med) use ($commande, $faker) {
                $quantity = $faker->numberBetween(1, 10);
                $commande->medications()->attach($med->id, [
                    'quantity' => $quantity,
                    'price' => $med->price, 
                    'total_price' => $med->price * $quantity,
                ]);
            });
        });
    }
}