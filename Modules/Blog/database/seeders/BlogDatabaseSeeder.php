<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Blog\app\Models\BlogPost;

class BlogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample blog posts with translations and media
        $posts = [
            [
                'title' => [
                    'ar' => 'أفضل النصائح لتنظيف محرك السيارة',
                    'en' => 'Best Tips for Cleaning Your Car Engine',
                ],
                'description' => [
                    'ar' => 'تعرف على أفضل الطرق والمواد المستخدمة للحفاظ على نظافة محرك سيارتك.',
                    'en' => 'Learn the best methods and materials to keep your car engine clean.',
                ],
                'slug' => 'car-engine-cleaning-tips',
                'keywords' => [
                    'ar' => ['تنظيف المحرك', 'نصائح السيارات', 'صيانة'],
                    'en' => ['engine cleaning', 'car tips', 'maintenance'],
                ],
                'content' => [
                    'ar' => '<p>يعد تنظيف محرك السيارة جزءاً هاماً من الصيانة الدورية. يساعد ذلك في اكتشاف التسريبات مبكراً والحفاظ على كفاءة التبريد...</p>',
                    'en' => '<p>Cleaning the car engine is an important part of regular maintenance. This helps in detecting leaks early and maintaining cooling efficiency...</p>',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => [
                    'ar' => 'كيف تختار زيت المحرك المناسب لسيارتك؟',
                    'en' => 'How to Choose the Right Engine Oil for Your Car?',
                ],
                'description' => [
                    'ar' => 'دليل شامل لاختيار درجة اللزوجة ونوع الزيت الأنسب لمناخ منطقتك.',
                    'en' => 'A comprehensive guide to choosing the viscosity grade and oil type most suitable for your region\'s climate.',
                ],
                'slug' => 'choosing-the-right-engine-oil',
                'keywords' => [
                    'ar' => ['زيت المحرك', 'زيوت السيارات', 'نصائح'],
                    'en' => ['engine oil', 'car lubricants', 'tips'],
                ],
                'content' => [
                    'ar' => '<p>يعتبر زيت المحرك بمثابة شريان الحياة لسيارتك. اختيار النوع الخاطئ قد يؤدي إلى تآكل سريع في الأجزاء الداخلية...</p>',
                    'en' => '<p>Engine oil is the lifeblood of your car. Choosing the wrong type can lead to rapid wear of internal parts...</p>',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => [
                    'ar' => 'أهمية الفحص الدوري للإطارات قبل السفر',
                    'en' => 'Importance of Periodic Tire Inspection Before Travel',
                ],
                'description' => [
                    'ar' => 'لا تغفل عن فحص ضغط الإطارات وحالتها العامة لضمان سلامتك على الطريق.',
                    'en' => 'Do not overlook checking tire pressure and their general condition to ensure your safety on the road.',
                ],
                'slug' => 'tire-inspection-before-travel',
                'keywords' => [
                    'ar' => ['إطارات السيارات', 'سلامة الطريق', 'سفر'],
                    'en' => ['car tires', 'road safety', 'travel'],
                ],
                'content' => [
                    'ar' => '<p>تعتبر الإطارات هي نقطة الاتصال الوحيدة لسيارتك مع الأرض، لذا فإن حالتها تؤثر بشكل مباشر على استقرار السيارة وكفاءة المكابح...</p>',
                    'en' => '<p>Tires are your car\'s only point of contact with the ground, so their condition directly affects the car\'s stability and braking efficiency...</p>',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($posts as $postData) {
            $post = BlogPost::updateOrCreate(['slug' => $postData['slug']], $postData);

            // Adding dummy media if not already present
            if ($post->getMedia('thumbnail')->isEmpty()) {
                $post->addMediaFromUrl('https://placehold.co/600x400/ED6F31/white?text=Thumbnail+' . urlencode($post->getTranslation('title', 'en')))
                    ->toMediaCollection('thumbnail');
            }

            if ($post->getMedia('preview_image')->isEmpty()) {
                $post->addMediaFromUrl('https://placehold.co/1200x600/ED6F31/white?text=Preview+' . urlencode($post->getTranslation('title', 'en')))
                    ->toMediaCollection('preview_image');
            }
        }
    }
}
