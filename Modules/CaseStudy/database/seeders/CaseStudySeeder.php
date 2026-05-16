<?php

namespace Modules\CaseStudy\database\seeders;

use Illuminate\Database\Seeder;
use Modules\CaseStudy\app\Models\CaseStudy;

class CaseStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (CaseStudy::count() === 0) {
            CaseStudy::create([
                'title' => [
                    'en' => 'Digital Growth for Tech Co',
                    'ar' => 'النمو الرقمي لشركة تك',
                ],
                'slug' => 'digital-growth-tech-co',
                'description' => [
                    'en' => 'We helped them achieve 200% growth.',
                    'ar' => 'ساعدناهم في تحقيق نمو بنسبة 200٪.',
                ],
                'is_active' => true,
            ]);
        }
    }
}
