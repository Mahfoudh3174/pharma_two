<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove all old categories (not needed with migrate:fresh)
        // Category::truncate();

        $categories = [
            [
                'name' => 'Analgésiques',
                'svg_logo' => 'analgesics.svg',
                'is_active' => true
            ],
            [
                'name' => 'Antibiotiques',
                'svg_logo' => 'antibiotics.svg',
                'is_active' => true
            ],
            [
                'name' => 'Anti-inflammatoires',
                'svg_logo' => 'anti-inflammatory.svg',
                'is_active' => true
            ],
            [
                'name' => 'Antihistaminiques',
                'svg_logo' => 'antihistamines.svg',
                'is_active' => true
            ],
            [
                'name' => 'Antihypertenseurs',
                'svg_logo' => 'antihypertensives.svg',
                'is_active' => true
            ],
            [
                'name' => 'Antidiabétiques',
                'svg_logo' => 'antidiabetics.svg',
                'is_active' => true
            ],
            [
                'name' => 'Vitamines et Suppléments',
                'svg_logo' => 'vitamins.svg',
                'is_active' => true
            ],
            [
                'name' => 'Soins de la Peau',
                'svg_logo' => 'skincare.svg',
                'is_active' => true
            ],
            [
                'name' => 'Soins Oculaires',
                'svg_logo' => 'eye-care.svg',
                'is_active' => true
            ],
            [
                'name' => 'Soins Dentaires',
                'svg_logo' => 'dental-care.svg',
                'is_active' => true
            ],
            [
                'name' => 'Premiers Soins',
                'svg_logo' => 'first-aid.svg',
                'is_active' => true
            ],
            [
                'name' => 'Contraceptifs',
                'svg_logo' => 'contraceptives.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Respiratoires',
                'svg_logo' => 'respiratory.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Cardiovasculaires',
                'svg_logo' => 'cardiovascular.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Gastro-intestinaux',
                'svg_logo' => 'gastrointestinal.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Psychiatriques',
                'svg_logo' => 'psychiatric.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Oncologiques',
                'svg_logo' => 'oncology.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Hormonaux',
                'svg_logo' => 'hormonal.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Anti-infectieux',
                'svg_logo' => 'anti-infectious.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Immunosuppresseurs',
                'svg_logo' => 'immunosuppressants.svg',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
