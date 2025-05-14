<?php

namespace Database\Seeders;

use App\Models\Commande;
use App\Models\CommandeDetails;
use App\Models\Medicament;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@example.com',
        //     'password' => 'admin',
        // ]);

        $commande = Commande::create([
            'user_id' => 1,
            'uuid' => \Illuminate\Support\Str::uuid(),
            'date' => now(),
            'amount' => 290,
            'status' => "inProgress",

        ]);

        $medicament =[
             [
            'commande_id' => $commande->id,
            'name' => "test",
            'price' => 20,
            'quantity' => 2,
             ],
             [
            'commande_id' => $commande->id,
            'name' => "test2",
            'price' => 56,
            'quantity' => 5,
             ],
             [
            'commande_id' => $commande->id,
            'name' => "test3",
            'price' => 19,
            'quantity' => 10,
             ],
             [
            'commande_id' => $commande->id,
            'name' => "test 4",
            'price' => 18.5,
            'quantity' => 1,
             ],
    ];

        CommandeDetails::insert($medicament);

    }
}
