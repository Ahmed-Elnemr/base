<?php

namespace Modules\Portfolio\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Portfolio\app\Models\Work;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Work::count() === 0) {
            Work::create([
                'title' => [
                    'en' => 'E-commerce Redesign',
                    'ar' => 'إعادة تصميم متجر إلكتروني',
                ],
                'subtitle' => [
                    'en' => 'Web Design',
                    'ar' => 'تصميم مواقع',
                ],
                'type' => 'web',
                'is_active' => true,
            ]);

            Work::create([
                'title' => [
                    'en' => 'Corporate Branding',
                    'ar' => 'هوية بصرية للشركات',
                ],
                'subtitle' => [
                    'en' => 'Branding',
                    'ar' => 'هوية بصرية',
                ],
                'type' => 'branding',
                'is_active' => true,
            ]);
        }
    }
}
