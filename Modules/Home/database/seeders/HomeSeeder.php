<?php

namespace Modules\Home\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Home\app\Models\HeroSection;
use Modules\Home\app\Models\WhyUsSection;
use Modules\Home\app\Models\WorkMethodSection;
use Modules\Home\app\Models\CTASection;
use Modules\Home\app\Models\HomeStat;
use Modules\Home\app\Models\Partner;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hero Section
        if (HeroSection::count() === 0) {
            HeroSection::create([
                'title' => [
                    'en' => 'Unlocking the Power of Digital Transformation',
                    'ar' => 'إطلاق العنان لقوة التحول الرقمي',
                ],
                'subtitle' => [
                    'en' => 'We create innovative solutions for your business growth.',
                    'ar' => 'نحن نصنع حلولاً مبتكرة لنمو عملك.',
                ],
                'button_text_1' => [
                    'en' => 'Our Services',
                    'ar' => 'خدماتنا',
                ],
                'button_text_2' => [
                    'en' => 'Contact Us',
                    'ar' => 'اتصل بنا',
                ],
                'button_url_1' => '/services',
                'button_url_2' => '/contact',
            ]);
        }

        // Why Us Section
        if (WhyUsSection::count() === 0) {
            WhyUsSection::create([
                'title' => [
                    'en' => 'Why Choose Us?',
                    'ar' => 'لماذا تختارنا؟',
                ],
                'content' => [
                    'en' => '<p>We provide the best solutions for your business.</p>',
                    'ar' => '<p>نحن نقدم أفضل الحلول لعملك.</p>',
                ],
                'points' => [
                    ['text' => 'Innovative Technology'],
                    ['text' => 'Expert Team'],
                    ['text' => '24/7 Support'],
                ],
            ]);
        }

        // Work Method Section
        if (WorkMethodSection::count() === 0) {
            WorkMethodSection::create([
                'title' => [
                    'en' => 'Our Work Method',
                    'ar' => 'طريقة عملنا',
                ],
                'steps' => [
                    [
                        'number' => '01',
                        'title' => 'Discovery',
                        'description' => 'We learn about your business goals.',
                    ],
                    [
                        'number' => '02',
                        'title' => 'Design',
                        'description' => 'We create the visual concept.',
                    ],
                ],
            ]);
        }

        // CTA Section
        if (CTASection::count() === 0) {
            CTASection::create([
                'title' => [
                    'en' => 'Ready to Start Your Project?',
                    'ar' => 'هل أنت جاهز لبدء مشروعك؟',
                ],
                'subtitle' => [
                    'en' => 'Get in touch with us today for a free consultation.',
                    'ar' => 'تواصل معنا اليوم للحصول على استشارة مجانية.',
                ],
                'button_text' => [
                    'en' => 'Contact Us Now',
                    'ar' => 'اتصل بنا الآن',
                ],
                'button_url' => '/contact',
            ]);
        }

        // Home Stats
        if (HomeStat::count() === 0) {
            HomeStat::create([
                'title' => [
                    'en' => 'Happy Clients',
                    'ar' => 'عملاء سعداء',
                ],
                'value' => '500+',
            ]);
            HomeStat::create([
                'title' => [
                    'en' => 'Projects Completed',
                    'ar' => 'مشاريع مكتملة',
                ],
                'value' => '1200+',
            ]);
        }

        // Partners
        if (Partner::count() === 0) {
            Partner::create([
                'name' => 'Partner 1',
            ]);
            Partner::create([
                'name' => 'Partner 2',
            ]);
        }
    }
}
