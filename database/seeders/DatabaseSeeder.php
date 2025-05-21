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

       User::create([
            'name' => 'admin',
            'email' => 'sidi31@gmail.com',
            'password' => bcrypt('0'),
        ]);

        
    }
}
