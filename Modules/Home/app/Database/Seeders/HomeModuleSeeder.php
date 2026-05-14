<?php

namespace Modules\Home\app\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Home\app\Models\HeroSection;
use Modules\Home\app\Models\WhyUsSection;
use Modules\Home\app\Models\Partner;
use Modules\Home\app\Models\HomeStat;
use Modules\Home\app\Models\WorkMethodSection;
use Modules\Home\app\Models\CTASection;
use Illuminate\Support\Facades\File;

class HomeModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultImage = public_path('defultimage.png.jpg');

        // Hero Section
        if (HeroSection::count() == 0) {
            $hero = HeroSection::create([
                'title' => [
                    'en' => 'We Build Brands',
                    'ar' => 'نحن نبني العلامات التجارية',
                ],
                'subtitle' => [
                    'en' => 'Everything that comes to your mind about developing your brand...',
                    'ar' => 'كل ما يخطر ببالك حول تطوير علامتك التجارية في التصميم، التغليف، التسويق...',
                ],
                'button_text_1' => ['en' => 'Book a Consultation', 'ar' => 'احجز استشارة'],
                'button_text_2' => ['en' => 'View Works', 'ar' => 'شاهد الأعمال'],
                'button_url_1' => '/contact',
                'button_url_2' => '/portfolio',
            ]);

            if (File::exists($defaultImage)) {
                $hero->addMedia($defaultImage)->preservingOriginal()->toMediaCollection('hero_image');
            }
        }

        // Why Us Section
        if (WhyUsSection::count() == 0) {
            $whyUs = WhyUsSection::create([
                'title' => [
                    'en' => 'Why Us?',
                    'ar' => 'لماذا نحن؟',
                ],
                'content' => [
                    'en' => 'We are not just designers, we build growth-ready brands.',
                    'ar' => 'لسنا مجرد مصممين، نحن نبني علامات قابلة للنمو.',
                ],
                'points' => [
                    'en' => [
                        ['text' => 'We start with strategy before design.'],
                        ['text' => 'We cover the entire brand journey.'],
                        ['text' => 'Designs suitable for the local and international market.'],
                    ],
                    'ar' => [
                        ['text' => 'نبدأ بالاستراتيجية قبل التصميم.'],
                        ['text' => 'نغطي كل رحلة العلامة التجارية.'],
                        ['text' => 'تصميم مناسب للسوق المحلي والعالمي.'],
                    ],
                ],
            ]);

            if (File::exists($defaultImage)) {
                $whyUs->addMedia($defaultImage)->preservingOriginal()->toMediaCollection('why_us_image');
            }
        }

        // Work Method Section
        if (WorkMethodSection::count() == 0) {
            WorkMethodSection::create([
                'title' => [
                    'en' => 'From Idea to Market',
                    'ar' => 'من الفكرة إلى السوق',
                ],
                'steps' => [
                    'en' => [
                        ['number' => '01', 'title' => 'Search', 'description' => 'Market and competitor analysis.'],
                        ['number' => '02', 'title' => 'Strategy', 'description' => 'Defining the message and positioning.'],
                        ['number' => '03', 'title' => 'Design', 'description' => 'Visual identity and applications.'],
                        ['number' => '04', 'title' => 'Launch', 'description' => 'Handover and preparation for publishing.'],
                    ],
                    'ar' => [
                        ['number' => '01', 'title' => 'بحث', 'description' => 'تحليل السوق والمنافسين والجمهور.'],
                        ['number' => '02', 'title' => 'استراتيجية', 'description' => 'تحديد الرسالة والتموضع والشخصية.'],
                        ['number' => '03', 'title' => 'تصميم', 'description' => 'بناء الشكل البصري والتطبيقات.'],
                        ['number' => '04', 'title' => 'إطلاق', 'description' => 'تسليم وتجهيز للنشر والطباعة.'],
                    ],
                ],
            ]);
        }

        // CTA Section
        if (CTASection::count() == 0) {
            CTASection::create([
                'title' => [
                    'en' => 'This site is not just a showcase site',
                    'ar' => 'هذا الموقع ليس موقع استعراضي فقط',
                ],
                'subtitle' => [
                    'en' => 'It is a selling tool, trust, and appearance. That is why we design each section to serve the customer decision and lead them to communicate with you.',
                    'ar' => 'إنه أداة بيع، ثقة، وظهور. لذلك نصمم كل قسم ليخدم قرار العميل ويقوده للتواصل معك.',
                ],
                'button_text' => [
                    'en' => 'Start Now',
                    'ar' => 'ابدأ الآن',
                ],
                'button_url' => '/contact',
            ]);
        }

        // Partners
        if (Partner::count() == 0) {
            $partners = ['ZEN', 'MIRA', 'LUXE', 'VITA', 'AMBER', 'ORO'];
            foreach ($partners as $index => $name) {
                $partner = Partner::create([
                    'name' => $name,
                    'is_active' => true,
                    'sort_order' => $index,
                ]);

                if (File::exists($defaultImage)) {
                    $partner->addMedia($defaultImage)->preservingOriginal()->toMediaCollection('logo');
                }
            }
        }

        // Stats
        if (HomeStat::count() == 0) {
            $stats = [
                ['en' => 'Years of Experience', 'ar' => 'سنة خبرة', 'value' => '23+'],
                ['en' => 'Integrated Solutions', 'ar' => 'حلول متكاملة', 'value' => '360°'],
                ['en' => 'Projects Done', 'ar' => 'مشروع', 'value' => '400+'],
                ['en' => 'Digital Campaigns', 'ar' => 'حملة رقمية', 'value' => '45+'],
            ];

            foreach ($stats as $index => $stat) {
                HomeStat::create([
                    'title' => [
                        'en' => $stat['en'],
                        'ar' => $stat['ar'],
                    ],
                    'value' => $stat['value'],
                    'is_active' => true,
                    'sort_order' => $index,
                ]);
            }
        }
    }
}
