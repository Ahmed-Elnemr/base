<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Modules\About\app\Models\AboutPage::create([
            'sub_title' => [
                'ar' => 'من نحن',
                'en' => 'About Us',
            ],
            'title' => [
                'ar' => 'وكالة الأرجواني',
                'en' => 'Purple Agency',
            ],
            'description' => [
                'ar' => 'وكالة إبداعية متخصصة في تصميم العلامات التجارية، التغليف، الجرافيك، المواقع، والتسويق الرقمي في سوريا ودمشق، نساعد الشركات على بناء صورة احترافية وتحويل أفكارها إلى حضور قوي في السوق.',
                'en' => 'A creative agency specializing in branding, packaging, graphic design, web design, and digital marketing in Syria and Damascus. We help companies build a professional image and transform their ideas into a strong market presence.',
            ],
            'is_active' => true,
        ]);
    }
}
