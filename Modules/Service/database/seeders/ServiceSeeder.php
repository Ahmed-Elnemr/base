<?php

namespace Modules\Service\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Service\app\Models\Service;
use Modules\Service\app\Models\ServiceCategory;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (ServiceCategory::count() === 0) {
            $branding = ServiceCategory::create([
                'name' => [
                    'en' => 'Branding',
                    'ar' => 'العلامات التجارية',
                ],
                'is_active' => true,
            ]);

            $digital = ServiceCategory::create([
                'name' => [
                    'en' => 'Digital Marketing',
                    'ar' => 'التسويق الرقمي',
                ],
                'is_active' => true,
            ]);

            Service::create([
                'service_category_id' => $branding->id,
                'title' => [
                    'en' => 'Logo Design',
                    'ar' => 'تصميم الشعار',
                ],
                'slug' => 'logo-design',
                'short_description' => [
                    'en' => 'We create unique and memorable logos.',
                    'ar' => 'نحن نصنع شعارات فريدة ولا تُنسى.',
                ],
                'description' => [
                    'en' => 'Professional logo design services to help establish your brand identity.',
                    'ar' => 'خدمات تصميم شعار احترافية لمساعدتك في ترسيخ هوية علامتك التجارية.',
                ],
                'is_active' => true,
            ]);

            Service::create([
                'service_category_id' => $digital->id,
                'title' => [
                    'en' => 'SEO Optimization',
                    'ar' => 'تحسين محركات البحث',
                ],
                'slug' => 'seo-optimization',
                'short_description' => [
                    'en' => 'Increase your visibility on search engines.',
                    'ar' => 'قم بزيادة ظهورك على محركات البحث.',
                ],
                'description' => [
                    'en' => 'Complete search engine optimization to boost your website traffic and rankings.',
                    'ar' => 'تحسين كامل لمحركات البحث لزيادة زيارات موقعك وتحسين ترتيبه.',
                ],
                'is_active' => true,
            ]);
        }
    }
}
