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
                'ar_name' => 'مسكنات',
                'svg_logo' => 'analgesics.svg',
                'is_active' => true
            ],
            [
                'name' => 'Antibiotiques',
                'ar_name' => 'مضادات حيوية',
                'svg_logo' => 'antibiotics.svg',
                'is_active' => true
            ],
            [
                'name' => 'Anti-inflammatoires',
                'ar_name' => 'مضادات الالتهاب',
                'svg_logo' => 'anti-inflammatory.svg',
                'is_active' => true
            ],
            [
                'name' => 'Antihistaminiques',
                'ar_name' => 'مضادات الهيستامين',
                'svg_logo' => 'antihistamines.svg',
                'is_active' => true
            ],
            [
                'name' => 'Antihypertenseurs',
                'ar_name' => 'خافضات ضغط الدم',
                'svg_logo' => 'antihypertensives.svg',
                'is_active' => true
            ],
            [
                'name' => 'Antidiabétiques',
                'ar_name' => 'أدوية السكري',
                'svg_logo' => 'antidiabetics.svg',
                'is_active' => true
            ],
            [
                'name' => 'Vitamines et Suppléments',
                'ar_name' => 'فيتامينات ومكملات',
                'svg_logo' => 'vitamins.svg',
                'is_active' => true
            ],
            [
                'name' => 'Soins de la Peau',
                'ar_name' => 'العناية بالبشرة',
                'svg_logo' => 'skincare.svg',
                'is_active' => true
            ],
            [
                'name' => 'Soins Oculaires',
                'ar_name' => 'العناية بالعيون',
                'svg_logo' => 'eye-care.svg',
                'is_active' => true
            ],
            [
                'name' => 'Soins Dentaires',
                'ar_name' => 'العناية بالأسنان',
                'svg_logo' => 'dental-care.svg',
                'is_active' => true
            ],
            [
                'name' => 'Premiers Soins',
                'ar_name' => 'الإسعافات الأولية',
                'svg_logo' => 'first-aid.svg',
                'is_active' => true
            ],
            [
                'name' => 'Contraceptifs',
                'ar_name' => 'موانع الحمل',
                'svg_logo' => 'contraceptives.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Respiratoires',
                'ar_name' => 'أدوية الجهاز التنفسي',
                'svg_logo' => 'respiratory.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Cardiovasculaires',
                'ar_name' => 'أدوية القلب والأوعية الدموية',
                'svg_logo' => 'cardiovascular.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Gastro-intestinaux',
                'ar_name' => 'أدوية الجهاز الهضمي',
                'svg_logo' => 'gastrointestinal.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Psychiatriques',
                'ar_name' => 'أدوية الطب النفسي',
                'svg_logo' => 'psychiatric.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Oncologiques',
                'ar_name' => 'أدوية الأورام',
                'svg_logo' => 'oncology.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Hormonaux',
                'ar_name' => 'أدوية هرمونية',
                'svg_logo' => 'hormonal.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Anti-infectieux',
                'ar_name' => 'أدوية مضادة للعدوى',
                'svg_logo' => 'anti-infectious.svg',
                'is_active' => true
            ],
            [
                'name' => 'Médicaments Immunosuppresseurs',
                'ar_name' => 'مثبطات المناعة',
                'svg_logo' => 'immunosuppressants.svg',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
